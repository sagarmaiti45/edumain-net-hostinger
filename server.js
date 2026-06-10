const express = require('express');
const path = require('path');
const fs = require('fs');

const app = express();
const PORT = process.env.PORT || 3000;
const ROOT = __dirname;

// ── Global Config & Constants ────────────────────────────────────────────────
const SITE_NAME = 'EduMain';
const SITE_SHORT_NAME = 'EduMain';
const SITE_TAGLINE = 'School Topics Explained Simply';
const SITE_DESCRIPTION = 'EduMain explains school curriculum topics simply for students aged 6-16. Free explainers for Maths, Science, History, English, Geography and more - used by students in the USA, UK, Australia and Spain.';

const IS_DEV = process.env.NODE_ENV !== 'production';

const SITE_URL = 'https://edumain.net';
const CDN_URL = 'https://learn.edumain.net';
const THUMB_URL = CDN_URL + '/thumbs';
const GAMES_URL = CDN_URL + '/games';

const CONTACT_EMAIL = 'support@edumain.net';

const ADSENSE_ID = '';
const GA_ID = 'G-J4XN9750P7';

const COLOR_BG = '#f0f9ff';
const COLOR_BG2 = '#ffffff';
const COLOR_BG3 = '#e0f2fe';
const COLOR_CARD = '#ffffff';
const COLOR_CARD_HOVER = '#f0f9ff';
const COLOR_ACCENT = '#0ea5e9';
const COLOR_ACCENT2 = '#38bdf8';
const COLOR_TEXT = '#0c1a2e';
const COLOR_TEXT_MUTED = '#4b6a8a';
const COLOR_BORDER = '#bae6fd';

const META_KEYWORDS = 'school topics explained, homework help, educational articles for kids, maths explained simply, science for students, history for kids, geography explained, english grammar help, edumain';
const TWITTER_HANDLE = '';
const SITE_YEAR = new Date().getFullYear();

const SUBJECTS = [
  {slug:'math',      name:'Maths',     icon:'fa-calculator',     color:'#3b82f6', bg:'#eff6ff', desc:'Numbers, algebra, geometry & statistics'},
  {slug:'science',   name:'Science',   icon:'fa-flask',          color:'#22c55e', bg:'#f0fdf4', desc:'Biology, chemistry, physics & space'},
  {slug:'history',   name:'History',   icon:'fa-landmark',       color:'#f97316', bg:'#fff7ed', desc:'World events, empires & revolutions'},
  {slug:'english',   name:'English',   icon:'fa-book-open',      color:'#a855f7', bg:'#faf5ff', desc:'Grammar, writing & literature'},
  {slug:'geography', name:'Geography', icon:'fa-earth-americas', color:'#14b8a6', bg:'#f0fdfa', desc:'Countries, climate & physical features'},
  {slug:'art',       name:'Art',       icon:'fa-palette',        color:'#ec4899', bg:'#fdf2f8', desc:'Techniques, artists & art history'},
  {slug:'music',     name:'Music',     icon:'fa-music',          color:'#eab308', bg:'#fefce8', desc:'Theory, instruments & music history'},
  {slug:'computing', name:'Computing', icon:'fa-laptop-code',    color:'#6366f1', bg:'#eef2ff', desc:'Coding, algorithms & digital skills'},
  {slug:'pe',        name:'PE',        icon:'fa-person-running', color:'#ef4444', bg:'#fef2f2', desc:'Sports, fitness & health'},
  {slug:'languages', name:'Languages', icon:'fa-language',       color:'#f43f5e', bg:'#fff1f2', desc:'Spanish, French, German & more'},
  {slug:'math-tools',name:'Math Tools',icon:'fa-calculator',     color:'#0ea5e9', bg:'#f0f9ff', desc:'Interactive calculators & solvers', is_tools:true},
];

const slugs = SUBJECTS.map(s => s.slug);
const TOOLS = [
  {slug:'fraction-calculator',    name:'Fraction Calculator',       icon:'fa-divide',          color:'#a855f7', desc:'Add, subtract, multiply & divide fractions with step-by-step solutions.',      grade:[3,9],  diff:'easy'},
  {slug:'percentage-calculator',  name:'Percentage Calculator',     icon:'fa-percent',         color:'#f97316', desc:'Calculate percentages, percentage change, and reverse percentages instantly.', grade:[5,10], diff:'easy'},
  {slug:'equation-solver',        name:'Equation Solver',           icon:'fa-equals',          color:'#3b82f6', desc:'Solve linear and quadratic equations with full working shown step by step.',     grade:[7,11], diff:'medium'},
  {slug:'geometry-calculator',    name:'Geometry Calculator',       icon:'fa-draw-polygon',    color:'#22c55e', desc:'Calculate area, perimeter, volume and surface area for all common shapes.',     grade:[5,10], diff:'medium'},
  {slug:'graphing-calculator',    name:'Graphing Calculator',       icon:'fa-chart-line',      color:'#6366f1', desc:'Plot functions and equations on an interactive graph instantly.',                grade:[8,12], diff:'medium'},
  {slug:'triangle-calculator',    name:'Triangle Calculator',       icon:'fa-mountain',        color:'#14b8a6', desc:'Solve any triangle - find missing sides and angles using trigonometry.',        grade:[7,11], diff:'medium'},
  {slug:'gcf-lcm-calculator',     name:'GCF & LCM Calculator',     icon:'fa-layer-group',     color:'#ec4899', desc:'Find the greatest common factor and lowest common multiple of any numbers.',    grade:[4,8],  diff:'easy'},
  {slug:'ratio-calculator',       name:'Ratio Calculator',          icon:'fa-scale-balanced',  color:'#eab308', desc:'Simplify ratios, solve proportions and scale quantities with ease.',            grade:[5,9],  diff:'easy'},
  {slug:'statistics-calculator',  name:'Statistics Calculator',     icon:'fa-chart-bar',       color:'#0ea5e9', desc:'Calculate mean, median, mode, range, variance and standard deviation.',        grade:[6,11], diff:'medium'},
  {slug:'exponent-calculator',    name:'Exponent Calculator',       icon:'fa-superscript',     color:'#f43f5e', desc:'Calculate powers, roots and scientific notation with detailed steps.',          grade:[6,10], diff:'easy'},
  {slug:'prime-checker',          name:'Prime Number Checker',      icon:'fa-hashtag',         color:'#8b5cf6', desc:'Check if any number is prime and find prime factors instantly.',                grade:[4,8],  diff:'easy'},
  {slug:'times-table',            name:'Times Table Generator',     icon:'fa-table',           color:'#10b981', desc:'Generate and practise multiplication tables for any number.',                   grade:[2,6],  diff:'easy'},
  {slug:'unit-converter',         name:'Unit Converter',            icon:'fa-arrows-left-right',color:'#f97316',desc:'Convert length, weight, temperature, speed and more between units.',            grade:[5,10], diff:'easy'},
  {slug:'roman-numeral-converter',name:'Roman Numeral Converter',   icon:'fa-landmark',        color:'#64748b', desc:'Convert numbers to Roman numerals and Roman numerals back to numbers.',        grade:[4,8],  diff:'easy'},
  {slug:'base-converter',         name:'Number Base Converter',     icon:'fa-binary',          color:'#0891b2', desc:'Convert numbers between binary, decimal, octal and hexadecimal bases.',        grade:[8,12], diff:'hard'},
];
const _toolSlugs = TOOLS.map(t => t.slug);

// Helper functions for topics
let _topicsCache = null;
function get_topics() {
    if (_topicsCache !== null) return _topicsCache;
    const f = path.join(ROOT, 'data/topics.json');
    if (fs.existsSync(f)) {
        _topicsCache = JSON.parse(fs.readFileSync(f, 'utf8'));
    } else {
        _topicsCache = [];
    }
    return _topicsCache;
}
function get_topic(id) {
    return get_topics().find(t => t.id === id) || null;
}
function get_topics_by_subject(subject) {
    return get_topics().filter(t => t.subject === subject);
}

const GLOBAL_DATA = {
    SITE_NAME, SITE_SHORT_NAME, SITE_TAGLINE, SITE_DESCRIPTION, IS_DEV,
    SITE_URL, CDN_URL, THUMB_URL, GAMES_URL, CONTACT_EMAIL, ADSENSE_ID, GA_ID,
    COLOR_BG, COLOR_BG2, COLOR_BG3, COLOR_CARD, COLOR_CARD_HOVER, COLOR_ACCENT,
    COLOR_ACCENT2, COLOR_TEXT, COLOR_TEXT_MUTED, COLOR_BORDER, META_KEYWORDS,
    TWITTER_HANDLE, SITE_YEAR, SUBJECTS, TOOLS, get_topics, get_topic, get_topics_by_subject,
    meta_title: null, meta_desc: null, _GET: {}
};

// ── Setup Express & View Engine ──────────────────────────────────────────────
app.set('view engine', 'ejs');
app.set('views', path.join(ROOT, 'views'));
app.use(express.urlencoded({ extended: true }));
app.use(express.json());

// ── Local Middleware ─────────────────────────────────────────────────────────
app.use((req, res, next) => {
    res.locals = { ...GLOBAL_DATA, _GET: req.query, _uri: req.path };
    next();
});

// ── Static assets ─────────────────────────────────────────────────────────────
const staticOptions = { maxAge: '1y', immutable: true };
app.use('/assets', express.static(path.join(ROOT, 'assets'), staticOptions));
app.use('/thumbs', express.static(path.join(ROOT, 'thumbs'), staticOptions));
app.use('/ads.txt', express.static(path.join(ROOT, 'ads.txt')));
app.use('/robots.txt', express.static(path.join(ROOT, 'robots.txt')));
app.use('/favicon.ico', express.static(path.join(ROOT, 'assets/img/logo.png'), staticOptions));

// ── Sitemap XSL ──────────────────────────────────────────────────────────────
app.get('/sitemap.xsl', (req, res) => {
    res.setHeader('Content-Type', 'text/xsl; charset=utf-8');
    res.setHeader('Cache-Control', 'public, max-age=86400');
    res.sendFile(path.join(ROOT, 'assets/xsl/sitemap.xsl'));
});

// ── Sitemaps ─────────────────────────────────────────────────────────────────
app.get(['/sitemap.xml', '/sitemap-static.xml', '/sitemap-tools.xml', '/sitemap-topics.xml'], (req, res) => {
    const type = req.path.replace('.xml', '').replace('/sitemap-', '').replace('/sitemap', '');
    res.setHeader('Content-Type', 'application/xml; charset=utf-8');
    res.locals._GET.type = type === '' ? null : type;
    
    // Instead of rendering ejs which might output whitespace, we construct XML directly or render a sitemap.ejs if it existed.
    // Since sitemap.php was complex, we'll implement it manually here.
    const BASE = SITE_URL;
    let xml = `<?xml version="1.0" encoding="UTF-8"?>\n`;
    xml += `<?xml-stylesheet type="text/xsl" href="/sitemap.xsl"?>\n`;
    
    if (!type) {
        // Sitemap Index
        xml += `<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n`;
        xml += `  <sitemap><loc>${BASE}/sitemap-static.xml</loc></sitemap>\n`;
        xml += `  <sitemap><loc>${BASE}/sitemap-topics.xml</loc></sitemap>\n`;
        xml += `  <sitemap><loc>${BASE}/sitemap-tools.xml</loc></sitemap>\n`;
        xml += `</sitemapindex>`;
    } else {
        xml += `<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n`;
        const urls = [];
        if (type === 'static') {
            urls.push({ loc: '/', priority: '1.0', freq: 'daily' });
            SUBJECTS.forEach(s => urls.push({ loc: '/' + s.slug, priority: '0.9', freq: 'weekly' }));
            ['about','contact','privacy','terms'].forEach(p => urls.push({ loc: '/' + p, priority: '0.4', freq: 'monthly' }));
        } else if (type === 'tools') {
            urls.push({ loc: '/math-tools', priority: '0.9', freq: 'weekly' });
            _toolSlugs.forEach(t => urls.push({ loc: '/math-tools/' + t, priority: '0.8', freq: 'monthly' }));
        } else if (type === 'topics') {
            get_topics().forEach(t => urls.push({ loc: '/' + t.subject + '/' + t.id, priority: '0.8', freq: 'monthly' }));
        }
        urls.forEach(u => {
            xml += `  <url>\n    <loc>${BASE}${u.loc}</loc>\n    <changefreq>${u.freq}</changefreq>\n    <priority>${u.priority}</priority>\n  </url>\n`;
        });
        xml += `</urlset>`;
    }
    res.send(xml);
});

// ── Vault API (Native Node.js) ───────────────────────────────────────────────
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

app.get(['/api/vault.php', '/api/vault'], (req, res) => {
  const csvPath = path.join(ROOT, 'games_list.csv');
  if (!fs.existsSync(csvPath)) return res.json([]);

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

    let thumb = null;
    for (const ext of thumbExts) {
      if (fs.existsSync(path.join(ROOT, 'thumbs', code + ext))) {
        thumb = '/thumbs/' + code + ext; break;
      }
    }

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

    if (!thumb) thumb = thumbCdn || '';

    const iframeUrl = rawSrc.includes('geet.in.net') || rawSrc.includes('geet.co.in')
      ? 'https://edumathtools.com/player?src=' + encodeURIComponent(rawSrc)
      : rawSrc;

    data.push({ code, name, iframe: iframeUrl, thumb, category });
  }

  res.setHeader('Cache-Control', 'public, max-age=300');
  res.json(data);
});

// ── Routing logic ────────────────────────────────────────────────────────────

// Root
app.get(['/', '/index', '/index.html'], (req, res) => res.render('index'));

// Search
app.get('/search', (req, res) => res.render('search'));

// Static pages
const staticPages = ['about', 'contact', 'privacy', 'terms', 'disclaimer'];
staticPages.forEach(page => {
    app.get('/' + page, (req, res) => res.render(page));
});

// /math-tools → tools hub
app.get('/math-tools', (req, res) => {
    res.locals._GET.subject = 'math-tools';
    res.render('subject-tools');
});

// /math-tools/<tool-slug> → tool page
app.get('/math-tools/:tool', (req, res, next) => {
    const tool = req.params.tool;
    if (_toolSlugs.includes(tool)) {
        // Render the tool's specific view if it exists
        res.render(tool, (err, html) => {
            if (err) next(); else res.send(html);
        });
    } else {
        next();
    }
});

// /math, /science, etc. → subject hub
app.get('/:subject', (req, res, next) => {
    const subject = req.params.subject;
    if (slugs.includes(subject)) {
        res.locals._GET.subject = subject;
        res.render('subject');
    } else {
        next();
    }
});

// /math/fractions, /science/photosynthesis → topic page
app.get('/:subject/:topic', (req, res, next) => {
    const subject = req.params.subject;
    const topicId = req.params.topic;
    if (slugs.includes(subject)) {
        res.locals._GET.subject = subject;
        res.locals._GET.id = topicId;
        res.render('topic');
    } else {
        next();
    }
});

// 404 Fallback
app.use((req, res) => {
    res.status(404).render('404');
});

// ── Start Server ─────────────────────────────────────────────────────────────
app.listen(PORT, () => {
    console.log(`EduMain (Native Node.js) running on http://localhost:${PORT}`);
});
