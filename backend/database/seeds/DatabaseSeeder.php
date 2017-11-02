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
        DB::table('users')->insert([
            'name' => '开发',
            'email' => 'kaifa@test.com',
            'password' => bcrypt('kaifa'),
            'department' => Department::XIANGMUKAIFABU,
            'position' => Position::CHENGYUAN,
            'school' => 'ESIGELEC',
            'phone_number' => '06 05 04 03 01',
            'isWorking' => True,
            'isAvaible' => True,
            'birthday' => date('1993-01-02'),
            'arrive_date' => date('2012-01-02'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('posts')->insert([
            'title' => 'title 1',
            'user_id' => '1',
            'html_content' => 'h',
            'category' => 1,    
            'published_at' => '2017-01-02',
            'view' => 15
        ]);
        DB::table('posts')->insert([
            'title' => 'title 2',
            'user_id' => '1',
            'html_content' => 'hh',
            'category' => 1,
            'published_at' => '2017-01-03',
            'view' => 20
        ]);
        DB::table('posts')->insert([
            'title' => 'title 3',
            'user_id' => '1',
            'html_content' => 'hhh',
            'category' => 2,
            'published_at' => '2017-01-04',
            'view' => 25
        ]);
        DB::table('posts')->insert([
            'title' => 'title 4',
            'user_id' => '2',
            'html_content' => 'hhhh',
            'category' => 2,
            'published_at' => '2017-01-05',
            'view' => 30
        ]);
        DB::table('posts')->insert([
            'title' => 'title 5',
            'user_id' => '2',
            'html_content' => 'hhhhh',
            'category' => 3,
            'published_at' => '2017-01-01',
            'view' => 35
        ]);
        DB::table('posts')->insert([
            'title' => 'show',
            'user_id' => '2',
            'html_content' => '
                <h4 class="light muted">Hi，小朋友们大家好，还记得我是谁吗？对了！我就是为蓝猫配音的演员，葛平！</h4>
                <img src="//upload.wikimedia.org/wikipedia/zh/c/cf/Ge_Ping_2.JPG" alt="葛平"/>',
            'category' => 99, // 公告
            'published_at' => '2017-01-01',
            'view' => 99
        ]);
        // 草稿 （无published——at）
        DB::table('posts')->insert([
            'title' => 'title 6',
            'user_id' => '1',
            'html_content' => 'non pub',
            'category' => 1,
            'view' => 0
        ]);
        DB::table('posts')->insert([
            'title' => 'title 7',
            'user_id' => '1',
            'html_content' => 'non pub',
            'category' => 2,
            'view' => 0
        ]);
        DB::table('posts')->insert([
            'title' => 'title 8',
            'user_id' => '1',
            'html_content' => 'non pub',
            'category' => 3,
            'view' => 0
        ]);
    }
}
