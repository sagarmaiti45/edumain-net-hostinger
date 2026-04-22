<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
  xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
  exclude-result-prefixes="sitemap">

  <xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>

  <xsl:template match="/">
    <html lang="en">
      <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="robots" content="noindex, nofollow"/>
        <title>XML Sitemap - SolveCalc</title>
        <style>
          *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
          body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f5f5; color: #333; font-size: 14px;
            font-weight: 300; line-height: 1.5;
          }
          a { color: #4f46e5; text-decoration: none; }
          a:hover { text-decoration: underline; }

          .sm-header {
            background: #111827; border-bottom: 3px solid #4f46e5;
            padding: 20px 32px; display: flex; align-items: center; gap: 16px;
          }
          .sm-logo { font-size: 1rem; font-weight: 500; color: #f1f5f9; }
          .sm-header-desc { font-size: 0.82rem; color: #94a3b8; margin-left: auto; }

          .sm-wrap { max-width: 1100px; margin: 32px auto; padding: 0 24px 60px; }

          .sm-title { font-size: 1.15rem; font-weight: 500; color: #1a1a1a; margin-bottom: 6px; }
          .sm-subtitle { font-size: 0.85rem; color: #666; margin-bottom: 24px; }

          .sm-stats { display: flex; gap: 12px; margin-bottom: 16px; flex-wrap: wrap; }
          .sm-badge {
            background: #fff; border: 1px solid #e0e0e0; border-radius: 999px;
            padding: 4px 14px; font-size: 0.8rem; font-weight: 300; color: #555;
          }
          .sm-badge b { color: #4f46e5; font-weight: 600; }

          .sm-table-wrap {
            background: #fff; border-radius: 10px; border: 1px solid #e5e5e5;
            overflow-x: auto; -webkit-overflow-scrolling: touch;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
          }
          table { width: 100%; border-collapse: collapse; font-size: 0.84rem; }
          thead { background: #f9f9f9; border-bottom: 2px solid #e5e5e5; }
          th, td { padding: 9px 8px; }
          th { text-align: left; font-weight: 500; text-transform: uppercase; letter-spacing: 0.6px; color: #aaa; }
          td { border-bottom: 1px solid #f0f0f0; font-weight: 300; color: #444; vertical-align: middle; }
          tr:last-child td { border-bottom: none; }
          tr:hover td { background: #fafafa; }
          th:first-child, td:first-child { padding-left: 14px; }
          th:last-child, td:last-child { padding-right: 14px; }

          .td-num { color: #bbb; width: 28px; white-space: nowrap; }
          .td-type { width: 110px; white-space: nowrap; }
          .td-url { max-width: 480px; }
          .td-url a { display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
          .td-lastmod { width: 110px; white-space: nowrap; }
          .td-freq { width: 90px; white-space: nowrap; }
          .td-prio { width: 70px; text-align: center; white-space: nowrap; }

          .prio { display: inline-block; padding: 2px 8px; border-radius: 999px; font-weight: 400; }
          .prio-high { background: #eef2ff; color: #3730a3; }
          .prio-mid  { background: #f5f3ff; color: #6d28d9; }
          .prio-low  { background: #f5f5f5; color: #999; }
          .freq { color: #999; font-weight: 300; }

          .sm-back { font-size: 0.8rem; color: #999; margin-bottom: 12px; }
          .sm-back a { color: #4f46e5; font-weight: 400; }
          .sm-footer { margin-top: 32px; text-align: center; font-size: 0.78rem; color: #aaa; }
          .sm-footer a { color: #4f46e5; }

          @media (max-width: 640px) {
            body { font-size: 11px; }
            .sm-header { padding: 10px 12px; gap: 8px; }
            .sm-logo { font-size: 0.78rem; }
            .sm-header-desc { display: none; }
            .sm-wrap { margin: 12px auto; padding: 0 10px 30px; }
            .sm-title { font-size: 0.88rem; margin-bottom: 4px; }
            .sm-subtitle { font-size: 0.72rem; margin-bottom: 16px; }
            .sm-stats { gap: 6px; margin-bottom: 10px; }
            .sm-badge { font-size: 0.65rem; padding: 2px 8px; }
            .sm-table-wrap { border-radius: 6px; }
            th { padding: 6px 8px; font-size: 0.6rem; letter-spacing: 0.3px; }
            td { padding: 6px 8px; font-size: 0.68rem; }
            .td-type, th.td-type, .td-freq, th.td-freq { display: none; }
            .td-num { width: 20px; }
            .sm-back { font-size: 0.68rem; margin-bottom: 8px; }
            .sm-footer { font-size: 0.65rem; margin-top: 20px; }
          }
        </style>
      </head>
      <body>
        <div class="sm-header">
          <div class="sm-logo">SolveCalc - XML Sitemap</div>
          <div class="sm-header-desc">Read by search engines to discover all pages</div>
        </div>
        <div class="sm-wrap">
          <xsl:apply-templates/>
          <div class="sm-footer">
            <a href="https://solvecalc.net">SolveCalc.net</a> - Free Scientific Calculator Online
          </div>
        </div>
      </body>
    </html>
  </xsl:template>

  <!-- Sitemap index -->
  <xsl:template match="sitemap:sitemapindex">
    <p class="sm-title">Sitemap Index</p>
    <p class="sm-subtitle">This index references <xsl:value-of select="count(sitemap:sitemap)"/> sub-sitemaps. Click any row to browse its URLs.</p>
    <div class="sm-stats">
      <span class="sm-badge"><b><xsl:value-of select="count(sitemap:sitemap)"/></b> sub-sitemaps</span>
    </div>
    <div class="sm-table-wrap">
      <table>
        <thead>
          <tr>
            <th class="td-num">#</th>
            <th class="td-type">Type</th>
            <th class="td-url">Sitemap URL</th>
            <th class="td-lastmod">Last Modified</th>
          </tr>
        </thead>
        <tbody>
          <xsl:for-each select="sitemap:sitemap">
            <xsl:variable name="loc" select="sitemap:loc"/>
            <tr>
              <td class="td-num"><xsl:value-of select="position()"/></td>
              <td class="td-type">
                <xsl:choose>
                  <xsl:when test="contains($loc, 'static')">Static Pages</xsl:when>
                  <xsl:when test="contains($loc, 'article')">Articles</xsl:when>
                  <xsl:otherwise>Pages</xsl:otherwise>
                </xsl:choose>
              </td>
              <td class="td-url"><a href="{$loc}"><xsl:value-of select="$loc"/></a></td>
              <td class="td-lastmod"><xsl:value-of select="sitemap:lastmod"/></td>
            </tr>
          </xsl:for-each>
        </tbody>
      </table>
    </div>
  </xsl:template>

  <!-- URL set -->
  <xsl:template match="sitemap:urlset">
    <p class="sm-back"><a href="/sitemap.xml">← Sitemap Index</a></p>
    <p class="sm-title">
      <xsl:choose>
        <xsl:when test="contains(sitemap:url[1]/sitemap:loc, 'algebra') or contains(sitemap:url[1]/sitemap:loc, 'fraction') or contains(sitemap:url[1]/sitemap:loc, 'polynomial')">Article Pages</xsl:when>
        <xsl:otherwise>Static Pages</xsl:otherwise>
      </xsl:choose>
    </p>
    <div class="sm-stats">
      <span class="sm-badge"><b><xsl:value-of select="count(sitemap:url)"/></b> URLs indexed</span>
      <span class="sm-badge">Last modified: <b><xsl:value-of select="sitemap:url[1]/sitemap:lastmod"/></b></span>
    </div>
    <div class="sm-table-wrap">
      <table>
        <thead>
          <tr>
            <th class="td-num">#</th>
            <th class="td-url">URL</th>
            <th class="td-lastmod">Last Modified</th>
            <th class="td-freq">Frequency</th>
            <th class="td-prio">Priority</th>
          </tr>
        </thead>
        <tbody>
          <xsl:for-each select="sitemap:url">
            <tr>
              <td class="td-num"><xsl:value-of select="position()"/></td>
              <td class="td-url"><a href="{sitemap:loc}"><xsl:value-of select="sitemap:loc"/></a></td>
              <td class="td-lastmod"><xsl:value-of select="sitemap:lastmod"/></td>
              <td class="freq td-freq"><xsl:value-of select="sitemap:changefreq"/></td>
              <td class="td-prio">
                <xsl:variable name="p" select="sitemap:priority"/>
                <xsl:choose>
                  <xsl:when test="$p >= 0.8"><span class="prio prio-high"><xsl:value-of select="$p"/></span></xsl:when>
                  <xsl:when test="$p >= 0.5"><span class="prio prio-mid"><xsl:value-of select="$p"/></span></xsl:when>
                  <xsl:otherwise><span class="prio prio-low"><xsl:value-of select="$p"/></span></xsl:otherwise>
                </xsl:choose>
              </td>
            </tr>
          </xsl:for-each>
        </tbody>
      </table>
    </div>
  </xsl:template>

</xsl:stylesheet>
