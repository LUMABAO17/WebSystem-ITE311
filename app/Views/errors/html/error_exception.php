<!DOCTYPE html>
<html>
<head>
    <title>Error - <?= esc($exception->getCode() ?: 'Error') ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: left;
        }
        h1 {
            color: #d9534f;
        }
        pre {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 4px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>An Error Occurred</h1>
        <p>Code: <?= esc($exception->getCode() ?: 'N/A') ?></p>
        <p>Message: <?= esc($exception->getMessage()) ?></p>
        
        <?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === true): ?>
            <h3>Backtrace:</h3>
            <pre><?= esc(print_r(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS), true)) ?></pre>
            
            <h3>Server/Request Data</h3>
            <pre><?= esc(print_r([
                'URI' => current_url(true),
                'Request Method' => $_SERVER['REQUEST_METHOD'] ?? 'CLI',
                'HTTP Referrer' => $_SERVER['HTTP_REFERER'] ?? '',
                'IP Address' => $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0',
                'User Agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
                'Session' => isset($_SESSION) ? $_SESSION : []
            ], true)) ?></pre>
        <?php endif; ?>
        
        <p><a href="<?= base_url() ?>">Back to Home</a></p>
    </div>
</body>
</html>
