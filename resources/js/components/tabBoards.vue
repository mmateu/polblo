<template>
  <div>
        <ul class="tablist" >
          <li class="tab"
            v-for="board in boards"
            v-bind:key="board.id"
            v-bind:name="board.name"
            v-bind:class="{ selected: board === selectedBoard}"
            v-on:click="selectBoard(board)"
          >
            <a> {{ board.name }} </a>
          </li>
        </ul>
    </div>
</template>

<script>
export default {

  data: function () {
  	return {
      boards: [{}],
      selectedBoard: null,
      currentTab: ''
    }
  },

  mounted() {
      
      axios.get(`http://localhost:8000/board`)
      .then(response => {
        this.boards = response.data['data'];
      })
      .catch(e => {
        this.errors.push(e)
        })
        
  },
  created(){
    this.$eventHub.$on('attemptToAddBoard', this.addBoard);
  },
  computed: {
    allTabs: function(){
      return this.boards.map(function(board){
        return board.name;
      });
    },
    currentTabComponent: function () {
      return 'tab-' + this.currentTab.toLowerCase()
    }, 
  }, 
  methods:{
    selectBoard: function(board) {
      this.selectedBoard = board;

      this.$eventHub.$emit('changeSelectedBoards', this.selectedBoard.id);
    }, 
    addBoard: function(board){
     
          axios.post('board', {
                name: board.name,
                user_id: board.user_id
          })
          .then(response => {
              if( response.status === 200){
                  this.$eventHub.$emit('boardAdded', response.data['data'][0]);
                  this.boards.push(response.data['data'][0]);
              }
      
          })
          .catch(e => {
              this.errors.push(e)
          }); 
    }
  }

} 
</script>

<style>
.tablist {
list-style:none;
height:2em;
padding:0;
margin:0;
border: none;
}
.tablist li.tab.selected a{
  background-color: rgb(255, 223, 176);
  border-width: 0.5px;
  border-color: rgb(247, 220, 180);
  border-collapse: collapse;
}
.tablist  li{
  float:left;
  margin-right:0.13em;
}
.tablist li a{
  display:block;
padding:0 1em;
text-decoration:none;
border:0.06em solid rgb(247, 220, 180);
border-bottom:0;
color:#000;
background-color:rgb(255, 242, 225);
border-top-right-radius:0.50em;
border-top-left-radius:0.50em;
}
.tablist li a:hover {
background:rgb(250, 222, 190);
color :#fff;
text-decoration:none;
}

</style>
