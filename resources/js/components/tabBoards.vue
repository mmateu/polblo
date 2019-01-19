<template>
  <div>
      <ul class="tablist">
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
//import {bus} from '../bus.js'
export default {

  data: function () {
  	return {
      boards: [{}],
      tabs: [],
      selectedBoard: null,
      currentTab: ''
    }
  },
  mounted() {
      
      axios.get(`http://polblo.local/board`)
      .then(response => {
        this.boards = response.data['data'];
      })
      .catch(e => {
        this.errors.push(e)
        })
      
  },
  computed: {
    allTabs: function(){
      return this.boards.map(function(board){
        return board.name;
      });
    },
    currentTabComponent: function () {
      return 'tab-' + this.currentTab.toLowerCase()
    }
  }, 
  methods:{
    selectBoard: function(board) {
      this.selectedBoard = board;

      this.$eventHub.$emit('changeSelectedBoards', this.selectedBoard.id);
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
  background-color: rgb(193, 83, 184);
}
.tablist  li{
  float:left;
  margin-right:0.13em;
}
.tablist li a{
  display:block;
padding:0 1em;
text-decoration:none;
border:0.06em solid #000;
border-bottom:0;
color:#000;
background-color:rgb(108, 178, 235);
border-top-right-radius:0.50em;
border-top-left-radius:0.50em;
}
.tablist li a:hover {
background:rgb(83, 193, 226);
color :#fff;
text-decoration:none;
}

</style>
