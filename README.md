# 🗖 Jina Reader

> tbdil hr sffm bh Markdown tmiz — mstqim az mrvzr, bdun niaz be sever

<div align="center">

[![Live Demo](https://img.shields.io/badge/Live_Demo-GitHub_Pages-blue?style=for-the-badge)](https://anishtayin.github.io/jina-reader-php/)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](#license)

</div>

---

## 🚀 use

### In Browser

1. [Open here](https://anishtayin.github.io/jina-reader-php/)
2. Enter the URL of the page you want to convert
3. Click **Convert**
4. Copy or Download the result

### Direct API

From terminal:

```bash
curl "https://r.jina.ai/https://example.com"
```

In JavaScript:

```javascript
const resp = await fetch('https://r.jina.ai/https://example.com', {
    headers: { 'Accept': 'text/markdown' }
});
const markdown = await resp.text();
console.log(markdown);
```

### Bookmarklet

Save this as a bookmark to instantly convert any page:

```javascript
javascript:window.location='https://r.jina.ai/'+window.location.href
```

---

## ✪ Features

| Feature | Description |
|-------|-----------|
| no server | Just a single HTML file, runs on GitHub Pages |
| Copy/Download | Quickly copy or download Markdown output |
| Beautiful UI | Modern design with RTL support |
| Responsive | Works on mobile and desktop |
| CORS Fallback | Automatically falls back to CORS proxy if blocked |
| Stats | Shows lines, words, and fetch time |

---

## 💣 Tips

- Jina Reader extracts the main content (not raw HTML)
- For very large pages, it might take a few seconds
- If a page is blocked, you can use [r.jina.ai](https://r.jina.ai) directly

---

<div align="center">
Made with ✨️ | Powered by [Jina AI](https://jina.ai/reader)
</div>