<template>
    <div>
        <!--<button id="updateTask" class="taskController" @click="showModal">o</button> -->

        <!-- Button trigger modal -->
        <button type="button" @click="showLink" class="btn taskController" data-toggle="modal" data-target="#exampleModal">o</button>

        <!-- Modal -->
        <update-modal :taskUri="this.taskUri"></update-modal>
     
    </div>
</template>
<script>
import updateModal from "./updateModal.vue";
export default {
    components:{
        'update-modal': updateModal
    },
    props:{
        taskApiIdentyfier: Object, 
        task: Object
    },
    data: function(){
        return {
            taskDATA:{
                name:"",
                card_id:0,
                created_at:"",
                id:0,
                name:"",
                start_time:"",
                updated_at:""
            }
        }
    },
    computed:{
        taskUri: function(){
            return  "/board/"+this.taskApiIdentyfier.board_id+
                    "/card/"+this.taskApiIdentyfier.card_id+
                    "/task/"+this.taskApiIdentyfier.task_id;
        }    

    },    
    mounted: function(){
        this.$on('changeName', this.changeName);
    },
    methods:{
        formSubmit: function(e){
            
        }, 
        cancelUpdate: function(){
              
        },
        showLink: function(){
        
            axios.get(this.taskUri)
            .then(response => {
                let task = response.data['data'][0];
                console.log(response.data['data']);
                this.taskDATA.name = task.name;
                this.taskDATA.id = task.id;
                this.taskDATA.card_id = task.card_id;
                this.taskDATA.created_at = task.created_at;
                this.taskDATA.updated_at = task.updated_at;
                this.taskDATA.start_time = task.start_time;
                this.taskDATA.priority = task.priority;

                this.$eventHub.$emit('requestUpdate', task);
                
            })
            .catch(e => {
                this.errors.push(e)
                })

            
        },

        changeName: function(e){
            
            console.log(e);
            
        }
    }
}
</script>
<style>
#updateTask{
    border: none;
    align-items: right;    
}
#updateTask:hover{
       -webkit-box-shadow:inset 0px 0px 0px 1px gainsboro ;
    -moz-box-shadow:inset 0px 0px 0px 1px gainsboro;
    box-shadow:inset 0px 0px 0px 1px gainsboro;
    background: antiquewhite;

}
.tag{
    width: 100%;
}
</style>
