<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Model\Position;
use App\Model\Department;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	'name' => '小何',
        	'email' => 'xiaohe@test.com',
        	'password' => bcrypt('he'),
        	'department' => Department::ZHUXITUAN,
        	'position' => Position::ZHUXI,
        	'school' => 'ESIGELEC',
        	'phone_number' => '06 05 04 03 02',
        	'isWorking' => True,
        	'isAvaible' => True,
        	'birthday' => date('1993-01-01'),
        	'arrive_date' => date('2012-01-01'),
        	'dimission_date' => date('2018-01-01'),
        	'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
        	'name' => '小宋',
        	'email' => 'xiaosong@test.com',
        	'password' => bcrypt('song'),
        	'department' => Department::ZHUXITUAN,
        	'position' => Position::FUZHUXI,
        	'school' => 'ESIGELEC',
        	'phone_number' => '06 05 04 03 01',
        	'isWorking' => True,
        	'isAvaible' => True,
        	'birthday' => date('1993-01-02'),
        	'arrive_date' => date('2012-01-02'),
        	'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
