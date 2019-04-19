<template>
    <div>
        <button id="deleteTask" class="taskController" @click="deleteTask">x</button>
    </div>
</template>
<script>
export default {
    props:{
        taskApiIdentyfier: Object
    },
    computed:{
        taskUrl: function(){
            return  "/board/"+this.taskApiIdentyfier.board_id+
                    "/card/"+this.taskApiIdentyfier.card_id+
                    "/task/"+this.taskApiIdentyfier.task_id;
        }
    },
    methods: {
        deleteTask: function(){
            axios.delete(this.taskUrl)
            .then(response => {
                console.log(response);
            })
            .catch(e => {
                this.errors.push(e)
            });

            this.$eventHub.$emit('taskDeleted', this.taskApiIdentyfier.task_id);
        }
    }, 
    /* mounted: function(){
        console.log(this.taskApiIdentyfier);
        console.log("mounted");
    } */

}
</script>
<style>
#deleteTask{
    border: none;
    align-items: right;    
}
#deleteTask:hover{
       -webkit-box-shadow:inset 0px 0px 0px 1px gainsboro ;
    -moz-box-shadow:inset 0px 0px 0px 1px gainsboro;
    box-shadow:inset 0px 0px 0px 1px gainsboro;
    background: antiquewhite;

}
</style>


