=== Sectorize - Custom Author Archives & Collective Authorship ===
Contributors: turtlesoup
Tags: author, archive, seo, schema, organization
Requires at least: 6.0
Tested up to: 6.8
Stable tag: 0.2.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Transform author archives into elegant sector-based content organization with automatic SEO optimization.

---

== Description ==

**Sectorize** is an elegant, plug-and-play WordPress plugin that transforms author archives into flexible sector-based content organization with automatic SEO optimization.

= * Why Sectorize? =

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

= 🎭 Collective Authorship =

Sectorize enables **collective authorship** by design:

* **Backend**: Assign posts to sector users (e.g., "Review", "Insights") via the standard Author dropdown
* **Frontend**: Post bylines display sector names instead of individual authors
* **Branding**: Content is attributed to your organization/sector, not individuals
* **Schema**: Structured data uses sector names for consistent SEO

**Perfect for:**
- Corporate websites that want uniform branding
- Content teams publishing under department names
- Industry portals organizing by topic rather than author
- Sites where individual attribution is less important than content categorization

= 🔧 Features =

* Automatic URL Rewriting: `/author/john-doe` → `/sector/finance`
* Schema.org JSON-LD markup for articles
* SEO-friendly 301 redirects from legacy author URLs
* Compatible with Yoast SEO, Rank Math, and The SEO Framework
* Works with most modern WordPress themes
* Compatible with Gutenberg and Classic Editor
* Zero configuration required

**Theme Compatibility:** Works with all themes that follow WordPress coding standards. Some premium themes may require minor CSS adjustments for byline formatting.

= 🌟 Live Example =

See it in action at [ICTStart.com](https://ictstart.com):
* [Article](https://ictstart.com/sector/article/)
* [Review](https://ictstart.com/sector/review/)
* [Insights](https://ictstart.com/sector/insight/)

== Installation ==

= Minimum Requirements =

You'll need WordPress version 6.0 or higher for this to work.

= Quick Start =

1. Create users with sector nicknames (e.g., "Video", "Review", "Insights")
2. Set user role to Contributor or Author
3. Assign posts to sector users via Quick Edit
4. Visit `/sector/{nickname}/` to see your sector archive

= Example Setup =

Username: `my-unique-username`
Nickname: `Insight`
Role: Contributor

Posts assigned to this user will appear at `/sector/insights/`

== Configuration ==

= Admin Interface =

After activation, manage your sectors via **Settings → Sectorize** in WordPress admin.

The settings page provides:
* **Permalink Management** - Flush rewrite rules if sector URLs aren't loading
* **Sector Overview** - View all users and their sector nicknames in one table
* **Quick Edit** - Modify sector nicknames directly from the settings page

= Manual Configuration =

You can also edit user settings directly:
1. Go to **Users → All Users**
2. Click **Edit** on any user
3. Set the **Nickname** field to your desired sector name
4. Save changes

== Screenshots ==

1. Sectorize Settings page showing permalink management and sector nickname configuration table
2. Frontend sector archive displaying posts with clean /sector/{nickname}/ URL structure
3. Article page showing collective authorship byline with Schema.org markup

---

== Frequently Asked Questions ==

= How do I create a new sector? =

Simply create a new WordPress user, set their nickname to your desired sector name (e.g., "Technology"), and assign posts to that user.

= Do I need to configure anything after activation? =

No. Sectorize works immediately after activation. Just flush your permalinks from Sectorize Admin UI and you're ready to go.

= Will old `/author/` URLs still work? =

Yes. Sectorize automatically creates 301 redirects from old `/author/username/` URLs to the new `/sector/nickname/` URLs, preserving your SEO.

= Can I customize the sector base slug? =

The current version uses `/sector/` as the base. Custom base slugs may be added in future versions based on user feedback.

= Does this work with my SEO plugin? =

Yes. It also automatically optimizes titles and adds Schema.org markup.

= Does this work with page builders? =

Yes.

= Will this affect my existing content? =

No.

= Does this work with caching plugins? =

Yes.

= How does collective authorship work? =

Sectorize implements collective authorship by displaying sector nicknames instead of individual author names throughout your site.

**In WordPress Admin:**
- The Author dropdown in post editor shows sector users (e.g., "Review", "Insights")
- The Author column in post lists displays sector nicknames
- Manage sector users via Settings → Sectorize

**On Your Website:**
- Author names are replaced with sector nicknames automatically
- Archive pages organize content by sector at /sector/{nickname}/
- Schema.org markup attributes content to sectors for consistent branding

This approach is ideal for corporate sites, industry portals, and content brands where you want to emphasize the organization rather than individual contributors.

**Note:** Most modern themes display author names correctly (e.g., "Review" or "Insights"). Some premium themes may hardcode "By [Author]" formatting that requires custom CSS to adjust.

= Some themes show "By Review" - can I remove the "By" prefix? =

Yes, though this is a theme-specific issue, not a Sectorize limitation. Most well-coded themes respect WordPress's author display system. However, some premium themes hardcode the "By" prefix in their templates.

**Quick Fix - Using Custom CSS:**

1. Go to Appearance → Customize → Additional CSS
2. Inspect your post page to find the author element's CSS class
3. Add CSS to hide or modify the "By" text

Example CSS to hide "By":
.entry-meta .byline::before {
content: "" !important;
}
/* Or hide the entire byline element */
.byline {
display: none;
}

**Known Theme Issues:**
- **Page builders**: Some page builders hardcode author display formats. If you need theme-specific assistance, consult your theme's documentation or support forums.

= Can I still show individual author names? =

Sectorize is designed for collective authorship and sector-based organization. If you need to display individual author names alongside sector organization, you may want to use a co-authorship plugin in combination with Sectorize, or consider whether sector-based organization is the right approach for your use case.

---

== Changelog ==

= 0.2.0 =
* Added admin settings interface (Settings → Sectorize)
* Implemented nonce verification for all admin form submissions
* Added capability checks for user management operations
* Enhanced input sanitization and validation
* Improved transient caching with expiration
* Added permalink flush functionality in admin UI

= 0.1.5 =
* Improved rewrite rule handling.
* Added admin notices for missing files.

= 0.1.4 =
* Fix: Remove deprecated load_plugin_textdomain() call (WordPress.org requirement)
* Fix: Update "Tested up to" header to WordPress 6.8
* Maintenance: WordPress.org automated check compliance

= 0.1.3 =
* Added plugin guard constant to prevent redeclaration errors
* Bumped version metadata to 0.1.3

= 0.1.2 =
* Fix: Correct plugin header version mismatch causing activation errors
* Enhancement: Add hybrid .gitattributes for LF normalization and clean exports
* Maintenance: Sync version numbers across all plugin files

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

= 0.2.0 =
Visit Settings → Sectorize and click "Flush Rewrite Rules".

== Additional Information ==

= Development =

This plugin is actively developed on [GitHub](https://github.com/rancidbluecheese/sectorize).
