<?php
// Minimal CLI error view to allow spark commands to show errors
// Variables typically provided: $title, $message, $exception, $file, $line, $trace
?>
<?= isset($title) ? $title : 'CLI Error' ?>

<?= isset($message) ? $message : ($exception->getMessage() ?? 'An error occurred.') ?>

File: <?= isset($file) ? $file : ($exception->getFile() ?? 'unknown') ?>
Line: <?= isset($line) ? $line : ($exception->getLine() ?? 'unknown') ?>

Trace:
<?php
if (isset($trace) && is_array($trace)) {
    foreach ($trace as $t) {
        echo (isset($t['file']) ? $t['file'] : '[internal]') . ':' . (isset($t['line']) ? $t['line'] : '-') . "\n";
        if (isset($t['class']) || isset($t['function'])) {
            echo '  -> ' . ($t['class'] ?? '') . ($t['type'] ?? '') . ($t['function'] ?? '') . "()\n";
        }
    }
} else {
    echo $exception->getTraceAsString();
}
