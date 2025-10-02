=== Sectorize ===
Contributors: turtlesoup
Tags: author, archive, seo, schema, organization
Requires at least: 6.0
Tested up to: 6.7
Stable tag: 0.1.2
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Transform author archives into elegant sector-based content organization with automatic SEO optimization.

== Description ==

**Sectorize** is an elegant, plug-and-play WordPress plugin that transforms author archives into flexible sector-based content organization with automatic SEO optimization.

= ⭐ Why Sectorize? =

* **Zero Configuration**: Install, activate, and it works immediately
* **Elegant Architecture**: Repurposes WordPress's built-in author system - no custom post types or taxonomies
* **SEO-Ready**: Automatic JSON-LD schema, optimized titles, and canonical URLs
* **Smart Redirects**: 301 redirects from `/author/username` to clean `/sector/nickname` URLs
* **Collective Authorship**: Uses your admin nickname for consistent site branding

= 🎯 Perfect For =

* **Content Creators & Bloggers** - Organize content by type without showing individual author names
* **Industry Portals** - Create sectors like "Finance," "Technology," "Healthcare"
* **Corporate Sites** - Organize by department: "Marketing," "Sales," "Support"
* **Regional Content** - Geographic organization: "North America," "Europe," "Asia Pacific"

= ✨ How It Works =

Sectorize cleverly repurposes WordPress's author system:

* **Users = Sectors**: Each user represents a content sector
* **Nicknames = URLs**: User nicknames become `/sector/{nickname}/` URLs
* **Posts = Content**: Assign posts to users for automatic sector organization
* **SEO = Automatic**: Schema markup and optimization included

= 🔧 Features =

* Automatic URL Rewriting: `/author/john-doe` → `/sector/finance`
* Schema.org JSON-LD markup for articles
* SEO-friendly 301 redirects from legacy author URLs
* Compatible with Yoast SEO, Rank Math, and The SEO Framework
* Works with Gutenberg and Classic Editor
* Zero configuration required

= 🌟 Live Example =

See it in action at [ICTStart.com](https://ictstart.com):
* [Article Sector](https://ictstart.com/sector/article/)
* [News Sector](https://ictstart.com/sector/news/)
* [Insights Sector](https://ictstart.com/sector/insights/)

== Installation ==

= Automatic Installation =

1. Go to Plugins → Add New
2. Search for "Sectorize"
3. Click "Install Now"
4. Activate the plugin

= Manual Installation =

1. Download the plugin ZIP file
2. Go to Plugins → Add New → Upload Plugin
3. Choose the ZIP file and click "Install Now"
4. Activate the plugin

= Quick Start =

1. Create users with sector nicknames (e.g., "Video", "Review", "Insights")
2. Set user role to Contributor or Author
3. Assign posts to sector users via Quick Edit
4. Visit `/sector/{nickname}/` to see your sector archive

= Example Setup =

Username: `insights-user`
Nickname: `Insights`
Role: Contributor

Posts assigned to this user will appear at `/sector/insights/`

== Frequently Asked Questions ==

= Do I need to configure anything after activation? =

No! Sectorize works immediately after activation. Just flush your permalinks (Settings → Permalinks → Save Changes) and you're ready to go.

= Will old `/author/` URLs still work? =

Yes! Sectorize automatically creates 301 redirects from old `/author/username/` URLs to the new `/sector/nickname/` URLs, preserving your SEO.

= Can I customize the sector base slug? =

The current version uses `/sector/` as the base. Custom base slugs may be added in future versions based on user feedback.

= Does this work with my SEO plugin? =

Yes! Sectorize is fully compatible with Yoast SEO, Rank Math, and The SEO Framework. It automatically optimizes titles and adds Schema.org markup.

= Does this work with page builders? =

Yes! Sectorize works with Gutenberg, Classic Editor, Elementor, and other popular page builders.

= Will this affect my existing content? =

No! Your posts remain unchanged. You simply assign them to sector users, and they'll be organized automatically.

= How do I create a new sector? =

Simply create a new WordPress user, set their nickname to your desired sector name (e.g., "Technology"), and assign posts to that user.

= Does this work with caching plugins? =

Yes! Tested with WP Super Cache, W3 Total Cache, and LiteSpeed Cache.

== Screenshots ==

1. Sector archive page showing organized content
2. User profile with nickname setting for sectors
3. Schema.org JSON-LD markup in page source
4. SEO-optimized titles in browser and search results

== Changelog ==

= 0.1.1 =
* Security: Add password-protected post check to schema output
* Security: Add error handling to preg_replace in link overrides
* Security: Add global variable validation in author posts link
* Enhancement: Add activation notice for better user experience
* Enhancement: Add wp_cache_flush() to uninstall cleanup
* Enhancement: Add includes/index.php to prevent directory listing
* Fix: Clean up activation transient on uninstall

= 0.1.0 =
* Initial release
* URL transformation: `/author/` → `/sector/`
* Nickname-based routing
* Automatic 301 redirects for legacy URLs
* SEO title optimization
* Schema.org Article JSON-LD markup
* Compatible with major SEO plugins
* Zero configuration setup

== Upgrade Notice ==

= 0.1.0 =
Initial release. After activation, visit Settings → Permalinks and click "Save Changes" to flush rewrite rules.

== Additional Information ==

= Development =

This plugin is actively developed on [GitHub](https://github.com/rancidbluecheese/sectorize). Contributions and bug reports are welcome!

= Support =

For support, please use the [WordPress.org support forum](https://wordpress.org/support/plugin/sectorize/) or [open an issue on GitHub](https://github.com/rancidbluecheese/sectorize/issues).

= Requirements =

* WordPress 6.0 or higher
* PHP 7.4 or higher
* Permalinks enabled (not "Plain")

= Credits =

Created by [Marg Choco](https://ictstart.com) | Originally developed for ICTStart.com