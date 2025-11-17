# Sectorize

Sectorize is a WordPress plugin that **repurposes author archives into sector‑based URLs** using the Nickname field.  
It hides sensitive `/author/username` slugs and redirects them to clean, secure `/sector/{nickname}` URLs — improving privacy, branding, and SEO.

---

## 🔒 Why Sectorize?

- **Security‑first**: prevents exposure of login‑based author slugs in public URLs  
- **Zero configuration**: install, activate, and it works immediately  
- **Collective authorship**: uses the site name in Schema.org markup so all content is attributed to the collective brand  
- **Sector‑based bylines**: display sector nicknames in place of author names — ideal for single‑author sites or when contributors prefer anonymity  
- **Governance‑safe**: clear admin guidance; never change login/username, only nicknames  
- **SEO‑ready**: automatic schema markup, optimized titles, and canonical URLs  
- **Smart redirects**: 301 redirects from `/author/username` to `/sector/nickname`  
- **Admin UI**: settings page with one‑click rewrite flush and success notices  
- **User management**: adds “Sector Nickname” column to the Users table  

---

## 🌟 Use Cases

- **Content creators**: organize posts by sector (e.g. “Insights”, “Reviews”) without exposing author logins  
- **Corporate sites**: group content by department (“Marketing”, “Support”) with sector archives  
- **Industry portals**: create thematic sectors (“Finance”, “Technology”, “Healthcare”)  
- **Regional content**: build geographic sectors (“North America”, “Europe”, “Asia Pacific”)  

---

## 🚀 Installation

1. Install and activate Sectorize.
2. Create or edit users and set their **nickname** to the desired sector name (e.g., “Review”, “Insights”).
3. Assign posts to sector users via Quick Edit or the post editor.
4. Flush rewrite rules once via **Settings → Sectorize**.

---

## 📖 Usage

**In WordPress Admin:**

- Manage sector users via **Settings → Sectorize**
- The Author dropdown in the post editor shows sector nicknames
- The Author column in post lists displays sector nicknames

**On Your Website:**

- Author names are replaced with sector nicknames automatically
- Archive pages organize content by sector at `/sector/{nickname}/`
- Schema.org markup attributes content to the site name for collective branding

---

## 🌟 Live Example

See Sectorize in action at [ICTStart.com](https://ictstart.com):

- [Article sector](https://ictstart.com/sector/article/)  
- [Review sector](https://ictstart.com/sector/review/)  
- [Insights sector](https://ictstart.com/sector/insight/)  

---

## 🎨 Theme Compatibility

Sectorize works with all themes that follow WordPress coding standards.  
Most modern themes display author names correctly, but some page builders or premium themes may hardcode “By [Author]” formats. In those cases, minor CSS tweaks or theme‑specific adjustments may be needed. For theme‑specific guidance, consult your theme’s documentation or support forums.

---

## ⚠️ Disclaimer

Sectorize **replaces WordPress’s native author archive system**.  
- The default `/author/{username}` URLs are redirected to `/sector/{nickname}`.  
- Native author archives will not function in the current version of Sectorize.  
- Plugins or themes that depend on WordPress’s default author slugs may require adjustments.  
- Sectorize is designed for **collective authorship and sector‑based bylines**, not for individual author archives.  

---

## 📄 License

GPL v2 or later — fully open source

---

## 🛠 Development

Development takes place on [GitHub](https://github.com/rancidbluecheese/sectorize).  
Contributions, issues, and feature requests are welcome!

---

## 🤝 Contributing

Contributions are welcome! Whether it’s bug reports, feature requests, or pull requests, your input helps improve Sectorize.

### Pull Requests
- Fork the repository and create a feature branch (`git checkout -b feature/my-feature`).
- Make sure your changes are modular and well‑documented.
- Run tests locally and confirm the plugin activates without errors.
- Submit a clear PR description explaining the problem solved or feature added.

### Coding Standards
- Follow [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/).
- Use **PHPCS** with the WordPress ruleset to lint your code:
  ```bash
  composer install
  vendor/bin/phpcs --standard=WordPress --ignore=vendor .
  ```
- Escape output (`esc_html`, `esc_url`) and sanitize input (`sanitize_text_field`, `wp_nonce_field`) consistently.
- Prefer `__DIR__` over `dirname(__FILE__)` for path resolution (PHP ≥ 5.3).
- Keep functions small and focused; avoid mixing UI and logic.

### Commit Messages
- Use clear, descriptive commit messages (e.g., `Fix: sanitize sector nickname input`).
- Prefix with `Fix:`, `Add:`, `Update:`, or `Docs:` for clarity.

### Issues
- Before opening a new issue, check if it already exists.
- Include WordPress/PHP version and reproduction steps when reporting bugs.

---

## 🛠 Development Setup

To work on Sectorize locally:

1. Clone the repository:
   ```bash
   git clone https://github.com/rancidbluecheese/sectorize.git
   ```
2. Install dependencies:
   ```bash
   composer install
   ```
3. Set up a local WordPress environment (e.g., using [Local](https://localwp.com/) or [wp-env](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/)).
4. Copy the plugin folder into your WordPress `wp-content/plugins` directory.
5. Activate **Sectorize** from the WordPress admin dashboard.
6. Run PHPCS to ensure coding standards compliance before committing.

---

## 📄 License

GPL v2 or later — fully open source

---

## 📢 Acknowledgements

Sectorize builds on WordPress’s native author archive system, re‑framing it for collective authorship and governance‑safe presentation. Thanks to the WordPress community for coding standards and reviewer guidance.