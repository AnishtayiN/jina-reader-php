# 🎯 Jina Reader PHP

> Convert any web page into clean, readable **Markdown** — in seconds.

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](LICENSE)
[![PHP](https://img.shields.io/badge/PHP-%3E%3D7.4-777BB4.svg?logo=php&logoColor=white)](https://php.net)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](CONTRIBUTING.md)
[![Demo](https://img.shields.io/badge/Live-Demo-0ea5e9.svg)](https://anishtayin.github.io/jina-reader-php/)

A tiny, **zero-dependency** PHP tool that turns any URL into clean Markdown using the power of [r.jina.ai](https://r.jina.ai). Works in your **browser**, from your **terminal**, or as a **web API** — no API key required.

---

## ✨ Features

| Feature | Description |
|---|---|
| ⚡ Instant | Converts pages to Markdown in milliseconds via r.jina.ai |
| 🌍 No API key | Just a URL, nothing else needed |
| 🖥️ 3-in-1 | Web UI + CLI + REST API in one repo |
| 🎨 Modern UI | Glassmorphism dark theme, responsive, RTL-friendly |
| 📋 One-click copy | Copy the output or download it as `.md` |
| 🕘 History | Recently converted URLs stored locally (Web UI) |
| 🧩 JSON output | API & CLI can return structured JSON |
| 📦 Zero deps | Pure PHP, nothing to `composer install` |

---

## 🚀 Quick Start

### 1️⃣ Web UI (zero setup)

Open `index.html` directly in your browser, or use the hosted demo:

> **https://anishtayin.github.io/jina-reader-php/**

Paste a URL, hit **Convert**, and copy the Markdown. Done.

### 2️⃣ CLI

```bash
# Basic conversion
php cli.php https://example.com

# Save to a file
php cli.php https://example.com -o article.md

# Get JSON output (pipe into jq, etc.)
php cli.php https://example.com --json
```

### 3️⃣ REST API (self-hosted)

```bash
# Start the built-in PHP server
php -S localhost:8000 index.php

# Then convert any URL
curl "http://localhost:8000/?url=https://example.com"

# Or get JSON
curl "http://localhost:8000/?url=https://example.com&format=json"
```

---

## 🧑‍💻 Usage Examples

**curl one-liner (no server needed):**
```bash
curl "https://r.jina.ai/https://github.com"
```

**Save a page as Markdown:**
```bash
php cli.php https://en.wikipedia.org/wiki/Markdown -o markdown.md
```

**Integrate into your app:**
```javascript
const md = await (await fetch("https://r.jina.ai/" + url)).text();
```

---

## 📁 Project Structure

```
jina-reader-php/
├── index.html    # Web UI (GitHub Pages, zero backend)
├── index.php     # Self-hosted REST API + web form
├── cli.php       # Command-line converter
├── LICENSE       # MIT
└── README.md     # You are here
```

---

## 🛠️ Requirements

- **Web UI:** none — just a browser
- **CLI / API:** PHP 7.4+ (with `allow_url_fopen` enabled for `file_get_contents`, or cURL)

---

## 🤝 Contributing

Pull requests are welcome! Found a bug or have an idea? Open an [issue](https://github.com/AnishtayiN/jina-reader-php/issues).

1. Fork the repo
2. Create a branch: `git checkout -b feature/awesome`
3. Commit your changes: `git commit -m "Add awesome feature"`
4. Push and open a PR

---

## 📄 License

MIT © [AnishtayiN](https://github.com/AnishtayiN) — free to use, modify, and share.

---

<p align="center">
  Made with ❤️ — if this helped you, please give it a ⭐!
</p>