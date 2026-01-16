<?php

use App\Models\User;

// Tạo user test
$user = User::create([
    'name' => 'Test User',
    'email' => 'user@test.com',
    'password' => bcrypt('user123'),
    'email_verified_at' => now()
]);

echo "User created! Email: user@test.com, Password: user123\n";