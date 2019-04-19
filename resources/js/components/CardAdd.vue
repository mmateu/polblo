<template>
    <div v-if="board_id !== ''">
        <form @submit="addCard" >
            <div class="row">
                <div class="colboard">
                    <input type="text" required v-model="input" name="cardName">
                </div>
                <div class="colboard">
                    <label class="btn primary" for="cardName">Dodaj kartę</label>
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
            board_id:""
        }
    }, 
    computed: {
      cardIDEN: function(){
          return{
            name:this.input,
            board_id :this.board_id
          }
        
      }  
    },
    created: function(){
        this.$eventHub.$on('changeSelectedBoards', this.setBoard);
    },
    beforeDestroy: function (){
        this.$eventHub.$off('changeSelectedBoards');
    },
    methods:{
         setBoard: function(board){
             this.board_id = board;
             this.$eventHub.$emit('boardWasSet', board);
         },
        addCard: function(e){
            e.preventDefault();
            
            this.$eventHub.$emit('attemptToAddCard', this.cardIDEN);
            this.input = "";

         }
     }
}
</script>
<style>

</style>

