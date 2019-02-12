<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CoinTransaction extends Authenticatable
{
    use Notifiable;

    protected $table = 'coin_transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public static function register($user_id, $amount, $comment)
    {
        $transaction = new CoinTransaction();
        $transaction->user_id = $user_id;
        $transaction->price = $amount;
        $transaction->comment = $comment;
        $transaction->save();

        return $transaction;
    }

}
