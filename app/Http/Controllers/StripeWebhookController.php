<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WalletTransaction;
use App\Services\StripeService;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function __construct(
        private StripeService $stripe,
        private WalletService $wallets,
    ) {
    }

    public function handle(Request $request): Response
    {
        try {
            $event = $this->stripe->verifyWebhook(
                $request->getContent(),
                (string) $request->header('Stripe-Signature', '')
            );
        } catch (\Throwable $e) {
            Log::warning('stripe.webhook.invalid', ['error' => $e->getMessage()]);

            return response('invalid', 400);
        }

        $type = $event['type'] ?? '';
        $object = $event['data']['object'] ?? [];

        if ($type === 'checkout.session.completed') {
            $this->creditWalletFromCheckout(is_array($object) ? $object : []);
        }

        return response('ok', 200);
    }

    private function creditWalletFromCheckout(array $session): void
    {
        $meta = $session['metadata'] ?? [];
        if (($meta['type'] ?? '') !== 'wallet_topup') {
            return;
        }

        $sessionId = (string) ($session['id'] ?? '');
        $userId = (int) ($meta['user_id'] ?? $session['client_reference_id'] ?? 0);
        $amount = (int) ($session['amount_total'] ?? 0);

        if ($sessionId === '' || $userId < 1 || $amount < 100) {
            return;
        }

        if (($session['payment_status'] ?? '') !== 'paid' && ($session['status'] ?? '') !== 'complete') {
            return;
        }

        $already = WalletTransaction::query()
            ->where('type', 'deposit')
            ->where('meta->stripe_session_id', $sessionId)
            ->exists();

        if ($already) {
            return;
        }

        $user = User::find($userId);
        if (! $user) {
            return;
        }

        $this->wallets->credit($user, $amount, 'deposit', 'stripe_session', 0, [
            'source' => 'stripe_checkout',
            'stripe_session_id' => $sessionId,
        ]);
    }
}
