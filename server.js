const express = require('express');
const { spawnSync } = require('child_process');
const path = require('path');
const fs = require('fs');

const app = express();
const PORT = process.env.PORT || 3000;
const ROOT = __dirname;

// ── CSV parser (no external deps) ───────────────────────────────────────────
function parseCSVRow(line) {
  const fields = [];
  let i = 0;
  while (i <= line.length) {
    if (i === line.length) { fields.push(''); break; }
    if (line[i] === '"') {
      let field = ''; i++;
      while (i < line.length) {
        if (line[i] === '"' && line[i + 1] === '"') { field += '"'; i += 2; }
        else if (line[i] === '"') { i++; break; }
        else { field += line[i++]; }
      }
      fields.push(field);
      if (line[i] === ',') i++;
    } else {
      const end = line.indexOf(',', i);
      if (end === -1) { fields.push(line.slice(i)); break; }
      fields.push(line.slice(i, end));
      i = end + 1;
    }
  }
  return fields;
}

// ── Body parsing ─────────────────────────────────────────────────────────────
app.use(express.urlencoded({ extended: true }));
app.use(express.json());

// ── Static assets ─────────────────────────────────────────────────────────────
app.use('/assets', express.static(path.join(ROOT, 'assets')));
app.use('/thumbs', express.static(path.join(ROOT, 'thumbs')));
app.use('/ads.txt', express.static(path.join(ROOT, 'ads.txt')));
app.use('/robots.txt', express.static(path.join(ROOT, 'robots.txt')));
app.use('/favicon.ico', express.static(path.join(ROOT, 'assets/img/logo.png')));

// ── Vault API — native Node.js, no PHP needed ────────────────────────────────
app.get(['/api/vault.php', '/api/vault'], (req, res) => {
  const csvPath = path.join(ROOT, 'games_list.csv');
  if (!fs.existsSync(csvPath)) {
    return res.setHeader('Content-Type', 'application/json').json([]);
  }

  const lines = fs.readFileSync(csvPath, 'utf8').split(/\r?\n/);
  const hiddenDomains = ['watermelon46.com', 'html5.gamedistribution.com'];
  const thumbExts = ['.webp', '.jpg', '.png', '.jpeg'];
  const data = [];

  for (let i = 1; i < lines.length; i++) {
    const line = lines[i].trim();
    if (!line) continue;
    const row = parseCSVRow(line);
    if (row.length < 4) continue;

    const code     = row[0];
    const name     = row[1];
    const rawSrc   = row[2];
    const thumbCdn = row[3];
    const category = (row[5] || '').toLowerCase().trim();

    if (hiddenDomains.some(d => rawSrc.includes(d))) continue;

    // 1. Try code-based local thumb
    let thumb = null;
    for (const ext of thumbExts) {
      if (fs.existsSync(path.join(ROOT, 'thumbs', code + ext))) {
        thumb = '/thumbs/' + code + ext; break;
      }
    }

    // 2. Try slug-based local thumb
    if (!thumb) {
      const geetMatch = rawSrc.match(/\/get\/([^/]+)\//);
      const broMatch  = rawSrc.match(/github\.io\/([^/]+)\//);
      const tryId = (geetMatch && geetMatch[1]) || (broMatch && broMatch[1]) || '';
      if (tryId) {
        for (const ext of thumbExts) {
          if (fs.existsSync(path.join(ROOT, 'thumbs', tryId + ext))) {
            thumb = '/thumbs/' + tryId + ext; break;
          }
        }
      }
    }

    // 3. Fallback to CDN URL from CSV
    if (!thumb) thumb = thumbCdn || '';

    const iframeUrl = rawSrc.includes('geet.in.net')
      ? 'https://edumathtools.com/player?src=' + encodeURIComponent(rawSrc)
      : rawSrc;

    data.push({ code, name, iframe: iframeUrl, thumb, category });
  }

  res.setHeader('Content-Type', 'application/json');
  res.setHeader('Cache-Control', 'public, max-age=300');
  res.json(data);
});

// ── All other routes → PHP CLI ────────────────────────────────────────────────
app.use((req, res) => {
  const uri = req.originalUrl;

  const env = {
    ...process.env,
    REQUEST_URI: uri,
    REQUEST_METHOD: req.method,
    DOCUMENT_ROOT: ROOT,
    SERVER_NAME: req.hostname || 'localhost',
    HTTP_HOST: req.headers.host || 'localhost',
    HTTP_USER_AGENT: req.headers['user-agent'] || '',
    HTTP_ACCEPT: req.headers['accept'] || '',
    HTTP_ACCEPT_LANGUAGE: req.headers['accept-language'] || '',
    HTTP_ACCEPT_ENCODING: '',
    QUERY_STRING: uri.includes('?') ? uri.split('?')[1] : '',
    PATH_INFO: req.path,
    SCRIPT_FILENAME: path.join(ROOT, 'router.php'),
    SCRIPT_NAME: '/router.php',
    SERVER_PROTOCOL: 'HTTP/1.1',
    REDIRECT_STATUS: '200',
    CONTENT_TYPE: req.headers['content-type'] || '',
    CONTENT_LENGTH: req.headers['content-length'] || '0',
  };

  const result = spawnSync('php', [path.join(ROOT, 'router.php')], {
    env,
    timeout: 30000,
    maxBuffer: 10 * 1024 * 1024,
  });

  if (result.error) {
    console.error('[PHP not found]', result.error.message);
    return res.status(503).send(
      '<html><head><title>PHP Required</title></head><body>' +
      '<h1>Server Configuration Error</h1>' +
      '<p>PHP CLI 8.0+ is required. Please install it on this server.</p>' +
      '</body></html>'
    );
  }

  const output = result.stdout ? result.stdout.toString('utf8') : '';
  const stderr = result.stderr ? result.stderr.toString('utf8') : '';

  if (result.status !== 0 && !output) {
    console.error('[PHP error]', stderr);
    return res.status(500).send('<html><body><h1>500 Internal Server Error</h1></body></html>');
  }

  if (stderr && process.env.NODE_ENV !== 'production') {
    console.warn('[PHP stderr]', stderr.substring(0, 500));
  }

  res.setHeader('Content-Type', 'text/html; charset=utf-8');
  res.setHeader('X-Powered-By', 'Express');
  res.send(output);
});

app.listen(PORT, () => {
  console.log(`EduMain running on http://localhost:${PORT}`);
});
