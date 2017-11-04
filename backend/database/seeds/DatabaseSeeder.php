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
        /* Users */
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

        /* Posts */
        DB::table('posts')->insert([
            'title' => 'title 1',
            'user_id' => '1',
            'html_content' => 'h',
            'category' => 1,    
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'published_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'view' => 15
        ]);
        DB::table('posts')->insert([
            'title' => 'title 2',
            'user_id' => '1',
            'html_content' => 'hh',
            'category' => 1,
            'created_at' => '2017-11-02',
            'published_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'view' => 20
        ]);
        DB::table('posts')->insert([
            'title' => 'title 3',
            'user_id' => '1',
            'html_content' => 'hhh',
            'category' => 2,
            'created_at' => '2017-11-02',
            'published_at' => '2017-10-30',
            'view' => 25
        ]);
        DB::table('posts')->insert([
            'title' => 'title 4',
            'user_id' => '2',
            'html_content' => 'hhhh',
            'category' => 2,
            'created_at' => '2017-11-01',
            'published_at' => '2017-11-03',
            'view' => 30
        ]);
        DB::table('posts')->insert([
            'title' => 'title 5',
            'user_id' => '2',
            'html_content' => 'hhhhh',
            'category' => 3,
            'published_at' => '2017-11-01',
            'created_at' => '2017-11-02',
            'view' => 35
        ]);
        DB::table('posts')->insert([
            'title' => 'show',
            'user_id' => '2',
            'html_content' => '
                <h4 class="light muted">Hi，小朋友们大家好，还记得我是谁吗？对了！我就是为蓝猫配音的演员，葛平！</h4>
                <img src="//upload.wikimedia.org/wikipedia/zh/c/cf/Ge_Ping_2.JPG" alt="葛平"/>',
            'category' => 99, // 公告
            'published_at' => '2017-10-31',
            'created_at' => '2017-11-02',
            'view' => 99
        ]);
        // 草稿 （无published——at）
        DB::table('posts')->insert([
            'title' => 'title 6',
            'user_id' => '1',
            'html_content' => 'non pub',
            'category' => 1,
            'created_at' => '2017-11-02',
            'view' => 0
        ]);
        DB::table('posts')->insert([
            'title' => 'title 7',
            'user_id' => '1',
            'html_content' => 'non pub',
            'category' => 2,
            'created_at' => '2017-11-01',
            'view' => 0
        ]);
        DB::table('posts')->insert([
            'title' => 'title 8',
            'user_id' => '1',
            'html_content' => 'non pub',
            'category' => 3,
            'created_at' => '2017-10-31',
            'view' => 0
        ]);
        
        /* View Logs */
        DB::table('viewlogs')->insert([
            'ip' => '1.1.1.1',
            'user' => '1',
            'created_at' => '2017-11-01'
        ]);
        DB::table('viewlogs')->insert([
            'ip' => '1.1.1.1',
            'user' => '1',
            'created_at' => '2017-11-02'
        ]);
        DB::table('viewlogs')->insert([
            'ip' => '1.1.1.1',
            'user' => '1',
            'created_at' => '2017-11-02'
        ]);
        DB::table('viewlogs')->insert([
            'ip' => '1.1.1.1',
            'user' => '1',
            'created_at' => '2017-11-03'
        ]);
        DB::table('viewlogs')->insert([
            'ip' => '1.1.1.1',
            'user' => '1',
            'created_at' => '2017-11-03'
        ]);
        DB::table('viewlogs')->insert([
            'ip' => '1.1.1.1',
            'user' => '1',
            'created_at' => '2017-11-03'
        ]);
        DB::table('viewlogs')->insert([
            'ip' => '1.1.1.1',
            'user' => '1',
            'created_at' => '2017-11-04'
        ]);
        DB::table('viewlogs')->insert([
            'ip' => '1.1.1.1',
            'user' => '1',
            'created_at' => '2017-11-04'
        ]);
        DB::table('viewlogs')->insert([
            'ip' => '1.1.1.1',
            'user' => '1',
            'created_at' => '2017-11-05'
        ]);
        DB::table('viewlogs')->insert([
            'ip' => '1.1.1.1',
            'user' => '1',
            'created_at' => '2017-10-31'
        ]);
        DB::table('viewlogs')->insert([
            'ip' => '1.1.1.1',
            'user' => '1',
            'created_at' => '2017-10-31'
        ]);
        DB::table('viewlogs')->insert([
            'ip' => '1.1.1.1',
            'user' => '1',
            'created_at' => '2017-10-31'
        ]);
        DB::table('viewlogs')->insert([
            'ip' => '1.1.1.1',
            'user' => '1',
            'created_at' => '2017-10-31'
        ]);
        DB::table('viewlogs')->insert([
            'ip' => '1.1.1.1',
            'user' => '1',
            'created_at' => '2017-10-30'
        ]);
        DB::table('viewlogs')->insert([
            'ip' => '1.1.1.1',
            'user' => '1',
            'created_at' => '2017-10-29'
        ]);
        DB::table('viewlogs')->insert([
            'ip' => '1.1.1.1',
            'user' => '1',
            'created_at' => '2017-10-29'
        ]);
        DB::table('viewlogs')->insert([
            'ip' => '1.1.1.1',
            'user' => '1',
            'created_at' => '2017-10-28'
        ]);
        DB::table('viewlogs')->insert([
            'ip' => '1.1.1.18',
            'user' => '1',
            'created_at' => '2017-10-28'
        ]);
        DB::table('viewlogs')->insert([
            'ip' => '1.1.1.17',
            'user' => '1',
            'created_at' => '2017-10-28'
        ]);
        DB::table('viewlogs')->insert([
            'ip' => '1.1.1.16',
            'user' => '1',
            'created_at' => '2017-10-27'
        ]);
        DB::table('viewlogs')->insert([
            'ip' => '1.1.1.15',
            'user' => '1',
            'created_at' => '2017-10-27'
        ]);
        DB::table('viewlogs')->insert([
            'ip' => '1.1.1.14',
            'user' => '1',
            'created_at' => '2017-10-26'
        ]);
        DB::table('viewlogs')->insert([
            'ip' => '1.1.1.13',
            'user' => '1',
            'created_at' => '2017-10-25'
        ]);
        DB::table('viewlogs')->insert([
            'ip' => '1.1.1.12',
            'user' => '1',
            'created_at' => '2017-10-25'
        ]);
    }
}
