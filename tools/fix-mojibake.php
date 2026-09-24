<?php

/**
 * Repair mojibake using only hex byte sequences (no literal broken chars in source).
 */

$dir = __DIR__.'/../resources/views/marketing';
$files = glob($dir.'/*-exact.blade.php');

// [hex of broken UTF-8-as-Latin1 bytes] => HTML entity
$pairs = [
    // eŽ¬  (C3 B0 C5 B8 C5 BD C2 AC) clapper
    ['c3b0c5b8c5bdc2ac', '&#127912;'],
    // e”´ red circle
    ['c3b0c5b8e2809dc2ac', '&#128308;'],
    // e'¼ briefcase
    ['c3b0c5b8e2809ec2ac', '&#128188;'],
    // e'¬ speech
    ['c3b0c5b8e2809cc2ac', '&#128172;'],
    // e‘¤ person
    ['c3b0c5b8e28098c2ac', '&#128100;'],
    // v down triangle (c3 a2 e2 80 9c c2 be)
    ['c3a2e2809cc2be', '&#9662;'],
    // v
    ['c3a2e2809bc2be', '&#9662;'],
    // ' apostrophe
    ['c3a2e28099', "'"],
    // “ open quote
    ['c3a2e2809c', '&#8220;'],
    // " close quote
    ['c3a2e2809d', '&#8221;'],
    // — em dash
    ['c3a2e28094', '&#8212;'],
    // – en dash
    ['c3a2e28093', '&#8211;'],
    // • bullet
    ['c3a2e280a2', '&#8226;'],
    // "¦ ellipsis
    ['c3a2e280a6', '&#8230;'],
];

function hex2bin_safe(string $hex): string
{
    return hex2bin($hex) ?: '';
}

foreach ($files as $file) {
    $c = file_get_contents($file);
    $orig = $c;
    foreach ($pairs as [$hex, $entity]) {
        $bad = hex2bin_safe($hex);
        if ($bad !== '') {
            $c = str_replace($bad, $entity, $c);
        }
    }

    // Catch-all: UTF-8 sequences that decode to U+00F0.. start of emoji mojibake "e..."
    // Pattern in raw bytes: C3 B0 C5 B8 ... ( + Ÿ + rest)
    $c = preg_replace('/\xc3\xb0\xc5\xb8[\x80-\xbf]{1,4}/', '&#127912;', $c);
    // Pattern: C3 A2 E2 80 ... (- + € + ...) punctuation mojibake
    $c = preg_replace('/\xc3\xa2\xe2\x80[\x80-\xbf]{1,3}/', '-', $c);

    if ($c !== $orig) {
        file_put_contents($file, $c);
        echo 'FIXED '.basename($file)."\n";
    } else {
        echo 'ok    '.basename($file)."\n";
    }
}

echo "done\n";
