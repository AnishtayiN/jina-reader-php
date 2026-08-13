<?php
/**
 * Jina Reader Web Service
 * تبدیل هر صفحه وب به Markdown تمیز از طریق r.jina.ai
 *
 * استفاده:
 *   مرورگر:  index.php?url=https://example.com
 *   API:     index.php?url=https://example.com&format=json
 */

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$isJson = isset($_GET['format']) && $_GET['format'] === 'json';

function respondError($status, $message, $isJson) {
    http_response_code($status);
    if ($isJson) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success' => false, 'error' => $message], JSON_UNESCAPED_UNICODE);
    } else {
        header('Content-Type: text/plain; charset=utf-8');
        echo $message;
    }
    exit;
}

// حالت API: دریافت Markdown
if (isset($_GET['url']) && $_GET['url'] !== '') {
    $url = filter_var($_GET['url'], FILTER_VALIDATE_URL);

    if (!$url) {
        respondError(400, 'خطا: آدرس وارد شده معتبر نیست.', $isJson);
    }

    $apiUrl = 'https://r.jina.ai/' . $url;
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => "Accept: text/markdown\r\n" .
                        "X-Return-Format: markdown\r\n" .
                        "User-Agent: JinaReaderWeb/1.0\r\n"
        ],
        'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]
    ]);

    $response = @file_get_contents($apiUrl, false, $context);

    if ($response === false) {
        respondError(502, 'خطا: دریافت محتوا از سرور r.jina.ai ناموفق بود.', $isJson);
    }

    if ($isJson) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => true,
            'data' => [
                'url'     => $url,
                'content' => $response
            ]
        ], JSON_UNESCAPED_UNICODE);
    } else {
        header('Content-Type: text/markdown; charset=utf-8');
        echo $response;
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jina Reader — تبدیل وب به Markdown</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: Tahoma, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem 1rem;
            color: #333;
        }
        .container { max-width: 800px; margin: 0 auto; }
        h1 { color: #fff; text-align: center; font-size: 2rem; margin-bottom: 0.5rem; }
        .subtitle { color: rgba(255,255,255,0.9); text-align: center; margin-bottom: 2rem; }
        .card {
            background: #fff;
            border-radius: 14px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 600; }
        input[type="url"] {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            direction: ltr;
            text-align: left;
            transition: border-color 0.2s;
        }
        input[type="url"]:focus { outline: none; border-color: #667eea; }
        button {
            width: 100%;
            padding: 0.85rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 1.05rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s;
        }
        button:hover { transform: translateY(-1px); box-shadow: 0 5px 15px rgba(102,126,234,0.4); }
        .note {
            background: #eef2ff;
            padding: 1rem;
            border-radius: 10px;
            margin-top: 1.25rem;
            font-size: 0.9rem;
            line-height: 1.8;
        }
        code {
            background: #f4f4f4;
            padding: 0.2rem 0.4rem;
            border-radius: 4px;
            direction: ltr;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📖 Jina Reader</h1>
        <p class="subtitle">تبدیل هر صفحه وب به Markdown تمیز</p>

        <div class="card">
            <form method="get" action="">
                <div class="form-group">
                    <label for="url">آدرس صفحه:</label>
                    <input type="url" id="url" name="url" placeholder="https://example.com" required>
                </div>
                <button type="submit">تبدیل به Markdown</button>
            </form>

            <div class="note">
                <strong>نحوه استفاده:</strong><br>
                API مستقیم:
                <code>curl "http://your-server.com/?url=https://example.com"</code><br>
                خروجی JSON:
                <code>curl "http://your-server.com/?url=https://example.com&format=json"</code>
            </div>
        </div>
    </div>
</body>
</html>