=== Sectorize - Custom Author Archives & Collective Authorship ===
Contributors: turtlesoup
Tags: author, custom URLs, archive, permalinks, nickname, security, seo
Requires at least: 6.0
Tested up to: 6.8
Stable tag: 0.2.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Transform author archives into elegant sector-based content organization with automatic SEO optimization.

---

== Description ==
**Sectorize** is an elegant, plug-and-play WordPress plugin that transforms author archives into flexible sector-based content organization. It hides sensitive `/author/username` slugs and redirects them to `/sector/{nickname}` URLs — improving privacy, branding and SEO.

== Features ==
* Security‑first: prevents exposure of login‑based author slugs
* Zero configuration: Install, activate, and it works immediately
* Collective authorship: uses the site name in Schema.org markup so all content is attributed to the collective brand
* Sector‑based bylines: display sector nicknames in place of author names — ideal for single‑author sites or when contributors prefer anonymity
* Governance‑safe: clear admin guidance; never change login/username, only nicknames
* SEO‑ready: automatic schema markup, optimized titles, and canonical URLs
* Smart redirects: 301 redirects from `/author/username` to `/sector/nickname`
* Admin UI: settings page with one‑click rewrite flush and success notices
* User management: adds “Sector Nickname” column to the Users table

== Use Cases ==
* Content creators: organize posts by sector (e.g. “Insights”, “Reviews”) without exposing author logins
* Corporate sites: group content by department (“Marketing”, “Support”) with sector archives
* Industry portals: create thematic sectors (“Finance”, “Technology”, “Healthcare”)
* Regional content: build geographic sectors (“North America”, “Europe”, “Asia Pacific”)

= 🌟 Live Example =
See Sectorize in action at [ICTStart.com](https://ictstart.com):
* [Article sector](https://ictstart.com/sector/article/)
* [Review sector](https://ictstart.com/sector/review/)
* [Insights sector](https://ictstart.com/sector/insight/)

== Installation ==
1. Install and activate Sectorize.
2. Create or edit users and set their nickname to the desired sector name.
3. Assign posts to sector users.
4. Flush rewrite rules once via Settings → Sectorize.

== Usage ==
**In WordPress Admin:**
- Manage sector users via Settings → Sectorize
- The Author dropdown in the post editor shows sector nicknames
- The Author column in post lists displays sector nicknames

**On Your Website:**
- Author names are replaced with sector nicknames automatically
- Archive pages organize content by sector at /sector/{nickname}/
- Schema.org markup attributes content to the site name for collective branding

== Frequently Asked Questions ==

= Does this replace the native author archive? =
No. Sectorize adds a parallel `/sector/{nickname}` archive. The native `/author/username` archive remains in place but is safely redirected to prevent login exposure.

= Why use nicknames instead of usernames? =
Nicknames are designed for public display and branding. Usernames are tied to login credentials and should never appear in public URLs.

= Can I change the sector base? =
By default, the base is `sector`. Future versions may introduce customization options.

= How do I create a new sector? =
Simply create a new WordPress user, set their nickname to your desired sector name (e.g., "Technology"), and assign posts to that user.

= Do I need to configure anything after activation? =
No. Sectorize works immediately after activation. Just flush your permalinks from Sectorize Admin UI and you're ready to go.

= Will old `/author/` URLs still work? =
Yes. Sectorize automatically creates 301 redirects from old `/author/username/` URLs to the new `/sector/nickname/` URLs, preserving your SEO.

= Does this work with my SEO plugin? =
Yes. It also automatically optimizes titles and adds Schema.org markup.

= Will this affect my existing content? =
No.

= Does this work with caching plugins? =
Yes.

= Does this work with page builders? =
Yes.

**Theme Compatibility:**
Sectorize works with all themes that follow WordPress coding standards. Most modern themes display author names correctly, but some page builders or premium themes may hardcode “By [Author]” formats. In those cases, minor CSS tweaks or theme‑specific adjustments may be needed. For theme‑specific guidance, consult your theme’s documentation or support forums.

= Some themes show "By Review" - can I remove the "By" prefix? =
Yes, though this is a theme-specific issue, not a Sectorize limitation. Most well-coded themes respect WordPress's author display system. However, some premium themes hardcode the "By" prefix in their templates.

= Can I still use WordPress’s native author archives? =
No. Sectorize replaces the native /author/{username} archives with /sector/{nickname}. Native author archives will not function in the current version of Sectorize.

---

== Changelog ==

= 0.2.1 =
* Removed inline <style> block from render_settings_page()
* Added enqueue_admin_assets() hooked to admin_enqueue_scripts
* Enqueues css/sectorize-admin.css with proper versioning (1.0.0) and scope (settings_page_sectorize only)
* Replaced dirname(__FILE__) with __DIR__ for path resolution (PHP ≥ 5.3)

= 0.2.0 =
* Added admin settings interface (Settings → Sectorize)
* Implemented nonce verification for all admin form submissions
* Added capability checks for user management operations
* Enhanced input sanitization and validation
* Improved transient caching with expiration
* Added permalink flush functionality in admin UI

== Upgrade Notice ==

= 0.2.1 =
Visit Settings → Sectorize and click "Flush Rewrite Rules" to apply new rewrite rules.

== Additional Information ==

= Development =
Development takes place on GitHub.

== License ==
GPLv2 or later