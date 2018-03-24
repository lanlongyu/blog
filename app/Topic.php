<?php

namespace App;

class Topic extends Model
{
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_topics', 'topic_id', 'post_id');
    }

    public function postTopics()
    {
        return $this->hasMany(PostTopic::class, 'topic_id');
    }
}
