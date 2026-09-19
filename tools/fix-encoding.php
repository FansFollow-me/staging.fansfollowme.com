<?php

/**
 * Fix UTF-8 mojibake in ported marketing Blade views.
 * php tools/fix-encoding.php
 */

$dir = __DIR__.'/../resources/views/marketing';
$files = glob($dir.'/*-exact.blade.php');

// Map of broken byte sequences (as they appear when UTF-8 emoji was mis-decoded)
// and the correct replacements (Unicode codepoints as UTF-8).
$map = [
    // C1 + clapperboard U+1F3AC
    "\xC3\xB0\xC5\xB8\xC5\xBD\xC2\xAC" => "\xF0\x9F\x8E\xAC",
    "\xC3\xB0\xE2\x80\x9C\xC5\xB8\xC5\xBD\xC2\xAC" => "\xF0\x9F\x8E\xAC",
    // visible mojibake "DYŸ..." variants from mis-decode
    "DY\xC5\xB8\xC2\xAC" => "\xF0\x9F\x8E\xAC",
    "\xC3\x90\xC5\xB8\xC5\xBD\xC2\xAC" => "\xF0\x9F\x8E\xAC",
    // red circle, briefcase, speech, person
    "\xC3\xB0\xC5\xB8\xE2\x80\x9D\xC2\xAC" => "\xF0\x9F\x94\xB4",
    "\xC3\xB0\xC5\xB8\xE2\x80\x9E\xC2\xAC" => "\xF0\x9F\x92\xBC",
    "\xC3\xB0\xC5\xB8\xE2\x80\x9C\xC2\xAC" => "\xF0\x9F\x92\xAC",
    // down triangle U+25BE
    "\xC3\xA2\xE2\x82\xAC\xC2\x9C" => "\xE2\x96\xBE",
    "\xC3\xA2\xE2\x80\x9C\xC2\xBE" => "\xE2\x96\xBE",
    // curly apostrophe / quotes / emdash
    "\xC3\xA2\xE2\x82\xAC\xE2\x84\xA2" => "'",
    "\xC3\xA2\xE2\x82\xAC\xC5\x93" => '"',
    "\xC3\xA2\xE2\x82\xAC" => "\xE2\x80\x94",
];

// Also do character-level replace for common display strings
$strMap = [
    'ðŸŽ¬' => '🎬',
    'ðŸ”´' => '🔴',
    'ðŸ’¼' => '💼',
    'ðŸ’¬' => '💬',
    'ðŸ‘¤' => '👤',
    'â†¾' => '▾',
    'â–¾' => '▾',
    'â€™' => "'",
    'â€œ' => '"',
    'â€' => '—',
    'DYŸ¬' => '🎬',
];

foreach ($files as $file) {
    $raw = file_get_contents($file);
    $orig = $raw;

    foreach ($map as $bad => $good) {
        $raw = str_replace($bad, $good, $raw);
    }
    foreach ($strMap as $bad => $good) {
        $raw = str_replace($bad, $good, $raw);
    }

    // Normalize "More" summary arrow if present as literal UTF-8 trash
    $raw = preg_replace('/More\s*Â?â[^\s<]{0,6}/u', 'More ▾', $raw);
    $raw = preg_replace('/summary>More[^<]*/u', 'summary>More', $raw);

    if ($raw !== $orig) {
        file_put_contents($file, $raw);
        echo "FIXED ".basename($file)."\n";
    } else {
        echo "ok    ".basename($file)."\n";
    }
}

// Verify casting badge
$casting = file_get_contents($dir.'/casting-exact.blade.php');
if (preg_match('/casting-badge[^>]*>([^<]+)</', $casting, $m)) {
    echo "casting-badge text: ".$m[1]."\n";
    echo "codepoints: ";
    foreach (mb_str_split(trim($m[1])) as $ch) {
        echo sprintf('U+%04X ', mb_ord($ch));
    }
    echo "\n";
}
