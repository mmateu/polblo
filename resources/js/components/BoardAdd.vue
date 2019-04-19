<template>
    <div>
        <form @submit="addBoard">
            <div class="row" >
                <div class="colboard">
                    <input type="text" name="inp" v-model="input" >
                </div>
                <div class="colboard">
                    <label class="btn primary addboard" for="inp">Dodaj tablicę</label>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
export default {
    data: function(){
        return {
            input:"",
            user:""
        }
    }, 
    mounted(){
        
         axios.get('user')
            .then(response => {
                console.log(response);
                this.user = response.data['data'];
                console.log(this.user);
            })
            .catch(e => {
                this.errors.push(e)
                })
    },
    computed:{
        boardIDENT: function(){
            return {
                'name': this.input,
                'user_id': this.user.user_id
            }
        }
    },
    methods:{
        addBoard:function(e){
            e.preventDefault();
            
            this.$eventHub.$emit('attemptToAddBoard', this.boardIDENT);
            this.input = "";
        }
    }
}
</script>

<style>
.colboard{
    float:left;
}
</style>
