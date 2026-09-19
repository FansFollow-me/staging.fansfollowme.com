<?php

// Replace raw UTF-8 emoji in marketing views with HTML entities (unbreakable).
$dir = __DIR__.'/../resources/views/marketing';
$files = glob($dir.'/*-exact.blade.php');

// Correct UTF-8 emoji => entity
$map = [
    "\xF0\x9F\x8E\xAC" => '&#127912;', // 🎬 clapper
    "\xF0\x9F\x94\xB4" => '&#128308;', // 🔴 red circle
    "\xF0\x9F\x92\xBC" => '&#128188;', // 💼 briefcase
    "\xF0\x9F\x92\xAC" => '&#128172;', // 💬 speech
    "\xF0\x9F\x91\xA4" => '&#128100;', // 👤 person
    "\xF0\x9F\x94\xA5" => '&#128293;', // 🔥 fire
    "\xE2\x96\xBE" => '&#9662;',       // ▾ down triangle
    "\xE2\x80\x94" => '&#8212;',       // — em dash
    "\xE2\x80\x93" => '&#8211;',       // – en dash
    "\xE2\x80\x99" => "'",             // ’
    "\xE2\x80\x9C" => '"',             // “
    "\xE2\x80\x9D" => '"',             // ”
    "\xE2\x80\xA2" => '&#8226;',       // • bullet
];

foreach ($files as $file) {
    $c = file_get_contents($file);
    $orig = $c;
    foreach ($map as $utf8 => $entity) {
        $c = str_replace($utf8, $entity, $c);
    }
    if ($c !== $orig) {
        file_put_contents($file, $c);
        echo 'ENTITIED '.basename($file)."\n";
    } else {
        echo 'ok       '.basename($file)."\n";
    }
}
echo "done\n";
