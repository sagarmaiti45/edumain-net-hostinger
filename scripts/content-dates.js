#!/usr/bin/env node
/*
 * Rebuilds content-dates.json: the day each page's content last changed,
 * read from git history. The sitemap uses these as <lastmod>, because Google
 * only trusts lastmod when it matches real edits - a date that moves to
 * "today" on every request is ignored.
 *
 * Run `node scripts/content-dates.js` after editing content and commit the
 * JSON with the change. Files with uncommitted edits count as changed today.
 *
 *   views  - every views/*.ejs file, keyed by name without the extension
 *   items  - one entry per record in a JSON catalogue (see CATALOGUES), keyed
 *            "<prefix>:<id>", dated by the last commit that changed that record
 */
const { execFileSync } = require('child_process');
const fs = require('fs');
const path = require('path');

const ROOT = path.join(__dirname, '..');
const CATALOGUES = [{ file: 'data/topics.json', id: 'id', prefix: 'topic' }];
const EXTRA_FILES = [];

const today = new Date().toISOString().slice(0, 10);
const git = (...args) => execFileSync('git', args, { cwd: ROOT, encoding: 'utf8', maxBuffer: 512 * 1024 * 1024 }).trim();
const dirty = (file) => git('status', '--porcelain', '--', file) !== '';

function fileDate(file) {
  if (dirty(file)) return today;
  return git('log', '-1', '--format=%cs', '--', file) || today;
}

function itemDates(file, idField, prefix) {
  const dates = {};
  const commits = git('log', '--reverse', '--format=%H %cs', '--', file).split('\n').filter(Boolean);
  const snapshot = (json) => {
    const map = {};
    for (const item of JSON.parse(json)) map[item[idField]] = JSON.stringify(item);
    return map;
  };
  let previous = {};
  const record = (current, date) => {
    for (const id of Object.keys(current)) {
      if (current[id] !== previous[id]) dates[`${prefix}:${id}`] = date;
    }
    previous = current;
  };
  for (const line of commits) {
    const [hash, date] = line.split(' ');
    try { record(snapshot(git('show', `${hash}:${file}`)), date); } catch (e) { /* unparseable revision */ }
  }
  record(snapshot(fs.readFileSync(path.join(ROOT, file), 'utf8')), today);
  return dates;
}

const views = {};
for (const name of fs.readdirSync(path.join(ROOT, 'views'))) {
  if (name.endsWith('.ejs')) views[name.slice(0, -4)] = fileDate(`views/${name}`);
}
for (const file of EXTRA_FILES) views[path.basename(file).replace(/\.[^.]+$/, '')] = fileDate(file);

const items = {};
for (const { file, id, prefix } of CATALOGUES) Object.assign(items, itemDates(file, id, prefix));

const sortKeys = (o) => Object.fromEntries(Object.keys(o).sort().map((k) => [k, o[k]]));
fs.writeFileSync(path.join(ROOT, 'content-dates.json'), JSON.stringify({ views: sortKeys(views), items: sortKeys(items) }, null, 2) + '\n');
console.log(`content-dates.json: ${Object.keys(views).length} views, ${Object.keys(items).length} catalogue items`);
