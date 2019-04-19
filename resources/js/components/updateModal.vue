<template>
    <div>
           <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{taskDATA.name}} </h5>
                        <button type="button" @click="cancelUpdate" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form >
                            <div class="row">
                                
                                <label for="name">Nazwa zadania:</label>
                                <div class="col pull-right">
                                    <input type="text" name="name" v-model="taskDATA.name" class="tag">
                                </div>
                            </div>
                            <div class="row"> 
                                <label for="time">Godzina rozpoczęcia:</label>
                                <div class="col pull-right">
                                    <input type="time" step="1" name="time" v-model.lazy="taskDATA.time" class="tag">
                                </div>
                            </div>
                            <div class="row">
                                <label for="date">Data rozpoczęcia:</label>
                                <div class="col">
                                    <input type="date" name="date" v-model.lazy="taskDATA.date" class="tag">
                                </div>
                            </div>
                            <div class="row">
                            <label for="priority">Priorytet:</label>
                            <div class="col pull-right">
                                <select name="priority" v-model.lazy="taskDATA.priority" class="tag">
                                    <option value="default">standardowy</option>
                                    <option value="low">niski</option>
                                    <option value="medium">średni</option>
                                    <option value="high">wysoki</option>
                                </select>
                            </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cancelUpdate" data-dismiss="modal">Anuluj</button>
                        <button type="button"  data-dismmiss="modal" @click="saveChanges" class="btn btn-info">Zapisz zmiany</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['taskUri'],
    data: function(){
        return {
            taskDATA:{
                name:"",
                card_id:0,
                created_at:"",
                id:0,
                name:"",
                start_time:"",
                updated_at:""
            }
        }
    }, 
    mounted: function(){
        this.$eventHub.$on('requestUpdate', this.populateModalWithData)
    },
    methods:{
        cancelUpdate: function(){

        },
        populateModalWithData: function(task){
            this.taskDATA = task;
        },
        saveChanges: function(){
            this.$eventHub.$emit('taskUpdated', this.taskDATA);
            let patchURI = this.taskUri;
            console.log(patchURI)
            axios.patch(patchURI, {
                'name': this.taskDATA.name
            })
            .then(response => {
                if( response.status === 200){
                   
                }
        
            });
        }
    }
}
</script>
