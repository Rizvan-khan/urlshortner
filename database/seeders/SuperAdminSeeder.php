<?php

namespace Database\Seeders;

use App\Enums\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'superadmin@rizzu.com';

        $exists = DB::select('select id from users where email = ?', [$email]);

        if (! empty($exists)) {
            return;
        }

        DB::insert(
            'insert into users (name, email, password, role, company_id, created_at, updated_at)
             values (?, ?, ?, ?, ?, ?, ?)',
            ['Super Admin', $email, Hash::make('password'), Role::SuperAdmin->value, null, now(), now(),
            ]
        );
    }
}