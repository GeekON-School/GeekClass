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
    }

    public function index($id)
    {
        return view('core.index', compact('id'));
    }

    public function get_core($id)
    {
        $edges = CoreEdge::all();
        $user = User::findOrFail($id);
        foreach ($edges as $edge)
        {
            $edge->source = $edge->from_id;
            $edge->target = $edge->to_id;
            unset($edge->id);
        }

        $nodes = CoreNode::all();
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
        $result = ['nodes' => $nodes, 'edges' => $edges];
        return json_encode($result);
    }

    public function import_core_form() {
       return "<form method='post'>".csrf_field()."<textarea name='data'></textarea><input type='submit'/></form>";
    }
    public function import_core(Request $request)
    {
        $data = json_decode($request->data);
        foreach ($data->nodes as $node)
        {
            $record = new CoreNode();
            $record->title = $node->name;
            $record->id = $node->id;
            $record->cluster = $node->cluster;
            $record->level = $node->level;
            $record->is_root = $node->root;
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