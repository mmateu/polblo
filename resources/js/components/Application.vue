<template>
    <div>
        <tab-boards >
            v-bind:is="currentTabComponent"
            class="tab"
        </tab-boards>
        <task-cards :board_id="board_id"  ></task-cards>
    </div>
    
</template>
<script>
    import tabBoardsVue from './tabBoards.vue';
    import taskCardsVue from './taskCards.vue';
    
export default {
    
    data: function(){
        return{
            board_id: 0
        }
    },
    components: {
        'tab-boards': tabBoardsVue,
        'task-cards': taskCardsVue
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
