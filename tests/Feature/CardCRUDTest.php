<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CardCRUDTest extends TestCase
{
    use RefreshDatabase;

    protected $user; 
    protected $user2;
    protected $exampleName; 

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(\App\User::class)->create();
        $this->user2 = factory(\App\User::class)->create();
        $this->actingAs($this->user);
        $this->exampleName = "Example name";
       
    }
    public function testUserCanGetAllCardsFromCertainBoard()
    {
        $userBoard = factory(\App\Board::class)-> create([
            'user_id' => $this->user->id
        ]);  
        $testedBoardCards = factory(\App\Card::class)-> create([
            'board_id' => $userBoard->id
        ]);
        
        $this->get('board/'.$userBoard->id.'/card')->assertJson([
            'data' => [$testedBoardCards->toArray()]
        ]);
    }

    public function testUserCanAddCard()
    {
        $board = factory(\App\Board::class)-> create([
            'user_id' => $this->user->id
        ]);  
        $card = factory(\App\Card::class)-> make([
            'board_id' => $board->id
        ]); 
        
        $res = $this->post('board/'.$board->id."/card", $card->toArray());
        
        $res-> assertStatus(200)
        -> assertJson(['data' => [$card->toArray()]]);
        $this->assertDatabaseHas('cards', $card->toArray());
    }

    /**
     * 
     *@depends testUserCanAddCard
     */
    public function testTwoUsersCanAddTwoCardsWithTheSameName()
    {
        $board1 = factory(\App\Board::class)->create([
            'user_id' => $this->user->id
        ]);
        $board2 = factory(\App\Board::class)->create([
            'user_id' => $this->user2->id
        ]);

        $card1 = factory(\App\Card::class)->make([
            'board_id' => $board1->id, 
            'name'=> $this->exampleName
        ]);

        $card2 = factory(\App\Card::class)->make([
            'board_id' => $board2->id,
            'name'=> $this->exampleName
        ]);
        
        $this->post('board/'.$board1->id."/card", $card1->toArray());

        $postUri = 'board/'.$board2->id.'/card';
        $this->actingAs($this->user2)->post($postUri, $card2->toArray())->
            assertStatus(200);
        
        $this->assertDatabaseHas('cards', $card1->toArray());
        $this->assertDatabaseHas('cards', $card2->toArray());
    }
    /**
     * 
     * @depends testUserCanAddCard
     */
    public function testUserCanCardsWithTheSameNameToDifferentBoards()
    {
        $board1 = factory(\App\Board::class, 2)->create([
            'user_id' => $this->user->id
        ]);
        
        $boards = \App\Board::all()->where('user_id', $this->user->id);
        $cards = [];
        
        foreach ($boards as $board)
        {
            $card = factory(\App\Card::class)->make([
                'name' => $this->exampleName,
                'board_id' => $board->id
            ]);
            $cards[$board->id] = $card;
            $postUri = 'board/'.$board->id."/card";
            $this->post($postUri, $card->toArray())->assertOk();
        }
        foreach ($cards as $card) {
            $this->assertDatabaseHas('cards', $card->toArray());
        }

    }
    /**
     * 
     * @testUserCanAddCard
     */
    public function testUserCanUpdateHisCard()
    {
        $board = factory(\App\Board::class)->create([
            'name'=>$this->exampleName,
            'user_id' => $this->user->id
        ]);       
        $card = factory(\App\Card::class)->create([
            'name'=>$this->exampleName,
            'board_id' => $board->id
        ]);
        
       
        $changedName = "changedName";
        $card->name = $changedName;
        
        $putUri = 'board/'.$board->id."/card/".$card->id;

        $res = $this->put($putUri, $card->toArray()); 
        $res->assertStatus(200)->assertJson(['data' => [$card->toArray()]]);
    }

    /**
     * 
     * @testUserCanAddCard
     */
    public function testUserCanDeleteCardFromOneOfHisBoards()
    {
        
        $board = factory(\App\Board::class)->create([
            'name'=>$this->exampleName, 
            'user_id' => $this->user->id
        ]);
        $cardTemplate = factory(\App\Card::class)->make([
            'name'=>$this->exampleName,
            'board_id' => $board->id
        ]);
        
        $this->post('board/'.$board->id."/card", $cardTemplate->toArray());
        $card = \App\Card::where('board_id', $board->id)->first();

        $deleteUri = 'board/'.$board->id."/card/".$card->id;

        $res = $this->delete($deleteUri);
        $res->assertOk();
        $this->assertDatabaseMissing('cards', $card->toArray());
    }

    
}
