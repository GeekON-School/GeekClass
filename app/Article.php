<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public function author()
    {
        return $this->belongsTo('App\User', 'author_id', 'id');
    }

    public function tags(){
        return $this->belongsToMany( 'App\ArticleTag', 'articles_tags', 'article_id', 'tag_id' );
    }

    public function attachTag($tag)
    {
        $tag = mb_strtolower($tag);
        $record = ArticleTag::where('name', $tag)->first();
        if ($record == null)
        {
            $record = new ArticleTag;
            $record->name = $tag;
            $record->save();
        }
        $this->tags()->attach($record->id);
    }
}
