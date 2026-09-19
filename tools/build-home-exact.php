<?php

/**
 * Build pixel-exact homepage Blade from live signed-off fansfollowme.com HTML.
 * Only change: internal routes + auth-aware actions. No restyling.
 *
 * Run: php tools/build-home-exact.php
 */

$livePath = $argv[1] ?? __DIR__.'/../../work/live-fansfollowme.html';
$outPath = $argv[2] ?? __DIR__.'/../resources/views/marketing/home-exact.blade.php';

$html = file_get_contents($livePath);
if ($html === false || strlen($html) < 10000) {
    fwrite(STDERR, "Failed to read live HTML: $livePath\n");
    exit(1);
}

// 1) CSS asset paths (relative -> Laravel)
$html = str_replace('href="assets/css/style.css"', 'href="{{ asset(\'css/style.css\') }}"', $html);
$html = str_replace('href="assets/css/responsive.css"', 'href="{{ asset(\'css/responsive.css\') }}"', $html);
$html = str_replace('href="manifest.json"', 'href="{{ asset(\'manifest.json\') }}"', $html);

// 2) Hero background -> local asset (same file)
$html = str_replace(
    "url('https://fansfollow.me/ffmherobackground.jpg')",
    'url("{{ asset(\'img/ffmherobackground.jpg\') }}")',
    $html
);

// 3) Internal page hrefs -> named routes (preserve quote style where possible)
$map = [
    'index.html' => "{{ route('home') }}",
    'explore.html' => "{{ route('page.explore') }}",
    'for-creators.html' => "{{ route('page.for-creators') }}",
    'fans.html' => "{{ route('page.fans') }}",
    'celebrities.html' => "{{ route('page.celebrities') }}",
    'casting.html' => "{{ route('page.casting') }}",
    'business.html' => "{{ route('page.business') }}",
    'live-streams.html' => "{{ route('page.live-streams') }}",
    'contact.html' => "{{ route('page.contact') }}",
    'signup.html' => "{{ route('register') }}",
    'login.html' => "{{ route('login') }}",
    'privacy.html' => "{{ route('page.privacy') }}",
    'terms.html' => "{{ route('page.terms') }}",
    'cookies.html' => "{{ route('page.cookies') }}",
    'faq.html' => "{{ route('page.faq') }}",
];

foreach ($map as $from => $to) {
    $html = str_replace('href="'.$from.'"', 'href="'.$to.'"', $html);
    $html = str_replace("href='".$from."'", "href='".$to."'", $html);
}

// 4) Remove Bolt badge (not product)
$html = preg_replace('/\s*<script async src="https:\/\/bolt\.new\/badge\.js[^"]*"><\/script>/s', '', $html);

// 5) CSRF meta for logout form
$html = str_replace('<head>', "<head>\n  <meta name=\"csrf-token\" content=\"{{ csrf_token() }}\">", $html, $count);
if ($count === 0) {
    // already present or different head
}

// 6) Desktop actions block -> auth-aware (same visual buttons)
$actionsPattern = '/(<div class="public-shell-actions">)(.*?)(<\/div>\s*<button class="public-shell-hamburger")/s';
$newActions = <<<'BLADE'
<div class="public-shell-actions">
                                @guest
                                <a class="btn btn-primary public-shell-button" style="background: var(--cta-gradient); background-image: var(--cta-gradient); border-color: transparent; box-shadow: 0 14px 28px rgba(249, 115, 22, .24);" href="{{ route('register') }}">Get Started</a>
                    <a class="btn btn-outline-primary public-shell-button" href="{{ route('login') }}">Login</a>
                                @else
                                @if (auth()->user()->isCreator() || auth()->user()->isAdmin())
                                <a class="btn btn-outline-primary public-shell-button" href="{{ route('creator.dashboard') }}">Studio</a>
                                @endif
                                @if (auth()->user()->isAdmin())
                                <a class="btn btn-outline-primary public-shell-button" href="{{ route('admin.dashboard') }}">Admin</a>
                                @endif
                                <a class="btn btn-primary public-shell-button" style="background: var(--cta-gradient); background-image: var(--cta-gradient); border-color: transparent; box-shadow: 0 14px 28px rgba(249, 115, 22, .24);" href="{{ route('dashboard') }}">Dashboard</a>
                                <form method="POST" action="{{ route('logout') }}" class="m-0 d-inline">@csrf<button type="submit" class="btn btn-outline-primary public-shell-button">Logout</button></form>
                                @endguest
              </div>
              <button class="public-shell-hamburger
BLADE;
$html = preg_replace($actionsPattern, $newActions, $html, 1);

// 7) Mobile menu login/signup -> auth-aware
$html = preg_replace(
    '/<a href="\{\{ route\(\'login\'\) \}\}" style="margin-top:1rem;color:#94a3b8;font-weight:600">Login<\/a>\s*<a href="\{\{ route\(\'register\'\) \}\}" class="mobile-cta-btn">Get Started<\/a>/s',
    "@guest\n          <a href=\"{{ route('login') }}\" style=\"margin-top:1rem;color:#94a3b8;font-weight:600\">Login</a>\n              <a href=\"{{ route('register') }}\" class=\"mobile-cta-btn\">Get Started</a>\n          @else\n              <a href=\"{{ route('dashboard') }}\" class=\"mobile-cta-btn\">Dashboard</a>\n          @endguest",
    $html,
    1
);

// 8) Escape Blade-conflicting CSS at-rules
foreach (['@media', '@supports', '@font-face', '@charset', '@keyframes', '@-webkit-keyframes'] as $rule) {
    $html = str_replace($rule, '@'.$rule, $html);
}

$banner = <<<'BLADE'
{{-- PIXEL-EXACT homepage from signed-off https://fansfollowme.com
     Do NOT restyle. Only auth-aware nav + Laravel routes differ from static mockup. --}}
BLADE;

file_put_contents($outPath, $banner."\n".$html);
echo "Wrote {$outPath} (".filesize($outPath)." bytes) from {$livePath}\n";
