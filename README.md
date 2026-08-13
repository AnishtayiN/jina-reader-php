# Jina AI Reader - PHP Clone

یک کلون ساده از [r.jina.ai](https://r.jina.ai) که هر صفحه وب را به Markdown تمیز تبدیل می‌کند.

## ویژگی‌ها
- تبدیل HTML به Markdown تمیز
- استخراج عنوان صفحه
- پشتیبانی از UTF-8 و فارسی
- دو حالت: وب‌سرور و خط فرمان (CLI)

## نصب
```bash
# پیش‌نیازها
apt update && apt install -y php php-curl php-xml php-dom

# یا روی سیستم‌های دیگر
# sudo apt install php php-curl php-xml php-dom
```

## استفاده

### وب‌سرور (index.php)
فایل `index.php` را در دایرکتوری وب‌سرور خود قرار دهید (Apache/Nginx/PHP built-in server):

```bash
# با PHP built-in server
php -S localhost:8000 -t /path/to/jina-reader-php

# سپس در مرورگر:
http://localhost:8000/?url=https://example.com
```

**API مستقیم:**
```bash
curl "http://your-server.com/index.php?url=https://example.com"
```

### خط فرمان (cli.php)
```bash
php cli.php https://example.com
```

## خروجی نمونه
```
Title: Example Domain

URL Source: https://example.com/

Published Time: Wed, 12 Aug 2026 20:15:57 GMT

Markdown Content:
This domain is for use in documentation examples without needing permission. Avoid use in operations.

[Learn more](https://iana.org/domains/example)
```

## ساختار فایل‌ها
```
jina-reader-php/
├── index.php    # وب‌سرور + فرم وب
├── cli.php      # خط فرمان
└── README.md    # این فایل
```

## لایسنس
MIT - آزاد برای استفاده و تغییر