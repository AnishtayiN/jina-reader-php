# Jina Reader

> Convert any web page to clean Markdown directly from your browser - no server needed!

A lightweight, fully client-side tool for converting web pages to Markdown format, hosted on GitHub Pages.

## Features

- **No server needed** - Fully Client-Side, works on GitHub Pages
- Modern dark UI with beautiful design
- One-click copy to clipboard
- Download output as .md file
- Full UTF-8 support
- Fast conversion via Jina Reader API
- Responsive design for mobile and desktop

## Usage

### Online (GitHub Pages)

**[Open Live Demo](https://anishtayin.github.io/jina-reader-php/)**

1. Enter the URL of any web page
2. Click the **Convert** button
3. Copy or download the Markdown output!

### Offline

1. Download this repository
2. Open index.html in any modern browser
3. Done - no server or installation required!

### Direct API

You can also use the Jina Reader API directly:

    GET https://r.jina.ai/YOUR_URL

## Project Structure

    jina-reader-php/
    |-- index.html    # Main application (single-file SPA)
    |-- README.md     # This file

## How It Works

The app uses the free Jina Reader API to fetch and convert web pages. Everything runs in your browser with zero server-side processing.

## License

MIT - free to use and modify.

---

Made with love by [AnishtayiN](https://github.com/AnishtayiN)
