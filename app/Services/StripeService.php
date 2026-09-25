<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class StripeService
{
    public function enabled(): bool
    {
        return (bool) config('services.stripe.secret');
    }

    public function createWalletCheckout(int $userId, int $amountCents, string $successUrl, string $cancelUrl): string
    {
        $session = $this->post('checkout/sessions', [
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'client_reference_id' => (string) $userId,
            'metadata[user_id]' => (string) $userId,
            'metadata[type]' => 'wallet_topup',
            'line_items[0][quantity]' => '1',
            'line_items[0][price_data][currency]' => 'usd',
            'line_items[0][price_data][unit_amount]' => (string) $amountCents,
            'line_items[0][price_data][product_data][name]' => 'FansFollow.me wallet',
        ]);

        $url = $session['url'] ?? null;
        if (! is_string($url) || $url === '') {
            throw new \RuntimeException('Stripe Checkout did not return a URL');
        }

        return $url;
    }

    public function verifyWebhook(string $payload, string $signatureHeader): array
    {
        $secret = (string) config('services.stripe.webhook_secret');
        if ($secret === '') {
            throw new \RuntimeException('Stripe webhook secret missing');
        }

        $parts = [];
        foreach (explode(',', $signatureHeader) as $piece) {
            [$k, $v] = array_pad(explode('=', trim($piece), 2), 2, '');
            $parts[$k][] = $v;
        }

        $timestamp = $parts['t'][0] ?? '';
        $signatures = $parts['v1'] ?? [];
        if ($timestamp === '' || $signatures === []) {
            throw new \RuntimeException('Invalid Stripe-Signature header');
        }

        if (abs(time() - (int) $timestamp) > 300) {
            throw new \RuntimeException('Stripe webhook timestamp too old');
        }

        $expected = hash_hmac('sha256', $timestamp.'.'.$payload, $secret);
        $ok = false;
        foreach ($signatures as $sig) {
            if (hash_equals($expected, $sig)) {
                $ok = true;
                break;
            }
        }
        if (! $ok) {
            throw new \RuntimeException('Stripe webhook signature mismatch');
        }

        $event = json_decode($payload, true);
        if (! is_array($event)) {
            throw new \RuntimeException('Stripe webhook payload is not JSON');
        }

        return $event;
    }

    private function post(string $path, array $form): array
    {
        $secret = (string) config('services.stripe.secret');
        if ($secret === '') {
            throw new \RuntimeException('Stripe is not configured');
        }

        $response = Http::withBasicAuth($secret, '')
            ->asForm()
            ->timeout(20)
            ->post('https://api.stripe.com/v1/'.$path, $form);

        if ($response->failed()) {
            $msg = $response->json('error.message') ?: 'Stripe request failed';
            throw new \RuntimeException($msg);
        }

        return $response->json() ?? [];
    }
}
