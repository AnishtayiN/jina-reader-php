#!/usr/bin/env php
<?php
/**
 * Jina AI Reader Clone - CLI Version
 * تبدیل هر صفحه وب به Markdown تمیز (نسخه خط فرمان)
 */

require_once __DIR__ . '/index.php';

if ($argc < 2) {
    echo "استفاده: php cli.php <URL>\n";
    echo "مثال: php cli.php https://example.com\n";
    exit(1);
}

$url = $argv[1];

if (!filter_var($url, FILTER_VALIDATE_URL)) {
    echo "URL نامعتبر است\n";
    exit(1);
}

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_USERAGENT => 'JinaReader/1.0',
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_HTTPHEADER => ['Accept-Language: fa-IR,en;q=0.9']
]);

$html = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if (empty($html) || $httpCode >= 400) {
    echo "خطا در دریافت صفحه (HTTP $httpCode)\n";
    exit(1);
}

function extractTitle($html) {
    if (preg_match('/<title[^>]*>(.*?)<\/title>/is', $html, $matches)) {
        return htmlspecialchars(strip_tags($matches[1]), ENT_QUOTES, 'UTF-8');
    }
    return 'بدون عنوان';
}

function extractMarkdown($html) {
    $doc = new DOMDocument();
    @$doc->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_NOERROR);
    
    $xpath = new DOMXPath($doc);
    $titleNodes = $xpath->query('//title | //meta[@property="og:title"] | //meta[@name="twitter:title"]');
    
    $title = '';
    foreach ($titleNodes as $node) {
        if ($node->nodeName == 'meta') {
            $content = $node->getAttribute('content');
            if ($content) { $title = $content; break; }
        } else {
            $title = $node->textContent; break;
        }
    }
    
    $articleNodes = $xpath->query('//article | //main | //div[@class="content"]');
    if ($articleNodes->length > 0) {
        $body = $articleNodes->item(0)->textContent;
    } else {
        $body = $xpath->query('//body')->item(0)->textContent;
    }
    
    return [
        'title' => trim($title ?: 'بدون عنوان'),
        'content' => trim($body)
    ];
}

function htmlToMarkdown($html) {
    $patterns = [
        '/<h1[^>]*>(.*?)<\/h1>/is' => "# $1\n",
        '/<h2[^>]*>(.*?)<\/h2>/is' => "## $1\n",
        '/<h3[^>]*>(.*?)<\/h3>/is' => "### $1\n",
        '/<strong[^>]*>(.*?)<\/strong>/is' => "**$1**",
        '/<b[^>]*>(.*?)<\/b>/is' => "**$1**",
        '/<em[^>]*>(.*?)<\/em>/is' => "*$1*",
        '/<i[^>]*>(.*?)<\/i>/is' => "*$1*",
        '/<a[^>]*href=["\']?(.*?)["\']?[^>]*>(.*?)<\/a>/is' => "[$2]($1)",
        '/<code[^>]*>(.*?)<\/code>/is' => "`$1`",
        '/<pre[^>]*><code[^>]*>(.*?)<\/code><\/pre>/is' => "```\n$1\n```\n",
        '/<br\s*\/?>/is' => "\n",
        '/<\/?[^>]*>/' => '',
        '/&nbsp;/i' => ' ',
    ];
    
    return preg_replace(array_keys($patterns), array_values($patterns), $html);
}

$data = extractMarkdown($html);
$markdown = htmlToMarkdown($data['content']);

echo "Title: {$data['title']}\n";
echo "URL Source: {$url}\n";
echo "Published Time: " . date('D, d M Y H:i:s', strtotime('now')) . " GMT\n\n";
echo "Markdown Content:\n";
echo $markdown;