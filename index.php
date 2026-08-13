<?php
/**
 * Jina AI Reader Clone - PHP Web Server
 * تبدیل هر صفحه وب به Markdown تمیز
 */

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

// API endpoint
if (isset($_GET['url'])) {
    $url = filter_var($_GET['url'], FILTER_VALIDATE_URL);
    if (!$url) {
        http_response_code(400);
        die('URL نامعتبر است');
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
        http_response_code(502);
        die('خطا در دریافت صفحه');
    }
    
    $data = extractMarkdown($html);
    $markdown = htmlToMarkdown($data['content']);
    
    header('Content-Type: text/plain; charset=utf-8');
    echo "Title: {$data['title']}\n";
    echo "URL Source: {$url}\n";
    echo "Published Time: " . date('D, d M Y H:i:s', strtotime('now')) . " GMT\n\n";
    echo "Markdown Content:\n";
    echo $markdown;
    exit;
}
?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جیناز خوان - خوان‌خوان</title>
    <style>
        body {font-family: Tahoma, sans-serif; max-width: 800px; margin: 2rem auto; padding: 1rem; direction: rtl;}
        .form-group {margin: 1rem 0;}
        input[type="url"] {width: 100%; padding: 0.5rem; font-size: 1rem;}
        button {padding: 0.5rem 1rem; font-size: 1rem; background: #007bff; color: white; border: none; cursor: pointer; margin-top: 0.5rem;}
        button:hover {background: #0056b3;}
        .note {background: #e7f3ff; padding: 1rem; border-radius: 5px; margin-top: 1rem;}
        code {background: #f4f4f4; padding: 0.2rem 0.4rem; border-radius: 3px;}
    </style>
</head>
<body>
    <h1>جیناز خوان - Web Page to Markdown</h1>
    <p>تبدیل هر صفحه وب به Markdown تمیز</p>
    
    <form method="get" action="">
        <div class="form-group">
            <label>آدرس صفحه:</label><br>
            <input type="url" name="url" placeholder="https://example.com" required>
        </div>
        <button type="submit">تبدیل به Markdown</button>
    </form>
    
    <div class="note">
        <strong>نحوه استفاده:</strong><br>
        مستقیماً: <code>curl "http://your-server.com/?url=https://example.com"</code><br>
        در مرورگر: <code>http://your-server.com/?url=https://example.com</code>
    </div>
</body>
</html>