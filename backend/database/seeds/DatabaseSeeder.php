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
        DB::table('users')->insert([
            'name' => '成员A',
            'email' => 'a@test.com',
            'password' => bcrypt('a'),
            'department' => Department::ZUZHIBU,
            'position' => Position::CHENGYUAN,
            'school' => '山鸡大学',
            'phone_number' => '06 05 04 03 01',
            'isWorking' => True,
            'isAvaible' => True,
            'birthday' => date('1993-01-02'),
            'arrive_date' => date('2017-01-02'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        /* Posts */
       
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


        // 活动推广
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

        // 生活随笔
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
            'message_leaveMessage' => '哪个小混蛋乱放我的诗到网上，小心我穿越时空来打死你，我的版权费快点给我寄过来！！',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('leaveMessages')->insert([
            'name_leaveMessage' => '李清照',
            'phone_leaveMessage' => '0123456789',
            'email_leaveMessage' => 'liqingzhao@test.com',
            'agreeContact_leaveMessage' => true,
            'contactWay_leaveMessage' => 'phone',
            'message_leaveMessage' => '哎呀，臣妾好高兴，竟然有人欣赏我的诗！！',
            'created_at' => Carbon::now()->addHours(2)->format('Y-m-d H:i:s')
        ]);

        DB::table('leaveMessages')->insert([
            'name_leaveMessage' => '请不要联系我',
            'phone_leaveMessage' => '0123456789',
            'email_leaveMessage' => 'buzhidao@test.com',
            'agreeContact_leaveMessage' => false,
            'contactWay_leaveMessage' => 'phone',
            'message_leaveMessage' => '我是路人甲。 。 。',
            'created_at' => Carbon::now()->addHours(4)->format('Y-m-d H:i:s')
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
