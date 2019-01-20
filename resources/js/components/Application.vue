<template>
    <div class='vue'>
        <tab-boards >
            v-bind:is="currentTabComponent"
            class="tab"
        </tab-boards>
        <card-list :board_id="board_id"  ></card-list>
    </div>
    
</template>
<script>
    import tabBoardsVue from './tabBoards.vue';
    import cardListVue from './CardList.vue';

export default {
    
    data: function(){
        return{
            board_id: 0
        }
    },
    components: {
        'tab-boards': tabBoardsVue,
        'card-list': cardListVue
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
