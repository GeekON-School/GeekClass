<?php
/**
 * Created by PhpStorm.
 * User: AlexNerru
 * Date: 03.09.2017
 * Time: 23:22
 */

namespace App\Http\Controllers;
use App\CoreEdge;
use App\CoreNode;
use App\Project;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;


class CoreController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('teacher')->only(['import_core']);
    }

    public function index($id, Request $request)
    {
        $version = 1;
        if ($request->has('version'))
        {
            $version = $request->version;
        }
        return view('core.index', compact('id', 'version'));
    }

    public function get_core($id, Request $request)
    {
        $version=1;
        $user = User::findOrFail($id);
        if ($request->has('version'))
        {
            $version = $request->version;
        }

        $nodes = CoreNode::where('version', $version)->get();
        foreach ($nodes as $node)
        {
            if ($user->checkPrerequisite($node))
            {
                $node->nodeType='use';
            }
            else {
                $node->nodeType='exists';
            }
            $node->root = $node->is_root;


        }
        $edges = CoreEdge::whereIn('from_id', $nodes->pluck('id'))->orWhereIn('to_id', $nodes->pluck('id'))->get();

        foreach ($edges as $edge)
        {
            $edge->source = $edge->from_id;
            $edge->target = $edge->to_id;
            unset($edge->id);
        }


        $result = ['nodes' => $nodes, 'edges' => $edges];
        return json_encode($result);
    }

    public function import_core_form() {
       return "<form method='post'>".csrf_field()."<textarea name='data'></textarea><br>Версия:<input type='text' value='1' name='version'/> <input type='submit'/></form>";
    }
    public function import_core(Request $request)
    {
        $data = json_decode($request->data);

        CoreNode::where('version', $request->version)->delete();
        foreach ($data->nodes as $node)
        {
            $record = new CoreNode();
            $record->title = $node->name;
            $record->id = $node->id;
            $record->cluster = $node->cluster;
            $record->level = $node->level;
            $record->is_root = $node->root;
            $record->version = $request->version;
            $record->save();
        }

        foreach ($data->edges as $edge)
        {
            $record = new CoreEdge();
            $record->from_id = $edge->source;
            $record->to_id = $edge->target;
            $record->save();
        }
        echo 'ok';

    }
}