# Security Policy

## 🔒 Supported Versions

Only the latest stable release receives security updates.

| Version | Supported          |
| ------- | ------------------ |
| 0.1.x   | :white_check_mark: |
| < 0.1.0 | :x:                |

## 🚨 Reporting a Vulnerability

If you discover a security vulnerability in Sectorize, please report it responsibly:

### ✉️ How to Report

**DO NOT** open a public issue for security vulnerabilities.

Instead, please email the maintainer directly:

- Create a security advisory on GitHub (preferred)
- Or open an issue with the title "SECURITY: [brief description]" (details will be kept private)

### 📝 What to Include

- Description of the vulnerability
- Steps to reproduce
- Potential impact
- Suggested fix (if any)
- Your contact information

### ⏱️ Response Timeline

- **24 hours**: Initial response acknowledging the report
- **7 days**: Assessment and validation of the issue
- **30 days**: Fix development and testing
- **Release**: Coordinated disclosure after patch is available

### 🎖️ Recognition

Security researchers who responsibly disclose vulnerabilities will be credited in:

- The security advisory
- The changelog
- The README (if desired)

## 🛡️ Security Best Practices

This plugin follows security best practices:

- Input sanitization and validation
- Output escaping
- Nonce verification for admin actions
- Capability checks for privileged operations
- Prepared SQL statements (if database queries are added)
- No usage of eval() or similar dangerous functions

## 📢 Security Updates

Security updates will be:

- Released as soon as possible
- Announced in the changelog
- Posted as a GitHub security advisory
- Submitted to WordPress.org plugin repository

## 🤝 Safe Harbor

We support safe harbor for security researchers who:

- Make a good faith effort to avoid privacy violations and service disruptions
- Only interact with accounts they own or have explicit permission to test
- Do not exploit a vulnerability beyond what's necessary to demonstrate it
- Report vulnerabilities promptly
- Keep vulnerability details confidential until a fix is released

Thank you for helping keep Sectorize and its users safe!
