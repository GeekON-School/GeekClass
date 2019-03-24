<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    //


    protected $fillable = ['user_id', 'title', 'description'];

    public function getReward()
    {
        return $this->hasMany('\App\GameReward')->sum('amount'); 
    }

    public function comments()
    {
        return $this->hasMany('\App\GameComments')->orderBy('id', 'DESC');
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            \Storage::disk('local')->deleteDirectory('games/'.$obj->id);
        });
    }

    public function vote($amount, $user_id = null)
    {
        $user_id = \Auth::id();
        if ($this->hasVoted($user_id))
        {
            $gv =  $this->hasMany('\App\GameVotes')->where('user_id', $user_id)->get()[0];
            $gv->amount = $amount;
            $gv->save();
        }
        else
        {
            \App\GameVotes::create([
                'amount' => $amount,
                'user_id' => $user_id,
                'game_id' => $this->id
            ]);
        }

    }

    public function upvotes()
    {
        return $this->hasMany('\App\GameVotes')->sum('amount');
    }

    public function hasVoted($user)
    {
        return count($this->hasMany('\App\GameVotes')->where('user_id', $user)->get()) > 0;
    }

    public function hasUpvoted($user)
    {
        return $this->hasMany('\App\GameVotes')->where('user_id', $user)->get()->sum('amount') > 0;
    }

    public function hasDownvoted($user)
    {
        return $this->hasMany('\App\GameVotes')->where('user_id', $user)->get()->sum('amount') < 0;
    }

    public function code()
    {
        $entry = \App\Game::config()->entrypoint;
        return \Storage::disk('local')->get('games/'.$this->id.'/'.$entry);
    }

    public static function template()
    {
        return \File::get(base_path().'/public/gameTemplate.js');
    }

    public static function projectJsonTemplate()
    {
        return '{"entrypoint": "index.js"}';
    }

    public function editCode($code)
    {
        $entry = $this->config()->entrypoint;
        \Storage::disk('local')->put('games/'.$this->id.'/'.$entry, $code);
    }

    public static function initGame($id, $code)
    {
        \Storage::disk('local')->put('games/'.$id.'/index.js', $code);
        \Storage::disk('local')->put('games/'.$id.'/project.json', \App\Game::projectJsonTemplate());
    }

    public static function make($user_id, $title, $description, $code)
    {
        $game = \App\Game::create([
            'user_id' => $user_id,
            'title' => $title,
            'description' => $description
        ]);

        \App\Game::initGame($game->id, $code);
        $game->save();
        return $game->id;
    }

    public static function modify($id, $title, $description, $code)
    {
        $game = \App\Game::find($id);

        $game->title = $title;
        $game->description = $description;
        $game->editCode($code);

        $game->save();
        return $game->id;
    }

    public function config()
    {
        try
        {
            return json_decode(\Storage::disk('local')->get('/games/'.$this->id.'/project.json'));
        }
        catch (\Exception $e)
        {
            abort(404);
        }
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function file()
    {

        try
        {
            return \Storage::disk('local')->get('/games/'.$this->id.'/'.$this->config()->entrypoint);
        }
        catch (\Exception $e)
        {
            abort(404);
        }
        
    }
}
