<template>
    <div>
       <div class="card" 
            v-for="task in tasks"
            v-bind:key="task.id"
            v-bind:name="task.name"
       >
            <div class="card-body">
                {{task.name}}
            </div>
       </div> 
       <add-task :card_id="taskGroup.card_id" :board_id="taskGroup.board_id"></add-task>
    </div>
</template>
<script>
import AddTaskVue from './AddTask.vue';
export default {
    props: ["card_id", "board_id"],
    components:{
        'add-task': AddTaskVue
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
    }
    ,
    beforeDestroy: function(){
        this.$eventHub.$off('taskAdded');
    },
    methods: {
        updateTasksAfterPost: function(task){
            if( this.taskGroup.card_id === task.card_id){
                this.tasks.push(task);
            }
        }
    }

}
</script>
<style>

</style>

