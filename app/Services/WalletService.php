<?php

namespace App\Services;

use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;

class WalletService
{
    /**
     * Credit or debit a wallet atomically. Amount in minor units (positive credit, negative debit).
     */
    public function adjust(User $user, int $amount, string $type, ?string $refType = null, ?int $refId = null, array $meta = []): WalletTransaction
    {
        return DB::transaction(function () use ($user, $amount, $type, $refType, $refId, $meta) {
            $wallet = Wallet::firstOrCreate(
                ['user_id' => $user->id],
                ['balance' => 0, 'currency' => 'USD']
            );

            $wallet = Wallet::whereKey($wallet->id)->lockForUpdate()->firstOrFail();
            $balanceAfter = $wallet->balance + $amount;

            if ($balanceAfter < 0) {
                throw new \RuntimeException('Insufficient wallet balance');
            }

            $wallet->balance = $balanceAfter;
            $wallet->save();

            return WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => $type,
                'amount' => $amount,
                'balance_after' => $balanceAfter,
                'currency' => $wallet->currency,
                'reference_type' => $refType,
                'reference_id' => $refId,
                'meta' => $meta ?: null,
            ]);
        });
    }

    public function credit(User $user, int $amount, string $type, ?string $refType = null, ?int $refId = null, array $meta = []): WalletTransaction
    {
        return $this->adjust($user, abs($amount), $type, $refType, $refId, $meta);
    }

    public function debit(User $user, int $amount, string $type, ?string $refType = null, ?int $refId = null, array $meta = []): WalletTransaction
    {
        return $this->adjust($user, -abs($amount), $type, $refType, $refId, $meta);
    }
}
