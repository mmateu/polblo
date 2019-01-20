<template>
    <div>
       <div class="card" id="task" 
            v-for="task in tasks"
            v-bind:key="task.id"
            v-bind:name="task.name"
       >
          <task-component :board_id="board_id" :task="task"></task-component>
       </div> 
       <add-task :card_id="taskGroup.card_id" :board_id="taskGroup.board_id"></add-task>
    </div>
</template>
<script>
import AddTaskVue from './AddTask.vue';
import TaskComponentVue from './TaskComponent.vue';
export default {
    props: ["card_id", "board_id"],
    components:{
        'add-task': AddTaskVue,
        'task-component': TaskComponentVue
    },
    data: function(){
        return {
            tasks: {},
            taskGroup: {'card_id':this.card_id, 'board_id': this.board_id},
        }
    }
    ,
    watch: {
        taskGroup :{
           immediate: true,
           
           handler(val){
                 axios.get("http://polblo.local/board/"+val.board_id+"/card/"+val.card_id+"/task/")
                .then(response => {
                this.tasks = response.data['data'][0];
                 })
            .catch(e => {
                this.errors.push(e)
                }); 
           }
        }   
    }, 
    mounted: function(){
        this.$eventHub.$on('taskAdded', this.updateTasksAfterPost);
        this.$eventHub.$on('deleteTask', this.deleteTask);
    }
    ,
    beforeDestroy: function(){
        this.$eventHub.$off('taskAdded');
        this.$eventHub.$off('deleteTask');
    },
    methods: {
        updateTasksAfterPost: function(task){
            if( this.taskGroup.card_id === task.card_id){
                this.tasks.push(task);
            }
        },
        deleteTask: function(task){
            const index = this.tasks.map((e) => e.id).indexOf(task);
            if( index != -1){
                this.tasks.splice(index,1);
            }
                
        }
    }

}
</script>
<style>

</style>

