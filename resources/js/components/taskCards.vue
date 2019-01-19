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
export default {
    components:{
        'task-list': tasks
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
    watch: {
        board_id :{
           immediate: true,
           handler(val){
                axios.get("http://polblo.local/board/"+val+"/card")
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
        reloadCards: function(){
           
        }
    },

}
</script>
<style>
.unLoaded {
    display: none;
}
</style>
