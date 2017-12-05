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
            'category' => 2,    
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'published_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'view' => 15,
            'preview_img_url' => 'http://www.endlessicons.com/wp-content/uploads/2012/11/image-holder-icon-614x460.png',
            'preview_text' => 'preview text'
        ]);
        DB::table('posts')->insert([
            'title' => 'title 2',
            'user_id' => '1',
            'html_content' => 'hh',
            'category' => 2,
            'created_at' => '2017-11-02',
            'published_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'view' => 20,
            'preview_img_url' => 'http://www.endlessicons.com/wp-content/uploads/2012/11/image-holder-icon-614x460.png',
            'preview_text' => 'preview text'
        ]);
        DB::table('posts')->insert([
            'title' => 'title 3',
            'user_id' => '1',
            'html_content' => 'hhh',
            'category' => 2,
            'created_at' => '2017-11-02',
            'published_at' => '2017-10-30',
            'view' => 25,
            'preview_img_url' => 'http://www.endlessicons.com/wp-content/uploads/2012/11/image-holder-icon-614x460.png',
            'preview_text' => 'preview text'
        ]);
        DB::table('posts')->insert([
            'title' => 'title 4 loooooooooooooooooooooooooooooo oooooooooooooooooooooooooooooooooo oooooooooooooooooooooooooooooooooooooooooooooo ooooooooooooooooooooooooooooooooooong title',
            'user_id' => '2',
            'html_content' => 'hhhh',
            'category' => 2,
            'created_at' => '2017-11-01',
            'published_at' => '2017-11-03',
            'view' => 30,
            'preview_img_url' => 'http://www.endlessicons.com/wp-content/uploads/2012/11/image-holder-icon-614x460.png',
            'preview_text' => 'preview text'
        ]);
        DB::table('posts')->insert([
            'title' => 'title 很长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长长5',
            'user_id' => '2',
            'html_content' => 'hhhhh',
            'category' => 2,
            'published_at' => '2017-11-01',
            'created_at' => '2017-11-02',
            'view' => 35,
            'preview_img_url' => 'http://www.endlessicons.com/wp-content/uploads/2012/11/image-holder-icon-614x460.png',
            'preview_text' => 'preview text'
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
            'view' => 99,
            'preview_img_url' => 'http://www.endlessicons.com/wp-content/uploads/2012/11/image-holder-icon-614x460.png',
            'preview_text' => 'preview text'
        ]);
        // 草稿 （无published——at）
        DB::table('posts')->insert([
            'title' => 'title 6',
            'user_id' => '1',
            'html_content' => 'non pub',
            'category' => 2,
            'created_at' => '2017-11-02',
            'view' => 0,
            'preview_img_url' => 'http://www.endlessicons.com/wp-content/uploads/2012/11/image-holder-icon-614x460.png',
            'preview_text' => 'preview text'
        ]);
        DB::table('posts')->insert([
            'title' => 'title 7',
            'user_id' => '1',
            'html_content' => 'non pub',
            'category' => 2,
            'created_at' => '2017-11-01',
            'view' => 0,
            'preview_img_url' => 'http://www.endlessicons.com/wp-content/uploads/2012/11/image-holder-icon-614x460.png',
            'preview_text' => 'preview text'
        ]);
        DB::table('posts')->insert([
            'title' => 'title 8',
            'user_id' => '1',
            'html_content' => 'non pub',
            'category' => 2,
            'created_at' => '2017-10-31',
            'view' => 0,
            'preview_img_url' => 'http://www.endlessicons.com/wp-content/uploads/2012/11/image-holder-icon-614x460.png',
            'preview_text' => 'preview text'
        ]);


       
        /* 工作咨询 */
        DB::table('posts')->insert([
            'title' => 'job 1',
            'user_id' => '1',
            'html_content' => 'here is the first job',
            'category' => 3,
            'created_at' => '2017-10-31',
            'view' => 0,
            'preview_img_url' => 'http://www.endlessicons.com/wp-content/uploads/2012/11/image-holder-icon-614x460.png',
            'preview_text' => '{"title" : "tt", "company" : "cpm", "city" : "Rouen", "salary" : "12345"}',
            'published_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('posts')->insert([
            'title' => 'job 2',
            'user_id' => '1',
            'html_content' => 'here is the second job',
            'category' => 3,
            'created_at' => '2017-10-31',
            'view' => 0,
            'preview_img_url' => 'http://www.endlessicons.com/wp-content/uploads/2012/11/image-holder-icon-614x460.png',
            'preview_text' => '{"title" : "tt22", "company" : "cpm2", "city" : "Rouen222", "salary" : "233"}',
            'published_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('posts')->insert([
            'title' => 'job 3',
            'user_id' => '1',
            'html_content' => 'here is the third job',
            'category' => 3,
            'created_at' => '2017-10-31',
            'view' => 0,
            'preview_img_url' => 'http://www.endlessicons.com/wp-content/uploads/2012/11/image-holder-icon-614x460.png',
            'preview_text' => '{"title" : "33", "company" : "33", "city" : "3", "salary" : "3"}',
            'published_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        // 活动推途
        DB::table('posts')->insert([
            'user_id' => '1',
            'category' => 1,
            'title' => '活动 1',
            'preview_text' => '{"introduction": "简介 1"}',
            'preview_img_url' => 'http://www.endlessicons.com/wp-content/uploads/2012/11/image-holder-icon-614x460.png',
            'html_content' => '<h1>活动 一</h1>',
            'view' => 0,
            'published_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => '2017-10-31',
        ]);
        DB::table('posts')->insert([
            'user_id' => '1',
            'category' => 1,
            'title' => '活动 2',
            'preview_text' => '{"introduction": "简介 2"}',
            'preview_img_url' => 'http://www.endlessicons.com/wp-content/uploads/2012/11/image-holder-icon-614x460.png',
            'html_content' => '<h1>活动 2</h1>',
            'view' => 0,
            'published_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => '2017-10-31',
        ]);
        DB::table('posts')->insert([
            'user_id' => '1',
            'category' => 1,
            'title' => '活动 3',
            'preview_text' => '{"introduction": "简介 3"}',
            'preview_img_url' => 'http://www.endlessicons.com/wp-content/uploads/2012/11/image-holder-icon-614x460.png',
            'html_content' => '<h1>活动 3</h1>',
            'view' => 0,
            'published_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => '2017-10-31',
        ]);

        // 活动推途
        DB::table('posts')->insert([
            'user_id' => '1',
            'category' => 4,
            'title' => '生活随笔 1',
            'preview_text' => '{"username": "作者 1","introduction": "简介 1"}',
            'preview_img_url' => 'http://www.endlessicons.com/wp-content/uploads/2012/11/image-holder-icon-614x460.png',
            'html_content' => '<h1>生活随笔 一</h1>',
            'view' => 0,
            'published_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => '2017-10-31',
        ]);
        DB::table('posts')->insert([
            'user_id' => '1',
            'category' => 4,
            'title' => '生活随笔 2',
            'preview_text' => '{"username": "作者 2","introduction": "简介 2"}',
            'preview_img_url' => 'http://www.endlessicons.com/wp-content/uploads/2012/11/image-holder-icon-614x460.png',
            'html_content' => '<h1>生活随笔 2</h1>',
            'view' => 0,
            'published_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => '2017-10-31',
        ]);
        DB::table('posts')->insert([
            'user_id' => '1',
            'category' => 4,
            'title' => '生活随笔 3',
            'preview_text' => '{"username": "作者 3","introduction": "简介 3"}',
            'preview_img_url' => 'http://www.endlessicons.com/wp-content/uploads/2012/11/image-holder-icon-614x460.png',
            'html_content' => '<h1>生活随笔 3</h1>',
            'view' => 0,
            'published_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => '2017-10-31',
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
