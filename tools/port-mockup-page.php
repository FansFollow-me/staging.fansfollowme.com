<?php

/**
 * Port a signed-off fansfollowme.com page into a Laravel Blade view.
 *
 * Usage:
 *   php tools/port-mockup-page.php <live.html> <out.blade.php> <page-key>
 *
 * page-key: login|signup|explore|for-creators|generic
 */

$livePath = $argv[1] ?? null;
$outPath = $argv[2] ?? null;
$pageKey = $argv[3] ?? 'generic';

if (! $livePath || ! $outPath) {
    fwrite(STDERR, "Usage: php tools/port-mockup-page.php <live.html> <out.blade.php> [page-key]\n");
    exit(1);
}

$html = file_get_contents($livePath);
if ($html === false || strlen($html) < 5000) {
    fwrite(STDERR, "Cannot read {$livePath}\n");
    exit(1);
}

// --- shared rewrites -------------------------------------------------------

// CSS
$html = str_replace('href="assets/css/style.css"', 'href="{{ asset(\'css/style.css\') }}"', $html);
$html = str_replace('href="assets/css/responsive.css"', 'href="{{ asset(\'css/responsive.css\') }}"', $html);
$html = str_replace('href="manifest.json"', 'href="{{ asset(\'manifest.json\') }}"', $html);

// Hero / section photos
$html = str_replace(
    "url('https://fansfollow.me/ffmherobackground.jpg')",
    'url("{{ asset(\'img/ffmherobackground.jpg\') }}")',
    $html
);

// Pretty + .html internal links
$linkMap = [
    '/' => "{{ route('home') }}",
    '/index.html' => "{{ route('home') }}",
    'index.html' => "{{ route('home') }}",
    '/explore' => "{{ route('page.explore') }}",
    '/explore.html' => "{{ route('page.explore') }}",
    'explore.html' => "{{ route('page.explore') }}",
    '/for-creators' => "{{ route('page.for-creators') }}",
    '/for-creators.html' => "{{ route('page.for-creators') }}",
    'for-creators.html' => "{{ route('page.for-creators') }}",
    '/fans' => "{{ route('page.fans') }}",
    '/fans.html' => "{{ route('page.fans') }}",
    'fans.html' => "{{ route('page.fans') }}",
    '/celebrities' => "{{ route('page.celebrities') }}",
    '/celebrities.html' => "{{ route('page.celebrities') }}",
    'celebrities.html' => "{{ route('page.celebrities') }}",
    '/casting' => "{{ route('page.casting') }}",
    '/casting.html' => "{{ route('page.casting') }}",
    'casting.html' => "{{ route('page.casting') }}",
    '/business' => "{{ route('page.business') }}",
    '/business.html' => "{{ route('page.business') }}",
    'business.html' => "{{ route('page.business') }}",
    '/live-streams' => "{{ route('page.live-streams') }}",
    '/live-streams.html' => "{{ route('page.live-streams') }}",
    'live-streams.html' => "{{ route('page.live-streams') }}",
    '/contact' => "{{ route('page.contact') }}",
    '/contact.html' => "{{ route('page.contact') }}",
    'contact.html' => "{{ route('page.contact') }}",
    '/support' => "{{ route('page.contact') }}",
    '/support.html' => "{{ route('page.contact') }}",
    '/faq' => "{{ route('page.faq') }}",
    '/faq.html' => "{{ route('page.faq') }}",
    'faq.html' => "{{ route('page.faq') }}",
    '/privacy' => "{{ route('page.privacy') }}",
    '/privacy.html' => "{{ route('page.privacy') }}",
    'privacy.html' => "{{ route('page.privacy') }}",
    '/terms' => "{{ route('page.terms') }}",
    '/terms.html' => "{{ route('page.terms') }}",
    'terms.html' => "{{ route('page.terms') }}",
    '/cookies' => "{{ route('page.cookies') }}",
    '/cookies.html' => "{{ route('page.cookies') }}",
    'cookies.html' => "{{ route('page.cookies') }}",
    '/blog' => "{{ route('page.blog') }}",
    '/blog.html' => "{{ route('page.blog') }}",
    '/creators' => "{{ route('page.creators') }}",
    '/creators.html' => "{{ route('page.creators') }}",
    '/signup' => "{{ route('register') }}",
    '/signup.html' => "{{ route('register') }}",
    'signup.html' => "{{ route('register') }}",
    '/login' => "{{ route('login') }}",
    '/login.html' => "{{ route('login') }}",
    'login.html' => "{{ route('login') }}",
    '/password-reset' => "{{ route('login') }}",
    '/password-reset.html' => "{{ route('login') }}",
    'password-reset.html' => "{{ route('login') }}",
    '/dashboard' => "{{ route('dashboard') }}",
    '/dashboard.html' => "{{ route('dashboard') }}",
];

// Longest keys first so /login.html wins over /login
uksort($linkMap, fn ($a, $b) => strlen($b) <=> strlen($a));

foreach ($linkMap as $from => $to) {
    $html = str_replace('href="'.$from.'"', 'href="'.$to.'"', $html);
    $html = str_replace("href='".$from."'", "href='".$to."'", $html);
}

// Remove Bolt badge
$html = preg_replace('/\s*<script async src="https:\/\/bolt\.new\/badge\.js[^"]*"><\/script>/s', '', $html);

// CSRF meta
if (strpos($html, 'name="csrf-token"') === false) {
    $html = str_replace('<head>', "<head>\n  <meta name=\"csrf-token\" content=\"{{ csrf_token() }}\">", $html);
}

// Auth-aware desktop actions
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

// Mobile CTA auth-aware
$html = preg_replace(
    '/<a href="\{\{ route\(\'login\'\) \}\}" style="margin-top:1rem;color:#94a3b8;font-weight:600">Login<\/a>\s*<a href="\{\{ route\(\'register\'\) \}\}" class="mobile-cta-btn">Get Started<\/a>/s',
    "@guest\n          <a href=\"{{ route('login') }}\" style=\"margin-top:1rem;color:#94a3b8;font-weight:600\">Login</a>\n              <a href=\"{{ route('register') }}\" class=\"mobile-cta-btn\">Get Started</a>\n          @else\n              <a href=\"{{ route('dashboard') }}\" class=\"mobile-cta-btn\">Dashboard</a>\n          @endguest",
    $html,
    1
);

// --- page-specific: real auth forms ----------------------------------------

if ($pageKey === 'login') {
    // Replace demo form with real Laravel POST (keep markup/classes)
    $html = preg_replace(
        '/<form method="POST" action="#" id="authLoginForm"[^>]*>/s',
        '<form method="POST" action="{{ route(\'login.attempt\') }}" id="authLoginForm" enctype="multipart/form-data" class="auth-form">',
        $html,
        1
    );
    // Drop onsubmit demo handler remnants if any leftover
    $html = str_replace('onsubmit="event.preventDefault(); handleDemoLogin();"', '', $html);

    // Insert @csrf after form open (after first form tag of authLoginForm)
    $html = preg_replace(
        '/(<form method="POST" action="\{\{ route\(\'login\.attempt\'\) \}\}"[^>]*>)/s',
        "$1\n                  @csrf\n                  @if (\\$errors->any())\n                    <div id=\"errorLogin\" class=\"alert alert-danger py-2\" style=\"border-radius:12px;\">\n                      <ul id=\"showErrorsLogin\" class=\"mb-0 small\">\n                        @foreach (\\$errors->all() as \\$error)\n                          <li>{{ \\$error }}</li>\n                        @endforeach\n                      </ul>\n                    </div>\n                  @else\n                    <div id=\"errorLogin\" class=\"alert alert-danger py-2 d-none\" style=\"border-radius:12px;\"><ul id=\"showErrorsLogin\" class=\"mb-0 small\"></ul></div>\n                  @endif",
        $html,
        1
    );

    // Remove handleDemoLogin script block
    $html = preg_replace('/<script>\s*function handleDemoLogin\(\)[\s\S]*?<\/script>/s', '', $html);
}

if ($pageKey === 'signup') {
    $html = preg_replace(
        '/<form method="POST" action="#" id="authSignupForm"[^>]*>/s',
        '<form method="POST" action="{{ route(\'register.attempt\') }}" id="authSignupForm" enctype="multipart/form-data" class="auth-form">',
        $html,
        1
    );
    // Broader: any signup form with action="#"
    if (strpos($html, "route('register.attempt')") === false) {
        $html = preg_replace(
            '/<form method="POST" action="#"([^>]*)>/s',
            '<form method="POST" action="{{ route(\'register.attempt\') }}"$1>',
            $html,
            1
        );
    }
    $html = preg_replace(
        '/(<form method="POST" action="\{\{ route\(\'register\.attempt\'\) \}\}"[^>]*>)/s',
        "$1\n                  @csrf",
        $html,
        1
    );
    $html = preg_replace('/<script>\s*function handleDemoSignup\(\)[\s\S]*?<\/script>/s', '', $html);
    $html = preg_replace('/<script>\s*function handleDemoLogin\(\)[\s\S]*?<\/script>/s', '', $html);
}

// Escape Blade CSS at-rules
foreach (['@media', '@supports', '@font-face', '@charset', '@keyframes', '@-webkit-keyframes'] as $rule) {
    $html = str_replace($rule, '@'.$rule, $html);
}

$banner = "{{-- PIXEL-EXACT port from signed-off https://fansfollowme.com ({$pageKey})\n     Do NOT restyle. Auth forms/routes only. --}}\n";

if (! is_dir(dirname($outPath))) {
    mkdir(dirname($outPath), 0777, true);
}
file_put_contents($outPath, $banner.$html);
echo "Wrote {$outPath} (".filesize($outPath)." bytes) key={$pageKey}\n";
