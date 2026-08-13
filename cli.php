#!/usr/bin/env php
<?php
/**
 * Jina Reader CLI — convert any web page to clean Markdown.
 *
 * Usage:
 *   php cli.php <url> [options]
 *
 * Options:
 *   -o, --output <file>   Save output to a file
 *   -j, --json            Output JSON instead of plain Markdown
 *   -q, --quiet           Print only the Markdown content
 *   -h, --help            Show this help
 *
 * Examples:
 *   php cli.php https://example.com
 *   php cli.php https://example.com -o article.md
 *   php cli.php https://example.com --json
 */

// Parse arguments
$args = $argv;
array_shift($args); // remove script name

$url = null;
$outputFile = null;
$asJson = false;
$quiet = false;

for ($i = 0; $i < count($args); $i++) {
    $a = $args[$i];
    switch ($a) {
        case '-h':
        case '--help':
            echo <<<HELP
Jina Reader CLI — convert any web page to clean Markdown.

Usage:
  php cli.php <url> [options]

Options:
  -o, --output <file>   Save output to a file
  -j, --json            Output JSON instead of plain Markdown
  -q, --quiet           Print only the Markdown content
  -h, --help            Show this help

Examples:
  php cli.php https://example.com
  php cli.php https://example.com -o article.md
  php cli.php https://example.com --json

HELP;
            exit(0);
        case '-o':
        case '--output':
            $outputFile = $args[++$i] ?? null;
            break;
        case '-j':
        case '--json':
            $asJson = true;
            break;
        case '-q':
        case '--quiet':
            $quiet = true;
            break;
        default:
            if ($a[0] === '-') {
                fwrite(STDERR, "Unknown option: $a\n");
                exit(1);
            }
            $url = $a;
    }
}

if ($url === null) {
    fwrite(STDERR, "Error: no URL provided.\n");
    fwrite(STDERR, "Run `php cli.php --help` for usage.\n");
    exit(1);
}

if (!filter_var($url, FILTER_VALIDATE_URL)) {
    fwrite(STDERR, "Error: invalid URL.\n");
    exit(1);
}

// Colors (only when on a TTY and not quiet)
function color(string $text, string $code, bool $enabled): string {
    return $enabled ? "\033[{$code}m{$text}\033[0m" : $text;
}
$useColor = !$quiet && function_exists('posix_isatty') && posix_isatty(STDOUT);
$green = fn($t) => color($t, '32', $useColor);
$red   = fn($t) => color($t, '31', $useColor);
$cyan  = fn($t) => color($t, '36', $useColor);

if (!$quiet) {
    fwrite(STDERR, $cyan("Fetching: ") . $url . "\n");
}

$apiUrl = 'https://r.jina.ai/' . $url;
$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'header' => "Accept: text/markdown\r\n" .
                    "X-Return-Format: markdown\r\n" .
                    "User-Agent: JinaReaderCLI/1.0\r\n",
        'timeout' => 30,
    ],
    'ssl' => ['verify_peer' => false, 'verify_peer_name' => false],
]);

$response = @file_get_contents($apiUrl, false, $context);

if ($response === false) {
    fwrite(STDERR, $red("Error: ") . "failed to fetch content from r.jina.ai.\n");
    exit(1);
}

if ($asJson) {
    $out = json_encode([
        'success' => true,
        'url'     => $url,
        'content' => $response,
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} else {
    $out = $response;
}

if ($outputFile !== null) {
    if (@file_put_contents($outputFile, $out) === false) {
        fwrite(STDERR, $red("Error: ") . "could not write to file: $outputFile\n");
        exit(1);
    }
    if (!$quiet) {
        fwrite(STDERR, $green("Saved to: ") . $outputFile . "\n");
    }
} else {
    echo $out;
    if (!$asJson && substr($out, -1) !== "\n") {
        echo "\n";
    }
}

exit(0);