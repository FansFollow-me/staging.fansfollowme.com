<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    private const PAGE_LIMIT = 45000;

    public function index(): Response
    {
        $now = now()->toAtomString();
        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
        foreach (['sitemap-pages.xml', 'sitemap-creators.xml', 'sitemap-fans.xml'] as $file) {
            $xml .= '  <sitemap>'."\n";
            $xml .= '    <loc>'.e(url('/'.$file)).'</loc>'."\n";
            $xml .= '    <lastmod>'.$now.'</lastmod>'."\n";
            $xml .= '  </sitemap>'."\n";
        }
        $xml .= '</sitemapindex>';

        return $this->xml($xml);
    }

    public function pages(): Response
    {
        $urls = [
            ['loc' => route('home'), 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => route('page.explore'), 'changefreq' => 'hourly', 'priority' => '0.9'],
            ['loc' => route('page.creators'), 'changefreq' => 'daily', 'priority' => '0.8'],
            ['loc' => route('page.fans'), 'changefreq' => 'weekly', 'priority' => '0.7'],
            ['loc' => route('page.celebrities'), 'changefreq' => 'weekly', 'priority' => '0.7'],
            ['loc' => route('page.casting'), 'changefreq' => 'weekly', 'priority' => '0.6'],
            ['loc' => route('page.business'), 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => route('page.for-creators'), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => route('page.support'), 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => route('page.faq'), 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => route('page.contact'), 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => route('page.blog'), 'changefreq' => 'weekly', 'priority' => '0.5'],
            ['loc' => route('page.privacy'), 'changefreq' => 'yearly', 'priority' => '0.3'],
            ['loc' => route('page.terms'), 'changefreq' => 'yearly', 'priority' => '0.3'],
            ['loc' => route('page.cookies'), 'changefreq' => 'yearly', 'priority' => '0.3'],
            ['loc' => route('page.live-streams'), 'changefreq' => 'daily', 'priority' => '0.7'],
            ['loc' => url('/signup'), 'changefreq' => 'monthly', 'priority' => '0.4'],
        ];

        return $this->xml($this->urlset($urls));
    }

    public function creators(): Response
    {
        $urls = [];
        User::query()
            ->where('role', UserRole::Creator)
            ->where('status', 'active')
            ->orderBy('id')
            ->limit(self::PAGE_LIMIT)
            ->each(function (User $user) use (&$urls) {
                $urls[] = [
                    'loc' => url('/'.$user->username),
                    'lastmod' => optional($user->updated_at)->toAtomString(),
                    'changefreq' => 'daily',
                    'priority' => '0.8',
                ];
            });

        return $this->xml($this->urlset($urls));
    }

    public function fans(): Response
    {
        $urls = [];
        User::query()
            ->where('role', UserRole::Fan)
            ->where('status', 'active')
            ->orderBy('id')
            ->limit(self::PAGE_LIMIT)
            ->each(function (User $user) use (&$urls) {
                $urls[] = [
                    'loc' => url('/'.$user->username),
                    'lastmod' => optional($user->updated_at)->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.4',
                ];
            });

        return $this->xml($this->urlset($urls));
    }

    public function robots(): Response
    {
        $body = implode("\n", [
            'User-agent: *',
            'Allow: /',
            'Disallow: /login',
            'Disallow: /dashboard',
            'Disallow: /settings',
            'Disallow: /panel',
            'Disallow: /password',
            '',
            'Sitemap: '.url('/sitemap.xml'),
            '',
        ]);

        return response($body, 200)->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    private function urlset(array $urls): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
        foreach ($urls as $url) {
            $xml .= '  <url>'."\n";
            $xml .= '    <loc>'.e($url['loc']).'</loc>'."\n";
            if (! empty($url['lastmod'])) {
                $xml .= '    <lastmod>'.$url['lastmod'].'</lastmod>'."\n";
            }
            if (! empty($url['changefreq'])) {
                $xml .= '    <changefreq>'.$url['changefreq'].'</changefreq>'."\n";
            }
            if (! empty($url['priority'])) {
                $xml .= '    <priority>'.$url['priority'].'</priority>'."\n";
            }
            $xml .= '  </url>'."\n";
        }
        $xml .= '</urlset>';

        return $xml;
    }

    private function xml(string $xml): Response
    {
        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
