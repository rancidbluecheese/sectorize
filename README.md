# Sectorize

An **elegant, plug-and-play** WordPress plugin that transforms author archives into flexible sector-based content organization with automatic SEO optimization.

## ⭐ Why Sectorize?

- **Zero Configuration**: Install, activate, and it works immediately
- **Elegant Architecture**: Repurposes WordPress's built-in author system - no custom post types or taxonomies
- **SEO-Ready**: Automatic JSON-LD schema, optimized titles, and canonical URLs
- **Smart Redirects**: 301 redirects from `/author/username` to clean `/sector/nickname` URLs
- **Collective Authorship**: Uses your admin nickname for consistent site branding

## 🌟 Live Demo

**See it in action at [ICTStart.com](https://ictstart.com):**
- [Article Sector](https://ictstart.com/sector/article/)
- [News Sector](https://ictstart.com/sector/news/)
- [Insights Sector](https://ictstart.com/sector/insights/)

## 🎯 Perfect For

### Content Creators & Bloggers
Organize content by type without showing individual author names on every post.

### Industry Portals  
Create sectors like "Finance," "Technology," "Healthcare" for clean content organization.

### Corporate Sites
Organize by department: "Marketing," "Sales," "Support" with automatic sector archives.

### Regional Content
Geographic organization: "North America," "Europe," "Asia Pacific."

## 🚀 Quick Start

1. **Install** via Plugins → Add New → Upload Plugin
2. **Activate** Sectorize  
3. **Create users** with sector nicknames (e.g., "Video", "Review")
4. **Assign posts** to sector users via Quick Edit
5. **Done!** Content appears at `/sector/nickname/`

### Example Setup
```
Username: one
Nickname: Insights  
Role: Contributor
```
Posts assigned to this user appear at `/sector/insights/`

## ✨ How It Works

Sectorize cleverly repurposes WordPress's author system:
- **Users = Sectors**: Each user represents a content sector
- **Nicknames = URLs**: User nicknames become `/sector/{nickname}/` URLs  
- **Posts = Content**: Assign posts to users for automatic sector organization
- **SEO = Automatic**: Schema markup and optimization included

## 🔧 Features

- **Automatic URL Rewriting**: `/author/john-doe` → `/sector/finance`
- **Schema Markup**: JSON-LD for articles and collection pages
- **Legacy Support**: SEO-friendly 301 redirects
- **Collective Branding**: Admin nickname becomes site author
- **Zero Overhead**: Uses existing WordPress infrastructure

## 🎨 Default Settings

Includes sensible defaults:
- Sector base: `sector` (creates `/sector/name/` URLs)
- Collective author: Administrator nickname
- Schema source: Site's built-in metadata
- No configuration needed

## 📄 License

GPL v2 or later - fully open source

## 🤝 Support

- **Issues**: [GitHub Issues](https://github.com/rancidbluecheese/sectorize/issues)
- **Development**: Active development on GitHub

*WordPress.org support forum coming after plugin approval*

## 🏆 Credits

Created by [Marg Choco](https://ictstart.com) | Originally developed for ICTStart.com

---

## 🚀 Development Status

**Phase 1 Complete** ✅
- [x] Core functionality (URL rewriting, redirects, SEO, schema)
- [x] Plugin tested on WordPress 6.0+
- [ ] WordPress.org submission (Phase 2 in progress)
