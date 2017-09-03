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
        'name', 'description', 'type', 'url'
    ];

    protected function creatorsOfProject()
    {
        return $this->belongsToMany('App\User', 'project_students', 'project_id', 'user_id');
    }

    public static function createProject($data)
    {
        $project = Project::create(['name' => $data['name'], 'description' => $data['description']]);
        return $project;
    }
    public function editProject($data)
    {
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->type = $data['type'];
        $this->url = $data['url'];
        $this->save();
        return $this;
    }
}