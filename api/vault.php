<?php
if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && str_contains($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) {
    ob_start('ob_gzhandler');
}
header('Content-Type: application/json');
header('Cache-Control: public, max-age=300, s-maxage=300');
header('Vary: Accept-Encoding');

$csv_file = file_exists(__DIR__ . '/../games_list.csv')
            ? __DIR__ . '/../games_list.csv'
            : realpath(__DIR__ . '/../../../games_list.csv');

// Temporarily hidden domains - games preserved in CSV, just not shown
$hidden_domains = ['watermelon46.com', 'html5.gamedistribution.com'];

$data = [];
if ($csv_file && ($fh = fopen($csv_file, 'r')) !== false) {
    fgetcsv($fh, 0, ',', '"', '\\'); // skip header
    while (($row = fgetcsv($fh, 0, ',', '"', '\\')) !== false) {
        if (count($row) >= 4) {
            $raw_src = $row[2];
            // Skip hidden domains
            $skip = false;
            foreach ($hidden_domains as $d) {
                if (str_contains($raw_src, $d)) { $skip = true; break; }
            }
            if ($skip) continue;
            $code    = $row[0];
            // 1. Try code-based local thumb (watermelon46 / duckmath games)
            $local_thumb = null;
            foreach (['.webp', '.jpg', '.png', '.jpeg'] as $ext) {
                if (file_exists(__DIR__ . '/../thumbs/' . $code . $ext)) {
                    $local_thumb = '/thumbs/' . $code . $ext;
                    break;
                }
            }
            // 2. Try slug-based local thumb (geet .jpg or gameinclassroom .png), webp first
            if (!$local_thumb) {
                preg_match('#/get/([^/]+)/#', $raw_src, $mg);
                preg_match('#github\.io/([^/]+)/#', $raw_src, $mb);
                $geet_id = $mg[1] ?? '';
                $bro_id  = $mb[1] ?? '';
                if ($geet_id) {
                    foreach (['.webp', '.jpg', '.png'] as $ext) {
                        if (file_exists(__DIR__ . '/../thumbs/' . $geet_id . $ext)) {
                            $local_thumb = '/thumbs/' . $geet_id . $ext; break;
                        }
                    }
                } elseif ($bro_id) {
                    foreach (['.webp', '.png', '.jpg'] as $ext) {
                        if (file_exists(__DIR__ . '/../thumbs/' . $bro_id . $ext)) {
                            $local_thumb = '/thumbs/' . $bro_id . $ext; break;
                        }
                    }
                }
            }
            // 3. Fallback to CDN URL
            if (!$local_thumb) {
                $local_thumb = $row[3];
            }
            // Only wrap geet.in.net through edumathtools player (other hosts go direct)
            $iframe_url = str_contains($raw_src, 'geet.in.net')
                ? 'https://edumathtools.com/player?src=' . urlencode($raw_src)
                : $raw_src;
            $data[] = [
                'code'     => $row[0],
                'name'     => $row[1],
                'iframe'   => $iframe_url,
                'thumb'    => $local_thumb,
                'category' => isset($row[5]) ? strtolower(trim($row[5])) : '',
            ];
        }
    }
    fclose($fh);
}

echo json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_SLASHES);
