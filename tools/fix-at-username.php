<?php

// Fix @{{ $foo }} → {{ '@'.$foo }} so usernames render with @ prefix
$dir = __DIR__.'/../resources/views';
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

foreach ($files as $file) {
    if (! $file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }
    $path = $file->getPathname();
    $c = file_get_contents($path);
    if (strpos($c, '@{{') === false) {
        continue;
    }

    $orig = $c;
    // @{{ $user->username }} → {{ '@'.$user->username }}
    $c = preg_replace_callback(
        '/@\{\{\s*(\$[A-Za-z0-9_>\-\>\(\)\?\'\":\s]+?)\s*\}\}/',
        function ($m) {
            $expr = trim($m[1]);

            return "{{ '@'.".$expr.' }}';
        },
        $c
    );

    if ($c !== $orig) {
        file_put_contents($path, $c);
        echo 'FIXED '.basename($path)."\n";
    }
}

echo "done\n";
