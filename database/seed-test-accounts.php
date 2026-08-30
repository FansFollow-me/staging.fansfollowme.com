if(\App\Models\User::where('username','testfan')->count() == 0) {
    \App\Models\User::create([
        'username' => 'testfan',
        'name' => 'Test Fan',
        'email' => 'testfan@staging.test',
        'password' => bcrypt('TestPass123!'),
        'role' => 'normal',
        'status' => 'active',
        'verified_id' => 'yes',
        'free_subscription' => 'yes'
    ]);
    echo "Created testfan\n";
} else {
    echo "testfan exists\n";
}

if(\App\Models\User::where('username','testcreator')->count() == 0) {
    \App\Models\User::create([
        'username' => 'testcreator',
        'name' => 'Test Creator',
        'email' => 'testcreator@staging.test',
        'password' => bcrypt('TestPass123!'),
        'role' => 'normal',
        'status' => 'active',
        'verified_id' => 'yes',
        'free_subscription' => 'no',
        'price' => 9.99
    ]);
    echo "Created testcreator\n";
} else {
    echo "testcreator exists\n";
}
