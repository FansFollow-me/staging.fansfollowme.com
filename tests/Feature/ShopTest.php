<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShopTest extends TestCase
{
    use RefreshDatabase;

    private function creatorWithWallet(string $name = null): User
    {
        $creator = User::factory()->create([
            'role' => UserRole::Creator,
            'username' => $name ?: 'shopcoach'.uniqid(),
        ]);
        $creator->profile()->create(['display_name' => 'Coach']);
        $creator->wallet()->create(['balance' => 0, 'currency' => 'USD']);

        return $creator;
    }

    private function fanWithBalance(int $cents): User
    {
        $fan = User::factory()->create([
            'role' => UserRole::Fan,
            'username' => 'shopfan'.uniqid(),
        ]);
        $fan->profile()->create(['display_name' => 'Fan']);
        $fan->wallet()->create(['balance' => $cents, 'currency' => 'USD']);

        return $fan;
    }

    public function test_creator_can_publish_product(): void
    {
        $creator = $this->creatorWithWallet();

        $this->actingAs($creator)->post('/add/product', [
            'title' => '8-Week Fight Camp',
            'description' => 'PDF program',
            'price' => 29.99,
        ])->assertRedirect('/my/products');

        $this->assertDatabaseHas('products', [
            'creator_id' => $creator->id,
            'title' => '8-Week Fight Camp',
            'price' => 29.99,
            'is_active' => true,
        ]);
    }

    public function test_fan_can_buy_digital_product_with_wallet(): void
    {
        $creator = $this->creatorWithWallet();
        $fan = $this->fanWithBalance(5000);

        $product = Product::create([
            'creator_id' => $creator->id,
            'title' => 'Meal Plan',
            'price' => 19.99,
            'currency' => 'USD',
            'type' => 'digital',
            'is_active' => true,
        ]);

        $this->actingAs($fan)->post('/shop/products/'.$product->id.'/buy')
            ->assertRedirect();

        $this->assertSame(5000 - 1999, $fan->fresh()->wallet->balance);
        $this->assertSame(1999, $creator->fresh()->wallet->balance);
        $this->assertDatabaseHas('sales', [
            'product_id' => $product->id,
            'buyer_id' => $fan->id,
            'status' => 'completed',
        ]);
    }

    public function test_insufficient_funds_blocks_purchase(): void
    {
        $creator = $this->creatorWithWallet();
        $fan = $this->fanWithBalance(100);

        $product = Product::create([
            'creator_id' => $creator->id,
            'title' => 'Expensive',
            'price' => 99.99,
            'type' => 'digital',
            'is_active' => true,
        ]);

        $this->actingAs($fan)->post('/shop/products/'.$product->id.'/buy');

        $this->assertSame(100, $fan->fresh()->wallet->balance);
        $this->assertDatabaseMissing('sales', [
            'product_id' => $product->id,
            'buyer_id' => $fan->id,
        ]);
    }

    public function test_cannot_buy_own_product(): void
    {
        $creator = $this->creatorWithWallet();
        $product = Product::create([
            'creator_id' => $creator->id,
            'title' => 'Mine',
            'price' => 5,
            'type' => 'digital',
            'is_active' => true,
        ]);

        $this->actingAs($creator)->post('/shop/products/'.$product->id.'/buy');
        $this->assertDatabaseMissing('sales', ['product_id' => $product->id]);
    }

    public function test_shop_index_is_public(): void
    {
        $this->get('/shop')->assertOk();
    }
}
