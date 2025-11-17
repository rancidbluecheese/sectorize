# Changelog

All notable changes to **Sectorize** will be documented in this file.  
This project adheres to [Semantic Versioning](https://semver.org/).

---

## [0.2.1] – 2025-11-17
### Fixed
- Removed inline `<style>` block from `render_settings_page()`
- Added `enqueue_admin_assets()` hooked to `admin_enqueue_scripts`
- Enqueues `css/sectorize-admin.css` with proper versioning (`1.0.0`) and scope (`settings_page_sectorize` only)
- Replaced `dirname(__FILE__)` with `__DIR__` for path resolution (PHP ≥ 5.3)

### Compliance
- PHPCS cleanup — project passes WordPress Coding Standards

---

## [0.2.0] – 2025-11-10
### Added
- Admin settings interface (Settings → Sectorize)
- Nonce verification for all admin form submissions
- Capability checks for user management operations
- Permalink flush functionality in admin UI

### Improved
- Input sanitization and validation
- Transient caching with expiration

---

## [0.1.5] – 2025-11-01
### Improved
- Rewrite rule handling
- Admin notices for missing files

> Historical note: Between 0.1.4 and 0.1.5, the repository was heavily overhauled.  
> Sectorize’s codebase was rebuilt from scratch, resulting in a reset of GitHub contribution history.  
> This release marks the continuation of the project after that major refactor.

---

## [0.1.4] – 2025-10-04
### Fixed
- Removed deprecated `load_plugin_textdomain()` call (WordPress.org requirement)
- Updated “Tested up to” header to WordPress 6.8

### Maintenance
- WordPress.org automated check compliance

---

## [0.1.3] – 2025-10-03
### Added
- Plugin guard constant to prevent redeclaration errors

### Changed
- Bumped version metadata to 0.1.3

---

## [0.1.2] – 2025-10-02
### Fixed
- Corrected plugin header version mismatch causing activation errors

### Enhanced
- Added hybrid `.gitattributes` for LF normalization and clean exports

### Maintenance
- Synced version numbers across all plugin files

---

## [0.1.1] – 2025-10-02
### Security
- Added password‑protected post check to schema output
- Added error handling to `preg_replace` in link overrides
- Added global variable validation in author posts link

### Enhanced
- Activation notice for better user experience
- `wp_cache_flush()` to uninstall cleanup
- `includes/index.php` to prevent directory listing

### Fixed
- Cleaned up activation transient on uninstall

---

## [0.1.0] – 2025-10-01
### Initial Release
- URL transformation: `/author/` → `/sector/`
- Nickname‑based routing
- Automatic 301 redirects for legacy URLs
- SEO title optimization
- Schema.org Article JSON‑LD markup
- Compatible with major SEO plugins
- Zero configuration setup
