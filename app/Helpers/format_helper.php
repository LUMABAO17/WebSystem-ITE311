<?php

if (! function_exists('formatSizeUnits')) {
    function formatSizeUnits($bytes = 0)
    {
        $bytes = (float) $bytes;

        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        }

        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        }

        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }

        if ($bytes > 1) {
            return $bytes . ' bytes';
        }

        if ($bytes == 1) {
            return $bytes . ' byte';
        }

        return '0 bytes';
    }
}

if (! function_exists('formatBytes')) {
    function formatBytes($bytes = 0)
    {
        return formatSizeUnits($bytes);
    }
}
