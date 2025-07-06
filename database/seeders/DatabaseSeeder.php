<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->truncate();
        DB::table('users')->insert([  
            [    
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'level_user' => 'admin_devisi',
                'status' => 'Aktif',
                'no_ktp' => '3516030206000004',
                'phone' => '08560702878',
                'alamat' => 'Ds.Warugunung Kec.Pare'
            ],
            [    
                'name' => 'Agus Santoso',
                'email' => 'kepala@gmail.com',
                'password' => Hash::make('kepalaarsip'),
                'level_user' => 'kepala_arsip',
                'status' => 'Aktif',
                'no_ktp' => '3516030206000098',
                'phone' => '08560702985',
                'alamat' => 'Ds.Batu Kec.Pungging'
            ],
            [    
                'name' => 'Bambang',
                'email' => 'direktur@gmail.com',
                'password' => Hash::make('direktur'),
                'level_user' => 'direktur',
                'status' => 'Aktif',
                'no_ktp' => '3516030206000231',
                'phone' => '08560706453',
                'alamat' => 'Ds.Pondo Kec.Tuban'
            ],
        ]);
    }
}
