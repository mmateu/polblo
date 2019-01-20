<template>
    <div>
      <div class="card-body task">
                <div class="grid-container">
                    <div class="grid-item">
                        3
                    </div>
                    <div class="grid-item">1</div>
                    <div class="grid-item delete-task">
                        <delete-task :task-api-identyfier="taskApiIdentyfier"></delete-task>
                    </div>
                    <div class="grid-item task-name">
                        {{thisTask.name}}
                    </div>
                    <div class="grid-item">4</div>
                    <div class="grid-item">5</div>
                    <div class="grid-item">6</div>
                    <div class="grid-item">7</div>
                    <div class="grid-item">8</div>        
                </div>
                 
            </div>
    </div>    
</template>
<script>
export default {
    props:{
        board_id: Number, 
        task: Object
    },
    data: function(){
            return{ 
                thisTask: this.task
            }
    },
    computed:{
        taskApiIdentyfier: function(){
            return {
                'card_id': this.thisTask.card_id, 
                'board_id': this.board_id,
                'task_id': this.thisTask.id
            }
        }
    }

}
</script>
<style>
.card-body.task{
    color:sienna;
    width: 100%;
}
#task{
    border-style: double;
    border-color: mistyrose;
}
.grid-container{
    width: 100%;
    display: grid;
    grid-template-columns: auto auto auto;
}
.grid-item{
    text-align:left;
}
.grid-item.delete-task{
    text-align: right;
}
</style>


