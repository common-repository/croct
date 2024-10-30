<?php

\spl_autoload_register(static function ($class) {
    $prefix = 'Croct\\WordPress\\';

    $baseDir = __DIR__ . '/src/';

    $length = \strlen($prefix);

    if (\strncmp($prefix, $class, $length) !== 0) {
        // The class does not use the namespace prefix,
        // delegate to the next registered autoloader
        return;
    }

    // Get the relative class name
    $relativeClass = \substr($class, $length);

    // Replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $baseDir . \str_replace('\\', '/', $relativeClass) . '.php';

    if (\file_exists($file)) {
        require $file;
    }
});
