<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    protected $table = 'events';

    public function userOrgs()
    {
        return $this->belongsToMany('App\User', 'event_orgs');
    }

    public function isOwner($userId)
    {

        return $this->userOrgs()->first()->id == $userId || \App\User::find($userId)->is_teacher;
    }

    public static function getOld()
    {  
        $start = Carbon::createFromDate(2000, 1, 1);
        $now = Carbon::now();
        return Event::all()->whereBetween('date', [$start, $now]);
    }
    public static function getNew()
    {
        // $now = Carbon::now();
        // $events = Event::all();
        // $end = Carbon::parse($event->date);
        return Event::all()->where('date', '>=', Carbon::now());  
        
    }
    public function hasLiked($userId)
    {
        return $this->userLikes()->where('id', $userId)->count() > 0;
    }
    public function userPartis()
    {
        return $this->belongsToMany('App\User', 'event_partis');
    }

    public function userLikes()
    {
        return $this->belongsToMany('App\User', 'event_likes');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tags', 'event_tags', "event_id", "tag_id");
    }

}
