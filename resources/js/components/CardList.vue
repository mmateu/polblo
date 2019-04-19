<template>
    <div v-bind:class= "{ unLoaded: true == hideUnloaded }">
        <div class="row">
            <div class="col" 
                v-for="card in cards"
                v-bind:key="card.id" 
                v-bind:name="card.name">
                <div class="card-deck">
                    <div class="card text-center mr-4">

                        <div class="card-body w-auto">{{card.name}}</div>

                    </div>

                </div>

                <task-list class='my-1' :board_id="board" :card_id="card.id"></task-list>
            </div>
        </div>

    </div>
</template>
<script>
import tasks from './Tasks.vue';
import CardComponentVue from './CardComponent.vue';
export default {
    components:{
        'task-list': tasks,
        'card-component': CardComponentVue
    },
    props: ['board_id'],
    data: function(){
        return {
            cards: [{}],  
            board: this.board_id   
        }
    },
    computed:{
        hideUnloaded: function(){
            return this.board_id === 0;
        }
    },
    created: function(){
        this.$eventHub.$on('attemptToAddCard', this.addCard);
    },
    watch: {
        board_id :{
           immediate: true,
           handler(val){
                axios.get("http://localhost:8000/board/"+val+"/card")
                .then(response => {
                this.cards = response.data['data'];
                 })
            .catch(e => {
                this.errors.push(e)
                });
            this.board = val;
           }
        }   
    },
    methods: {
       addCard: function(card){
           axios.post('board/'+this.board_id+"/card", {
                name: card.name,
                board_id: card.board_id
          })
          .then(response => {
              if( response.status === 200){
                  this.$eventHub.$emit('cardAdded', response.data['data'][0]);
                  this.cards.push(response.data['data'][0]);
              }
      
          })
          .catch(e => {
              this.errors.push(e)
          }); 
       }
    },

}
</script>
<style>
.unLoaded *{
    display: none;
}
</style>
