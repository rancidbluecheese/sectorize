# Contributing to Sectorize

Thank you for considering contributing to Sectorize! This document outlines the guidelines for contributing to the project.

## 🔧 Development Setup

1. **Fork the repository** on GitHub
2. **Clone your fork** locally:
   ```bash
   git clone https://github.com/YOUR-USERNAME/sectorize.git
   cd sectorize
   ```
3. **Install dependencies**:
   ```bash
   composer install
   ```

## 📝 Coding Standards

- Follow [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/)
- Use tabs for indentation (not spaces)
- Add PHPDoc blocks for all functions and classes
- Prefix all functions with `sectorize_`
- Use meaningful variable and function names

### Check Your Code

Before submitting:

```bash
# Check coding standards
composer run phpcs

# Auto-fix issues
composer run phpcbf
```

## 🔀 Git Workflow

1. **Create a feature branch**:
   ```bash
   git checkout -b feature/your-feature-name
   ```

2. **Make your changes** with clear, atomic commits:
   ```bash
   git add .
   git commit -m "Add: Brief description of changes"
   ```

3. **Push to your fork**:
   ```bash
   git push origin feature/your-feature-name
   ```

4. **Create a Pull Request** on GitHub

### Commit Message Format

Use clear, descriptive commit messages:

- `Add:` for new features
- `Fix:` for bug fixes
- `Update:` for improvements to existing features
- `Refactor:` for code refactoring
- `Docs:` for documentation changes
- `Test:` for test-related changes

Example: `Add: Nickname mapping functionality for Phase 1b`

## 🧪 Testing

- Test all changes in a local WordPress environment
- Verify compatibility with WordPress 6.0+
- Test with common plugins (Yoast SEO, Rank Math, Elementor)
- Check both frontend and admin functionality

## 📋 Pull Request Guidelines

- Keep PRs focused on a single feature or fix
- Include a clear description of changes
- Reference any related issues
- Ensure all tests pass
- Update documentation if needed

## 🐛 Reporting Issues

When reporting issues, include:

- WordPress version
- PHP version
- Theme and active plugins
- Steps to reproduce
- Expected vs actual behavior
- Error messages or screenshots

## 📖 Documentation

- Update README.md for user-facing changes
- Update inline code documentation
- Add examples where helpful

## ❓ Questions?

Open an issue on GitHub with the `question` label.

## 📄 License

By contributing, you agree that your contributions will be licensed under GPL v2 or later.