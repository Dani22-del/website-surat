<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Hash;

class AdditionalUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insertOrIgnore([
    [
                'name' => 'adin',
                'email' => 'adin@gmail.com',
                'password' => Hash::make('adin'),
                'level_user' => 'pegawai',
                'status' => 'Aktif',
                'no_ktp' => '3516030206025674',
                'phone' => '08562452878',
                'alamat' => 'Ds.pare Kec.Pare'
    ],
    // …bisa array banyak user baru…
]);

    }
}
