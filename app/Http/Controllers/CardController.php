<?php

namespace App\Http\Controllers;

use App\Card;
use Illuminate\Http\Request;
use App\Board;
use App\Http\Resources\Card as CardResource;

class CardController extends Controller
{


    protected $user;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $this->user = auth()->user();
            
            return $next($request);
        });
        $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $board_id)
    {   
        
        $board = \App\Board::where('id',$board_id )->first();
        return new CardResource($board->cards()->get());
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($board_id , Request $request)
    {

        
        $card =  new Card();

        $card->name = $request->input('name');
        $card->board_id = $request->input('board_id');
        
        if(\App\Card::where('name',$card->name)->
                      where('board_id', $board_id )->first() !=  null )
        {
            return response()->json("['errors' => 'You have already a card with the same name in this board!']", 400);
        }
        if($card->save()) {
            return new CardResource(\App\Card::all()->where('id',$card->id));
        } 
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update($board_id,Request $request, Card $card)
    {
        
        $cardResource =  \App\Card::where('id',$card->id)->first();
        $cardResource->name = $request->input('name') == null ? $card->name : $request->input('name');

        if($cardResource->save()) {
            return new CardResource(collect([$cardResource]));
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy($board_id ,Card $card)
    {
        $cardToDelete =\App\Card::findOrFail($card->id);        
        $cardToDelete->delete($card->id);
        return new CardResource(collect([$cardToDelete]));
    }
}
