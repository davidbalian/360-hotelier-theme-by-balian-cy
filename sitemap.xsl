<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:s="http://www.sitemaps.org/schemas/sitemap/0.9"
	xmlns:xhtml="http://www.w3.org/1999/xhtml"
	exclude-result-prefixes="s xhtml">

	<xsl:output method="html" encoding="UTF-8" indent="yes" />

	<xsl:template match="/">
		<xsl:apply-templates select="s:urlset"/>
	</xsl:template>

	<xsl:template match="s:urlset">
		<html lang="en">
			<head>
				<meta charset="utf-8"/>
				<meta name="viewport" content="width=device-width, initial-scale=1"/>
				<title>XML Sitemap — 360 Hotelier</title>
				<style type="text/css">
					:root {
						--purple: #5A2A82;
						--gold: #F28C28;
						--charcoal: #2B2B2B;
						--muted: #5c5c5c;
						--surface: #ffffff;
						--bg: #f4f1f8;
						--border: rgba(90, 42, 130, 0.12);
						--radius: 12px;
					}
					* { box-sizing: border-box; }
					body {
						margin: 0;
						font-family: "Satoshi", system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
						font-size: 15px;
						line-height: 1.5;
						color: var(--charcoal);
						background: linear-gradient(165deg, var(--bg) 0%, #ebe4f2 45%, #faf8fc 100%);
						min-height: 100vh;
					}
					.wrap {
						max-width: 920px;
						margin: 0 auto;
						padding: 2.5rem 1.25rem 3rem;
					}
					header {
						margin-bottom: 2rem;
					}
					.badge {
						display: inline-block;
						font-size: 0.7rem;
						font-weight: 700;
						letter-spacing: 0.08em;
						text-transform: uppercase;
						color: var(--purple);
						background: rgba(90, 42, 130, 0.1);
						padding: 0.35rem 0.65rem;
						border-radius: 999px;
						margin-bottom: 0.75rem;
					}
					h1 {
						font-size: clamp(1.5rem, 4vw, 2rem);
						font-weight: 700;
						color: var(--purple);
						margin: 0 0 0.5rem;
						letter-spacing: -0.02em;
					}
					.lede {
						margin: 0;
						max-width: 52ch;
						color: var(--muted);
						font-size: 0.95rem;
					}
					.stats {
						display: flex;
						flex-wrap: wrap;
						gap: 0.75rem;
						margin-top: 1.25rem;
					}
					.stat {
						background: var(--surface);
						border: 1px solid var(--border);
						border-radius: var(--radius);
						padding: 0.65rem 1rem;
						font-size: 0.85rem;
					}
					.stat strong {
						color: var(--purple);
					}
					.list {
						display: flex;
						flex-direction: column;
						gap: 1rem;
					}
					.card {
						background: var(--surface);
						border: 1px solid var(--border);
						border-radius: var(--radius);
						padding: 1.15rem 1.25rem;
						box-shadow: 0 8px 28px rgba(43, 43, 43, 0.06);
					}
					.card-main {
						display: flex;
						flex-wrap: wrap;
						align-items: baseline;
						justify-content: space-between;
						gap: 0.75rem 1rem;
						margin-bottom: 0.65rem;
					}
					.card-main a {
						color: var(--purple);
						font-weight: 600;
						text-decoration: none;
						word-break: break-all;
					}
					.card-main a:hover {
						color: var(--gold);
						text-decoration: underline;
					}
					.prio {
						font-size: 0.8rem;
						color: var(--muted);
						white-space: nowrap;
					}
					.prio span {
						font-weight: 600;
						color: var(--charcoal);
					}
					.meta {
						display: flex;
						flex-wrap: wrap;
						gap: 0.5rem 1rem;
						font-size: 0.8rem;
						color: var(--muted);
						margin-bottom: 0.85rem;
					}
					.meta code {
						font-size: 0.78em;
						background: rgba(90, 42, 130, 0.06);
						padding: 0.15rem 0.4rem;
						border-radius: 4px;
						color: var(--charcoal);
					}
					.alt-label {
						font-size: 0.72rem;
						font-weight: 700;
						text-transform: uppercase;
						letter-spacing: 0.06em;
						color: var(--muted);
						margin: 0 0 0.4rem;
					}
					.alts {
						display: flex;
						flex-direction: column;
						gap: 0.5rem;
					}
					.alt-row {
						display: flex;
						flex-wrap: wrap;
						align-items: center;
						gap: 0.5rem 0.75rem;
						font-size: 0.8rem;
					}
					.lang {
						flex: 0 0 auto;
						min-width: 5.5rem;
						font-size: 0.72rem;
						padding: 0.2rem 0.5rem;
						border-radius: 6px;
						background: rgba(242, 140, 40, 0.12);
						color: #9a5a16;
						font-weight: 600;
						text-align: center;
					}
					.lang.default { background: rgba(90, 42, 130, 0.1); color: var(--purple); }
					.alt-row a {
						color: var(--purple);
						word-break: break-all;
						text-decoration: none;
						font-weight: 500;
					}
					.alt-row a:hover { color: var(--gold); text-decoration: underline; }
					footer {
						margin-top: 2.5rem;
						padding-top: 1.25rem;
						border-top: 1px solid var(--border);
						font-size: 0.8rem;
						color: var(--muted);
					}
				</style>
			</head>
			<body>
				<div class="wrap">
					<header>
						<div class="badge">360 Hotelier</div>
						<h1>XML Sitemap</h1>
						<p class="lede">Human-friendly view of public URLs. Search engines and tools still consume the underlying XML; this page is only for browsers.</p>
						<div class="stats">
							<div class="stat"><strong><xsl:value-of select="count(s:url)"/></strong> URLs</div>
							<div class="stat">Includes <strong>hreflang</strong> alternates (EN / EL)</div>
						</div>
					</header>
					<div class="list">
						<xsl:for-each select="s:url">
							<xsl:sort select="s:priority" data-type="number" order="descending"/>
							<xsl:sort select="s:loc"/>
							<div class="card">
								<div class="card-main">
									<a href="{s:loc}"><xsl:value-of select="s:loc"/></a>
									<div class="prio">Priority <span><xsl:value-of select="s:priority"/></span></div>
								</div>
								<div class="meta">
									<xsl:if test="s:lastmod">
										<span>Last modified <code><xsl:value-of select="s:lastmod"/></code></span>
									</xsl:if>
									<xsl:if test="s:changefreq">
										<span>Change freq <code><xsl:value-of select="s:changefreq"/></code></span>
									</xsl:if>
								</div>
								<xsl:if test="xhtml:link">
									<p class="alt-label">Language alternates</p>
									<div class="alts">
										<xsl:for-each select="xhtml:link">
											<xsl:variable name="hl" select="@hreflang"/>
											<div class="alt-row">
												<span>
													<xsl:attribute name="class">
														<xsl:text>lang</xsl:text>
														<xsl:if test="$hl = 'x-default'"><xsl:text> default</xsl:text></xsl:if>
													</xsl:attribute>
													<xsl:value-of select="$hl"/>
												</span>
												<a>
													<xsl:attribute name="href"><xsl:value-of select="@href"/></xsl:attribute>
													<xsl:value-of select="@href"/>
												</a>
											</div>
										</xsl:for-each>
									</div>
								</xsl:if>
							</div>
						</xsl:for-each>
					</div>
					<footer>
						Generated from sitemap.xml. If this page looks unstyled, open <code>sitemap.xml</code> and <code>sitemap.xsl</code> from the same folder (site root).
					</footer>
				</div>
			</body>
		</html>
	</xsl:template>
</xsl:stylesheet>
