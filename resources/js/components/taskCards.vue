<template>
    <div>
         <div class="card"
          v-for="card in cards"
          v-bind:key="card.id"
          v-bind:name="card.name"
          >
          <div class="card-body">{{card.name}}</div>
          </div>
    </div>
</template>
<script>
export default {
    props: ['board_id'],
    data: function(){
        return {
            cards: [{}],            
        }
    },
    watch: {
        board_id :{
           immediate: true,
           handler(val, oldVal){
                axios.get("http://polblo.local/board/"+val+"/card")
                .then(response => {
                this.cards = response.data['data'];
                 })
            .catch(e => {
                this.errors.push(e)
                })
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

</style>
