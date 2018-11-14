<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{

    protected $table = 'forum_posts';

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function thread()
    {
        return $this->belongsTo('App\ForumThread', 'thread_id', 'id');
    }

    public function votes()
    {
        return $this->hasMany('App\ForumVote', 'post_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany('App\ForumComment', 'post_id', 'id');
    }

    public function getVotes()
    {
        return $this->votes()->sum('mark');
    }
    public function checkVote($user)
    {
        return $this->votes()->where('user_id', $user->id)->count()==0;
    }


}
