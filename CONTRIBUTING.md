# Contributing to Sectorize

Thanks for your interest in improving **Sectorize**! Contributions of all kinds are welcome — bug reports, feature requests, documentation, and pull requests.

## 🛠 How to Contribute

1. **Fork & Branch**
   - Fork the repository
   - Create a feature branch: `git checkout -b feature/my-feature`

2. **Code Standards**
   - Follow [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/)
   - Run PHPCS before committing:
     ```bash
     composer install
     vendor/bin/phpcs --standard=WordPress --ignore=vendor .
     ```
   - Escape output (`esc_html`, `esc_url`) and sanitize input (`sanitize_text_field`, `wp_nonce_field`)

3. **Commit Messages**
   - Use clear, descriptive messages
   - Prefix with `Fix:`, `Add:`, `Update:`, or `Docs:` for clarity

4. **Pull Requests**
   - Ensure the plugin activates without errors
   - Document your changes in the PR description
   - Keep functions modular and governance‑safe

## 🐛 Issues

- Check existing issues before opening a new one
- Include WordPress/PHP version and reproduction steps when reporting bugs

---

By following these guidelines, you help keep Sectorize secure, reviewer‑friendly, and easy to maintain.