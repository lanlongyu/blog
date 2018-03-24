<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use Searchable;

    public function searchableAs()
    {
        return "post";
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'content' => $this->content
        ];
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment')->orderBy('created_at', 'desc');
    }

    public function zan($user_id)
    {
        return $this->hasOne('App\Zan')->where('user_id', $user_id);
    }

    public function zans()
    {
        return $this->hasMany('App\Zan');
    }

    public function scopeAuthorBy($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    public function postTopics()
    {
        return $this->hasMany(PostTopic::class, 'post_id', 'id');
    }

    public function scopeTopicNotBy($query, $topic_id)
    {
        return $query->doesntHave('postTopics', 'and', function ($q) use ($topic_id) {
            $q->where('topic_id', $topic_id);
        }
        );
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope("avaiable", function (Builder $builder) {
            $builder->whereIn('status', [0, 1]);
        }
        );
    }
}
