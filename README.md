# 📖 Jina Reader

> Convert any webpage to clean Markdown instantly — no server needed.

**[🌐 Live Demo](https://anishtayin.github.io/jina-reader-php)**

---

## 🚀 Usage

### Online
1. Open **[Jina Reader](https://anishtayin.github.io/jina-reader-php)**
2. Paste any webpage URL
3. Click **Convert**
4. Copy or download the Markdown output

### Offline
Download `index.html` and open it in any browser — works without a server.

### Direct API
Use the endpoint directly: `GET https://r.jina.ai/YOUR_URL`

**Example:**
```
https://r.jina.ai/https://en.wikipedia.org/wiki/Persian_literature
```

**With curl:**
```bash
curl "https://r.jina.ai/https://example.com"
```

**With JavaScript:**
```javascript
fetch('https://r.jina.ai/https://example.com')
  .then(r => r.text())
  .then(markdown => console.log(markdown));
```

### Bookmarklet
Save this as a bookmark to instantly convert any page:

```javascript
javascript:window.location='https://r.jina.ai/'+window.location.href
```

---

## ✨ Features

| Feature | Description |
|---------|-------------|
| ⚡ No hosting | Works on GitHub Pages, no server needed |
| 📋 Quick copy | One-click copy output |
| ⬇️ Download | Save output as .md file |
| 📱 Responsive | Mobile and desktop friendly |
| 🌙 Modern UI | Clean dark theme |
| 🌍 RTL support | Full Persian & UTF-8 support |

---

## 📄 License

MIT — free to use and modify.

---

Made with ❤️ by [AnishtayiN](https://github.com/AnishtayiN)
