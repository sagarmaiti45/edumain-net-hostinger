<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db.php';

$method = $_SERVER['REQUEST_METHOD'];

// ── GET: list all games with vote percentages ──────────────────────
if ($method === 'GET') {
    try {
        $db    = getDb();
        $games = $db->query("
            SELECT id, game_name, is_preset, total_votes, status
            FROM req_games
            WHERE status != 'rejected'
            ORDER BY is_preset DESC, id ASC
        ")->fetchAll();

        $total = array_sum(array_column($games, 'total_votes'));

        foreach ($games as &$g) {
            $g['id']          = (int) $g['id'];
            $g['total_votes'] = (int) $g['total_votes'];
            $g['is_preset']   = (bool) $g['is_preset'];
            $g['percentage']  = $total > 0
                ? round(($g['total_votes'] / $total) * 100, 1)
                : 0;
        }

        echo json_encode(['games' => $games, 'total_votes' => (int) $total]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'DB error', 'detail' => $e->getMessage()]);
    }
    exit;
}

// ── POST: submit vote or custom request ───────────────────────────
if ($method === 'POST') {
    $data    = json_decode(file_get_contents('php://input'), true) ?? [];
    $anon_id = trim($data['anonymous_id'] ?? '');
    $game_id = intval($data['game_id'] ?? 0);
    $custom  = trim($data['custom_name'] ?? '');

    if (!$anon_id || strlen($anon_id) < 10 || strlen($anon_id) > 80) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request']);
        exit;
    }

    try {
        $db = getDb();

        // Custom game name → find or create entry
        if ($custom && !$game_id) {
            if (strlen($custom) > 80) {
                http_response_code(400);
                echo json_encode(['error' => 'Name too long (max 80 chars)']);
                exit;
            }
            $existing = $db->prepare("SELECT id FROM req_games WHERE LOWER(game_name) = LOWER(?)");
            $existing->execute([$custom]);
            $found = $existing->fetchColumn();

            if ($found) {
                $game_id = (int) $found;
            } else {
                $ins = $db->prepare(
                    "INSERT INTO req_games (game_name, is_preset, status) VALUES (?, FALSE, 'pending') RETURNING id"
                );
                $ins->execute([$custom]);
                $game_id = (int) $ins->fetchColumn();
            }
        }

        if (!$game_id) {
            http_response_code(400);
            echo json_encode(['error' => 'No game selected']);
            exit;
        }

        // Insert vote - duplicate silently ignored
        try {
            $db->prepare("INSERT INTO req_votes (game_id, anonymous_id) VALUES (?, ?)")
               ->execute([$game_id, $anon_id]);

            // Sync total_votes count
            $db->prepare("
                UPDATE req_games
                SET total_votes = (SELECT COUNT(*) FROM req_votes WHERE game_id = ?)
                WHERE id = ?
            ")->execute([$game_id, $game_id]);

            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            // UNIQUE violation = already voted
            echo json_encode(['success' => false, 'error' => 'already_voted']);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'DB error']);
    }
    exit;
}

http_response_code(405);
echo json_encode(['error' => 'Method not allowed']);
