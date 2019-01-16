<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Provider\DateTime;
use Illuminate\Support\Carbon;

class TaskCRUDTest extends TestCase
{
    use RefreshDatabase;

    protected $user; 
    protected $exampleName; 

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(\App\User::class)->create();
        $this->actingAs($this->user);
        $this->exampleName = "Example name";
       
    }
   
    public function testUserCanGetAllTasksForGivenBoard()
    {
        $board = factory(\App\Board::class)-> create([
            'user_id' => $this->user->id
        ]);  
        $card = factory(\App\Card::class)-> create([
            'board_id' => $board->id
        ]);
        $cardNo = 10;
        $tasks = factory(\App\Task::class, $cardNo)->create([
            'card_id' => $card->id,
            'start_time' => Carbon::now()
         ]);

        $getUri = 'board/'.$board->id.'/card/'.$card->id.'/task';
        
        $res = $this->get($getUri)->assertJson(['data' => [$tasks->toArray()]]);
        
    }
    
    public function testUserCanAddTask()
    {
        $board = factory(\App\Board::class)-> create([
            'user_id' => $this->user->id
        ]);  
        $card = factory(\App\Card::class)-> create([
            'board_id' => $board->id
        ]);

        $task = factory(\App\Task::class)-> make([
            'card_id' => $card->id,
            'start_time' => Carbon::now()
        ]);
        $postUri = 'board/'.$board->id."/card/".$card->id."/task";
        $task->start_time = $task->start_time->format('Y-m-d H:m:s');
        
        $res = $this->post($postUri, $task->toArray());
        
        $res->assertOk()->assertJson(['data' => [$task->toArray()]]);
        $this->assertDatabaseHas('tasks', $task->toArray());

    }

    public function testUserCanUpdateTask()
    {
        $board = factory(\App\Board::class)->create([
            'name'=>$this->exampleName,
            'user_id' => $this->user->id
        ]);       
        $card = factory(\App\Card::class)->create([
            'name'=>$this->exampleName,
            'board_id' => $board->id
        ]);

        $task = factory(\App\Task::class)->create([
            'name'=>$this->exampleName,
            'card_id' => $card->id,
            'start_time' => Carbon::now()
        ]);
        
        $task->start_time = $task->start_time->format('Y-m-d H:m:s');
        $changedName = "changedName";
        $task->name = $changedName;
        
        $putUri = 'board/'.$board->id."/card/".$card->id."/task/".$task->id;

        $res = $this->put($putUri, $task->toArray()); 
        $res->assertStatus(200)->assertJson(['data' => [$task->toArray()]]);
    }

    public function testUserCanDeleteTaskFromOneOfHisCards()
    {
        
        $board = factory(\App\Board::class)->create([
            'name'=>$this->exampleName, 
            'user_id' => $this->user->id
        ]);
        $card = factory(\App\Card::class)->create([
            'name'=>$this->exampleName,
            'board_id' => $board->id
        ]);
        
        $task = factory(\App\Task::class)->create([
            'name'=>$this->exampleName,
            'card_id' => $card->id
        ]);

        $deleteUri = 'board/'.$board->id."/card/".$card->id."/task/".$task->id;

        $res = $this->delete($deleteUri);
        $res->assertOk();
        $this->assertDatabaseMissing('tasks', $task->toArray());
    }


}
