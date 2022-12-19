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
        //DB::table('users')->insert([
        //[
        //'name' => 'itoテスト3',
        //'email' => 'test24@test.com',
        //'password' => bcrypt('okuwa3358'),
        //'created_at' => $date,
        //'updated_at' => $date,
        //],
        //]);
        //DB::table('users')->insert([['name' =>'山田太郎','email' =>'yamada-taro@kje.biglobe.ne.jp','password' => bcrypt('okuwa3358'),'created_at' => $date,'updated_at' => $date,],]);
        //DB::table('users')->insert([['name' =>'山田二郎','email' =>'yamada-jiro@kje.biglobe.ne.jp','password' => bcrypt('okuwa3358'),'created_at' => $date,'updated_at' => $date,],]);
        //DB::table('users')->insert([['name' =>'山田山郎','email' =>'yamada-sabu@kje.biglobe.ne.jp','password' => bcrypt('okuwa33583'),'note' => 'okuwa33583','created_at' => $date,'updated_at' => $date,],]);
        //DB::table('users')->insert([['name' =>'山田氏郎','email' =>'yamada-shiro@kje.biglobe.ne.jp','password' => bcrypt('okuwa33584'),'note' => 'okuwa33584','created_at' => $date,'updated_at' => $date,],]);
    }
}
