<template>
    <div>
        <div class="card">
            <label for="taskName">+</label>
            <form @submit="formSubmit" method="post">
                
                <input  type="text" 
                        placeholder="Dodaj nowe zadanie" 
                        name="taskName" 
                        id="taskName"
                        v-model="taskName"
                        >
            </form>
        </div>
    </div>
</template>

<script>
export default {
    props:['card_id', 'board_id'],
    data: function(){
        return{
            taskName: ""
        }
    }, 
    computed:{
        taskPostUrl: function(){
            return "/board/"+this.board_id+"/card/"+this.card_id+"/task/";
        }
    },
    methods:{
        formSubmit: function(e){
            e.preventDefault();
            e.stopPropagation();
                
            let currentObject = this;
            axios.post(currentObject.taskPostUrl, {
                name: this.taskName,
                card_id: this.card_id
            })
            .then(response => {
                if( response.status === 200){
                    this.$eventHub.$emit('taskAdded', response.data['data'][0]);
                }
                this.taskName = ""; 
            })
            .catch(e => {
                this.errors.push(e)
            }); 
        }
    }

}
</script>
<style>
#taskName{
    width: 100%;
}
</style>
