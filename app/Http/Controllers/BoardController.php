<?php

namespace App\Http\Controllers;

use App\Board;
use Illuminate\Http\Request;
use App\Http\Resources\Board as BoardResource;
use App\User;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $user;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $this->user = auth()->user();

            return $next($request);
        });

    }
    public function index()
    {
        
        $boards = $this->user->boards()->get();
        
        return new BoardResource($boards);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $board =  new Board();
        $board->name = $request->input('name');
        $board->user_id = $request->input('user_id');
        
        if(\App\Board::where('name',$board->name)->where('user_id', $board->user_id)->first() !=  null )
        {
            return response()->json("['errors' => 'There is already a board with the same name!']", 400);
        }
        if($board->save()) {
            return new BoardResource(\App\Board::all()->where('id',$board->id));
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function show(Board $board)
    {   

        $boardResource = collect(\App\Board::all()->where('id',$board->id));
        return new BoardResource(collect($boardResource));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Board $board)
    {
        $boardResource =  \App\Board::where('id',$board->id)->first();
        $boardResource->name = $request->input('name') == null ? $board->name : $request->input('name');

        if($boardResource->save()) {
            return new BoardResource(collect([$boardResource]));
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board)
    {
        $boardToDelete =\App\Board::findOrFail($board->id);        
        $boardToDelete->delete($board->id);
        return new BoardResource(collect([$boardToDelete]));

    }
}
