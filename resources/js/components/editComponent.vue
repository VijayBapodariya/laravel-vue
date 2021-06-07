<template>
    <div class="modal fade" id="editModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Record</h5>
                        <button type="button" class="close" @click="clearModal" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <p class="alert alert-success" v-if="success.length > 0">{{ success }}</p>
                    <label for="name">Add Name</label>
                    <input type="text" name="name" id="name" class="form-control" v-model="rec.name">
                    <ul v-if="errors" class="list-unstyled">
                        <li v-for="err of errors.name" class="alert alert-danger">{{err}}</li>
                    </ul> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="clearModal" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="updaterecord">Update</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
export default {
    props:['rec'],
    data(){
        return{
            success:'',
            errors:[],
        }
    },
    methods: {
        updaterecord(){ 
            axios.post('http://localhost:8000/Todo/'+this.rec.id,{
                'name':this.rec.name,
                '_method':'PUT',
            })
            .then(data=>{
                this.$emit('recordUpdated',data);
                this.success="Your record SuccessFully Updated";
                this.record='';
                this.error = [];
            })
            .catch(error=>{
                this.errors=error.response.data.errors;
            })
        },
        clearModal(){
            this.errors = [];
            this.success='';
        }
    }
}
</script>
<style scoped>

</style>