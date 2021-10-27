<?php

namespace Tests\Feature;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\ActingJWTUser;

class TopicApiTest extends TestCase
{
    use RefreshDatabase;
    //使用ActingJWTUSer 获取生成的token
    use ActingJWTUser;

    protected $user;

    //setUp() 在开始之前执行
    protected function setUp(): void
    {
        parent::setUp();

        //创建用户
        $this->user = User::factory()->create();
    }

    //生成一个话题
    protected function makeTopic()
    {
        return Topic::factory()->create([
            'user_id'   =>  $this->user->id,
            'category_id'   =>  1,
        ]);
    }

    //测试发布话题
    public function testStoreTopic()
    {
        $data = ['category_id' => 1, 'body' => 'test body', 'title' => 'test title'];

        //JWTActingAs()调用ActingJWTUser文件获取生成的token
        $response = $this->JWTActingAs($this->user)
            //1.请求方法 2.请求地址 3.请求参数 4.请求Header也可以用withHeader方法
            ->json('POST', '/api/v1/topics', $data);

        $asserData = [
            'category_id'   =>  1,
            'user_id'   =>  $this->user->id,
            'title' =>  'test title',
            'body'  =>  clean('test body', 'user_topic_body'),
        ];

        $response->assertStatus(201)
            //assertJsonFragment()响应结果包含$asserData
            ->assertJsonFragment($asserData);
    }

    //测试修改话题
    public function testUpdateTopic()
    {
        //调用makeTopic()生成一个话题
        $topic = $this->makeTopic();

        $editData = ['category_id' => 2, 'body' => 'edit body', 'title' => 'edit title'];

        $response = $this->JWTActingAs($this->user)
            ->json('PATCH', '/api/v1/topics/'.$topic->id, $editData);

        $assertData = [
            'category_id'   =>  2,
            'user_id'   =>  $this->user->id,
            'title' =>  'edit title',
            'body'  =>  clean('edit body', 'user_topic_body'),
        ];

        $response->assertStatus(200)
            ->assertJsonFragment($assertData);
    }

    //测试查看话题
    //测试话题详情
    public function testShowTopic()
    {
        //创建话题
        $topic = $this->makeTopic();
        $response = $this->json('GET','/api/v1/topics/'.$topic->id);

        $assertData = [
            'category_id'   =>  $topic->category_id,
            'user_id'   =>  $topic->user_id,
            'title' =>  $topic->title,
            'body'  =>  $topic->body,
        ];

        $response->assertStatus(200)
            ->assertJsonFragment($assertData);
    }

    //测试话题列表
    public function testIndexTopic()
    {
        $response = $this->json('GET', '/api/v1/topics');

        $response->assertStatus(200)
            //响应数据结构中有 data 和 meta
            ->assertJsonStructure(['data', 'meta']);
    }

    //测试删除话题
    public function testDeleteTopic()
    {
        $topic = $this->makeTopic();
        $response = $this->JWTActingAs($this->user)
            ->json('DELETE', '/api/v1/topics/'.$topic->id);
        $response->assertStatus(204);

        //查看删除的话题 会得到404
        $response = $this->json('GET', '/api/v1/topics/'.$topic->id);
        $response->assertStatus(404);
    }

}
