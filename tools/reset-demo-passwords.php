<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$users = App\Models\User::all(['id', 'username', 'email', 'role', 'status']);
echo "count=".$users->count().PHP_EOL;
foreach ($users as $u) {
    echo $u->id.' '.$u->username.' '.$u->role->value.' '.$u->status.PHP_EOL;
}

// verify password hash for Admin
$admin = App\Models\User::where('username', 'Admin')->first();
if (! $admin) {
    echo "NO ADMIN\n";
    exit(1);
}
$ok = Illuminate\Support\Facades\Hash::check('TestPass123!', $admin->password);
echo "admin_pass_ok=".($ok ? 'yes' : 'no').PHP_EOL;

// re-set password if needed
if (! $ok) {
    $admin->forceFill(['password' => Illuminate\Support\Facades\Hash::make('TestPass123!'), 'status' => 'active'])->save();
    echo "admin password reset\n";
}

// reset all demo passwords
foreach (['Admin', 'testcreator', 'testfan', 'demofan', 'superfan', 'vikingcoach'] as $name) {
    $u = App\Models\User::where('username', $name)->first();
    if ($u) {
        $u->forceFill([
            'password' => Illuminate\Support\Facades\Hash::make('TestPass123!'),
            'status' => 'active',
        ])->save();
        echo "reset $name\n";
    }
}
