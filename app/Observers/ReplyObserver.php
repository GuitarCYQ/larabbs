<?php

namespace App\Observers;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{

    public function creating(Reply $reply)
    {
        //过滤XSS 使用的过滤规则时user_topic_body
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function created(Reply $reply)
    {
        //回复创建成功后 计算本话题下有多少回复
        $reply->topic->reply_count = $reply->topic->replies->count();
        $reply->topic->save();
    }


}