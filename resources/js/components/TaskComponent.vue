<template>
    <div>
      <div class="card-body task">
                <div class="grid-container">
                    <div class="grid-item"></div>
                    <div class="grid-item"></div>
                    <div class="grid-item delete-task">
                        <delete-task :task-api-identyfier="taskApiIdentyfier"></delete-task>
                    </div>
                    <div class="grid-item task-name">
                        {{thisTask.name}}
                    </div>
                    <div class="grid-item"></div>
                    <div class="grid-item"></div>
                    <div class="grid-item"></div>
                    <div class="grid-item"></div>
                    <div class="grid-item update-task">
                        <update-task :task-api-identyfier="taskApiIdentyfier" v-bind="thisTask"></update-task>
                    </div>        
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
.grid-item.update-task{
    align-items: right;
    text-align: right;
}
</style>


