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
            'title' => 'title 4 loooooooooooooooooooooooooooooo oooooooooooooooooooooooooooooooooo oooooooooooooooooooooooooooooooooooooooooooooo ooooooooooooooooooooooooooooooooooong title',
            'user_id' => '2',
            'html_content' => 'hhhh',
            'category' => 2,
            'created_at' => '2017-11-01',
            'published_at' => '2017-11-03',
            'view' => 30
        ]);
        DB::table('posts')->insert([
            'title' => 'title 很长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长5',
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



        // works
        DB::table('works')->insert([
            'title_work' => '秘书',
            'company_work' => '秘书协会',
            'city_work' => 'rouen',
            'salary_work' => 1500,
            'created_at' => '2017-11-02',
            'html_work' => '<h2>here is the job content.</h2>'
        ]);
        DB::table('works')->insert([
            'title_work' => '花生',
            'company_work' => '花生油协会',
            'city_work' => 'rouen',
            'salary_work' => 1000,
            'html_work' => '<h2>我是花生</h2>'
        ]);


        // writing
        DB::table('writings')->insert([
            'title_writing' => '静夜思',
            'user_writing' => '李白',
            'created_at' => '2017-11-23',
            'introduction_writing' => '思念家人的诗',
            'image_writing' => '../../images/帖子/writings/静夜思-李白.jpg',
            'html_writing' => '<p>床前明月光,<br>疑是地上霜。<br>举头望明月,<br>低头思故乡。</p>'
        ]);

        DB::table('writings')->insert([
            'title_writing' => '声声慢',
            'user_writing' => '李清照',
            'created_at' => '2017-11-23',
            'introduction_writing' => '愁',
            'image_writing' => '../../images/帖子/writings/声声慢-李清照.jpg',
            'html_writing' => '<p>寻寻觅觅，冷冷清清，凄凄惨惨戚戚。乍暖还寒时候，最难将息。三杯两盏淡酒，怎敌他晚来风急？雁过也，正伤心，却是旧时相识。满地黄花堆积，憔悴损，如今有谁堪摘？守着窗儿，独自怎生得黑？梧桐更兼细雨，到黄昏、点点滴滴。这次第，怎一个愁字了得！</p>'
        ]);


        // leaveMessage
        DB::table('leaveMessages')->insert([
            'name_leaveMessage' => '李白',
            'phone_leaveMessage' => '0123456789',
            'email_leaveMessage' => 'libai@test.com',
            'agreeContact_leaveMessage' => true,
            'contactWay_leaveMessage' => 'email',
            'message_leaveMessage' => '哪个小混蛋乱放我的诗到网上，小心我穿越时空来打死你，我的版权费快点给我寄过来！！'
        ]);

        DB::table('leaveMessages')->insert([
            'name_leaveMessage' => '李清照',
            'phone_leaveMessage' => '0123456789',
            'email_leaveMessage' => 'liqingzhao@test.com',
            'agreeContact_leaveMessage' => true,
            'contactWay_leaveMessage' => 'phone',
            'message_leaveMessage' => '哎呀，臣妾好高兴，竟然有人欣赏我的诗！！'
        ]);


        // movement
        DB::table('movements')->insert([
            'user_id' => 1,
            'title_movement' => '天猫双十一活动斩手会',
            'introduction_movement' => '这里是天猫双十一活动斩手会，买一送一，买二送十，欢迎光临天猫旗舰店!这里是天猫双十一活动斩手会，买一送一，买二送十，欢迎光临天猫旗舰店!',
            'html_movement' => '<h2>来来来，疯狂购！！双十一剁手剁到爽！！</h2>',
            'image_movement' => '../../images/活动推广/天猫.jpg',
            'view_movement' => 2
        ]);
        DB::table('movements')->insert([
            'user_id' => 2,
            'title_movement' => '苏宁易购双十一提前买',
            'introduction_movement' => '这里是苏宁易购拍卖会，买一送一，买二送十，欢迎光临苏宁电器!为您的家带来温暖的额感觉!',
            'html_movement' => '<h2>去去去，多买多送，双手放在炉上烤不停，带给你无尽的香气和温暖！！</h2>',
            'image_movement' => '../../images/活动推广/苏宁易购.jpg',
            'view_movement' => 1
        ]);

    }
}
