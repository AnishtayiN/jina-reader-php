#!/usr/bin/env php
<?php
/**
 * Jina Reader CLI - تبدیل هر صفحه وب به Markdown تمیز
 * استفاده: php cli.php <URL>
 * مثال:   php cli.php https://example.com
 */

if ($argc < 2) {
    fwrite(STDERR, "استفاده: php cli.php <URL>\n");
    fwrite(STDERR, "مثال: php cli.php https://example.com\n");
    exit(1);
}

$url = $argv[1];

if (!filter_var($url, FILTER_VALIDATE_URL)) {
    fwrite(STDERR, "خطا: آدرس وارد شده معتبر نیست.\n");
    exit(1);
}

// استفاده از سرویس r.jina.ai برای تبدیل
$apiUrl = 'https://r.jina.ai/' . $url;
$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'header' => "Accept: text/markdown\r\n" .
                    "X-Return-Format: markdown\r\n" .
                    "User-Agent: JinaReaderCLI/1.0\r\n"
    ]
]);

$response = @file_get_contents($apiUrl, false, $context);

if ($response === false) {
    fwrite(STDERR, "خطا: دریافت محتوا از سرور ناموفق بود.\n");
    exit(1);
}

echo $response;
exit(0);