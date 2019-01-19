<?php

namespace App\Http\Controllers\Board\Card;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Task as TaskResource;
use App\Task; 

class TaskController extends Controller
{
    public function index(Request $request)
    {   
        $path = explode("/", $request->path());  
        $board_id = $path[1]; 
        $card_id = $path[3];
        $card = \App\Card::where('board_id', $board_id )->where('id', $card_id)->first();
        $tasks = $card->tasks()->get();
        
        return new TaskResource([$tasks]);
    }

    public function store($board_id, $card_id, Request $request)
    {
        $task = \App\Task::create($request->all());
        
        return new TaskResource([$task]);
    }

    public function update( $board_id , $card_id,$id, Request $request)
    {
        $task = \App\Task::findOrFail($id);
        $task->update($request->all());
        
        return new TaskResource([$task]);
    }
    public function destroy($board_id, $card_id,Task $task)
    {
        $taskToDelete = \App\Task::findOrFail($task->id);
        $taskToDelete->delete($task->id);
        return new TaskResource([$task]);
    }

}
