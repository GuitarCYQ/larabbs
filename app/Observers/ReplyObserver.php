<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function created(Reply $reply)
    {
        //命令行运行迁移时不做这些操作
        if ( ! app()->runningInConsole()) {
            //回复创建成功后 计算本话题下有多少回复
            $reply->topic->updateReplyCount();

            //通知话题作者有新的评论
            $reply->topic->user->notify(new TopicReplied($reply));
        }
    }

    public function creating(Reply $reply)
    {
        //过滤XSS 使用的过滤规则时user_topic_body
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function deleted(Reply $reply)
    {
        $reply->topic->updateReplyCount();
    }


}