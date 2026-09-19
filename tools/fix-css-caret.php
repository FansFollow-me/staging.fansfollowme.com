<?php

// CSS content: '&#9662;' displays literally in browsers.
// Use CSS unicode escape \25BE instead (same as ▾).

$dir = __DIR__.'/../resources/views/marketing';
$files = glob($dir.'/*-exact.blade.php');

foreach ($files as $file) {
    $c = file_get_contents($file);
    $orig = $c;

    $c = str_replace("content: '&#9662;'", "content: '\\25BE'", $c);
    $c = str_replace("content: '&#8964;'", "content: '\\25BE'", $c);
    // FAQ chevrons in HTML body are fine as entities; only CSS is broken.
    // If any CSS has the entity in other rules:
    $c = preg_replace("/content:\s*'&#9662;'/", "content: '\\25BE'", $c);

    if ($c !== $orig) {
        file_put_contents($file, $c);
        echo 'FIXED '.basename($file)."\n";
    }
}

// Also app nav CSS
$appCss = __DIR__.'/../public/css/ffm-app.css';
if (is_file($appCss)) {
    $c = file_get_contents($appCss);
    if (strpos($c, '&#9662;') !== false || strpos($c, "content: '▾'") !== false) {
        $c = preg_replace("/content:\s*'&#9662;'/", "content: '\\25BE'", $c);
        file_put_contents($appCss, $c);
        echo "FIXED ffm-app.css\n";
    }
}

echo "done\n";
