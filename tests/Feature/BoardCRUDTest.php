<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;


class BoardCRUDTest extends TestCase
{
    use RefreshDatabase;

    protected $user; 
    protected $user2;

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(\App\User::class)->create();
        $this->user2 = factory(\App\User::class)->create();
        $this->actingAs($this->user);
       
    }
    public function testUserCanGetSingleBoard()
    {
        $testedUserBoards = factory(\App\Board::class)-> create(['user_id' => $this->user->id]);    
        $board = \App\Board::where('user_id', $this->user->id)->first();
        $this->get('board/'.$board->id)->assertJson(['data' => [$board->toArray()]]);

    }
    public function testUserGetOnlyHisOwnBoards()
    {

        $testedUserBoards = factory(\App\Board::class,10)-> create(['user_id' => $this->user->id]);    
        $this->get('board')->assertJson(['data' => $testedUserBoards->toArray()]);

    }
    public function testUserCanAddBoard()
    {
        $testedUserBoard = factory(\App\Board::class)-> make(['user_id' => $this->user->id]);  

        
        $res = $this->post('board', $testedUserBoard->toArray())-> assertStatus(200)
        -> assertJson(['data' => [$testedUserBoard->toArray()]]);
        $this->assertDatabaseHas('boards', $testedUserBoard->toArray());

    }
    public function testUserCantAddBoardWithTheSameName()
    {
        $exampleName = 'Example name';
        $firstCommonNameBoard = factory(\App\Board::class)->make(['name'=>$exampleName,'user_id' => $this->user->id]); 
        $secondCommonNameBoard = factory(\App\Board::class)->make(['name'=>$exampleName, 'user_id' => $this->user->id]);
         
        $this->post('board', $firstCommonNameBoard->toArray())-> assertStatus(200)
        -> assertJson(['data' => [$firstCommonNameBoard->toArray()]]);
        $this->post('board', $secondCommonNameBoard->toArray())-> assertStatus(400);
        

        

    }
    public function testUserCanAddBoardWithDifferentNames()
    {
        $exampleName = 'Example name';
        $secondExampleName = 'Second example';
        $firstExampleBoard = factory(\App\Board::class)->make(['name'=>$exampleName,'user_id' => $this->user->id]); 
        $secondExampleBoard = factory(\App\Board::class)->make(['name'=>$secondExampleName, 'user_id' => $this->user->id]);
         
        $this->post('board', $firstExampleBoard->toArray())-> assertStatus(200)
        -> assertJson(['data' => [$firstExampleBoard->toArray()]]);
        $this->post('board', $secondExampleBoard->toArray())-> assertStatus(200)
        -> assertJson(['data' => [$secondExampleBoard->toArray()]]);
    }
    public function testDifferentUsersCanAddBoardsWithTheSameName()
    {
        $exampleName = 'Example name';
        $firstCommonNameBoard = factory(\App\Board::class)->make(['name'=>$exampleName,'user_id' => $this->user->id]); 
        $secondCommonNameBoard = factory(\App\Board::class)->make(['name'=>$exampleName, 'user_id' => $this->user2->id]);
         
        $this->post('board', $firstCommonNameBoard->toArray())-> assertStatus(200)
        -> assertJson(['data' => [$firstCommonNameBoard->toArray()]]);
        $this->actingAs(factory(\App\User::class)->create())->post('board', $secondCommonNameBoard->toArray() )
        ->assertStatus(200)-> assertJson(['data' => [$secondCommonNameBoard->toArray()]]);
    }
    /**
     * 
     *@depends testUserCanAddBoard
     */
    public function testUserCanUpdateHisBoard()
    {
        $exampleName = 'Example name';
        $firstCommonNameBoard = factory(\App\Board::class)->make(['name'=>$exampleName,'user_id' => $this->user->id]);
        
        $this->post('board', $firstCommonNameBoard->toArray());
        $board = \App\Board::where('name', $exampleName)->first();
        
        $changedName = "Changed name";
        $board->name = $changedName;
        
        $this->put('board/'.$board->id, $board->toArray())->assertStatus(200)->assertJson(['data' => [$board->toArray()]]);
        
    }
    /**
     * 
     *@depends testUserCanAddBoard
     */
    public function testUserCanDeleteHisBoard()
    {
        $exampleName = 'Example name';
        $firstCommonNameBoard = factory(\App\Board::class)->make(['name'=>$exampleName,'user_id' => $this->user->id]);
        
        $this->post('board', $firstCommonNameBoard->toArray());
        $board = \App\Board::where('name', $exampleName)->first();

        $this->delete('board/'.$board->id)->assertOk();
        $this->assertDatabaseMissing('boards', $board->toArray());
    }
    /**
     * 
     *@depends testUserCanDeleteHisBoard
     */
    public function testUserGetNotFoundStatusWhenAttemptingToUpdateNonExistingBoard()
    {
        $exampleName = 'Example name';
        $firstCommonNameBoard = factory(\App\Board::class)->make(['name'=>$exampleName,'user_id' => $this->user->id]);
        
        $this->post('board', $firstCommonNameBoard->toArray());
        $board = \App\Board::where('name', $exampleName)->first();
        
        $this->delete('board/'.$board->id);
        $this->put('board/'.$board->id, $board->toArray())->assertNotFound();
    }
    /**
     *@depends testUserCanAddBoard
     *@depends testUserCanDeleteHisBoard
     */
    public function testUserGetNotFoundStatusWhenAttemptingToSeeNonExistingBoard()
    {
        $exampleName = 'Example name';
        $firstCommonNameBoard = factory(\App\Board::class)->make(['name'=>$exampleName,'user_id' => $this->user->id]);
        
        $this->post('board', $firstCommonNameBoard->toArray());
        $board = \App\Board::where('name', $exampleName)->first();
        
        $this->delete('board/'.$board->id);
        $this->get('board/'.$board->id)->assertNotFound();
    }


    /**
     * 
     *@depends testUserCanAddBoard
     */
    public function testUserGetNotFoundStatusWhenAttemptingToDeleteNonExistingBoard()
    {
        $exampleName = 'Example name';
        $firstCommonNameBoard = factory(\App\Board::class)->make(['name'=>$exampleName,'user_id' => $this->user->id]);
        
        $this->post('board', $firstCommonNameBoard->toArray());
        $board = \App\Board::where('name', $exampleName)->first();

        $this->delete('board/'.$board->id);
        $this->delete('board/'.$board->id)->assertNotFound();
    }
    
}
