<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = new Carbon();
        DB::table('users')->insert([
            [
                'name' => '伊藤利典',
                'email' => 'tnitoh@global-software.co.jp',
                'password' => bcrypt('okuwa3358'),
                'created_at' => $date,
                'updated_at' => $date,
                'authority' => 1,
                'registration' => true,
                'note' => null,
            ],
            [
                'name' => '宮島郁夫',
                'email' => 'mah00132@kje.biglobe.ne.jp',
                'password' => bcrypt('pontas'),
                'created_at' => $date,
                'updated_at' => $date,
                'authority' => 1,
                'registration' => true,
                'note' => null,
            ],
        ]);
    }
}
