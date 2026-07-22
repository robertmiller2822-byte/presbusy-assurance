<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')
            ->where('email', 'admin@prestbury.com')
            ->update([
                'password' => Hash::make('Prest@5098')
            ]);
    }

    public function down(): void
    {
        // Revert to old password if needed (optional)
    }
};