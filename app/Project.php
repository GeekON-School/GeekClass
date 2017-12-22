<?php
/**
 * Created by PhpStorm.
 * User: AlexNerru
 * Date: 03.09.2017
 * Time: 23:06
 */

namespace App;


use Illuminate\Database\Eloquent\Model;


class Project extends Model
{

    protected $table = "projects";

    protected $fillable = [
        'name', 'short_description', 'description', 'type', 'url', 'author_id', 'image'
    ];

    public function students()
    {
        return $this->belongsToMany('App\User', 'project_students', 'project_id', 'user_id');
    }

    public static function createProject($data)
    {
        $project = Project::create(['name' => $data['name'], 'short_description' => $data['short_description'], 'description' => $data['description']]);

        return $project;
    }

    public function author()
    {
        return $this->author_id;
    }

    public function editProject($data)
    {

        $this->name = $data['name'];
        $this->short_description = $data['short_description'];
        $this->description = $data['description'];
        $this->type = $data['type'];
        $this->url = $data['url'];
        $this->save();
        return $this;
    }
}