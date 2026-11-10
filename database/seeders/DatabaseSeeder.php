<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            // MasterDataSeeder::class, akan ditambahkan ke dalam DatabaseSeeder.php pada tahap M3 setelah kelasnya dibuat
            // Jadikan komentar sementara
        ]);
    }
}
