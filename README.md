# Jina AI Reader - PHP Clone

تبدیل هر صفحه وب به Markdown تمیز با PHP، مشابه [r.jina.ai](https://r.jina.ai).

## ✨ امکانات
- تبدیل HTML به Markdown تمیز
- استخراج عنوان و زمان انتشار
- پشتیبانی از UTF-8 و زبان فارسی
- دو حالت اجرا: وب‌سرور و خط فرمان

## 🚀 استفاده

### حالت وب‌سرور (index.php)
فایل `index.php` را در دایرکتوری وب‌سرور خود قرار دهید و با دستور زیر اجرا کنید:

```bash
php -S localhost:8000 -t .
```

سپس در مرورگر آدرس زیر را باز کنید:

```
http://localhost:8000/?url=https://example.com
```

یا از طریق API:

```bash
curl "http://localhost:8000/index.php?url=https://example.com"
```

### حالت خط فرمان (cli.php)
```bash
php cli.php https://example.com
```

## 📄 نمونه خروجی
```
Title: Example Domain
URL Source: https://example.com/
Published Time: Wed, 12 Aug 2026 20:15:57 GMT
Markdown Content:
This domain is for use in documentation examples...
```

## 📁 ساختار فایل‌ها
```
jina-reader-php/
├── index.php    # وب‌سرور + فرم وب
├── cli.php      # خط فرمان
└── README.md    # این فایل
```

## 📜 لایسنس
MIT - آزاد برای استفاده و تغییر