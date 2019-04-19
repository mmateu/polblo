<template>
    <div class='vue'>
        <board-add></board-add> 
        <card-add></card-add>
        <tab-boards>
            v-bind:is="currentTabComponent"
            class="tab"
        </tab-boards>
        <card-list :board_id="board_id"  ></card-list>
    </div>
    
</template>
<script>
    import tabBoardsVue from './tabBoards.vue';
    import cardListVue from './CardList.vue';
    import BoardAddVue from './BoardAdd.vue';
    import CardAddVue from './CardAdd.vue';
    

export default {
    
    data: function(){
        return{
            board_id: 0
        }
    },
    components: {
        'tab-boards': tabBoardsVue,
        'card-list': cardListVue,
        'board-add':BoardAddVue,
        'card-add':CardAddVue
    },
    created: 
        function(){
            this.$eventHub.$on('changeSelectedBoards', this.change);
        },
    beforeDestroy:
        function(){
            this.$eventHub.$off('changeSelectedBoards');
        }
        
    , 
    methods:{
        change: function (id) {
            if(id != null){
                this.board_id = id;
            } else {
                console.log('ID is null');
            }
            
            console.log("Listener WORKS");
        }
    }
    
    
}
</script>
<style>

</style>
