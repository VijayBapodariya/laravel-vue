<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Task Component <span class="float-right"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">+</button></span></div>
                    <div class="card-body">
                        <input type="search" class="form-control" v-model="search" @keyup="searchRecord" placeholder="search...">
                        <ul class="list-group">
                            <li class="list-group-item" v-for="t in tasks.data" :key_id="t.id">
                                {{ t.id }} - {{ t.name }} <span class="float-right">
                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal" @click="getRecord(t.id)">Edit</button> | 
                                    <button class="btn btn-sm btn-danger" @click="delectRecord(t.id)">Delete</button> | 
                                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#viewModal" @click="getRecord(t.id)">View</button></span>
                            </li>
                        </ul>
                        <pagination :data="tasks" @pagination-change-page="view"></pagination>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal">
            <addTask @recordAdded="refreshRecord"></addTask>
            <editTask :rec="editRec" @recordUpdated="refreshRecord"></editTask>
            <viewTask :view="editRec" ></viewTask>
        </div>
    </div>  
</template>
<script>
Vue.component("addTask", require('./AddModalComponent.vue').default);
Vue.component("editTask", require('./editComponent.vue').default);
Vue.component("viewTask", require('./viewComponent.vue').default);
export default {
    data(){
        return{
            tasks:{},
            editRec:{},
            errors:[],
            rec:{},
            search:'',
        }
    }, 
    created(){
        axios.get('http://localhost:8000/Todo')
        .then((response)=> this.tasks=response.data)
        .catch((error)=>console.log(error));
        console.log("Task Component Mounted");
    },
    methods:{
        view(page = 1) {
            axios.get('http://localhost:8000/Todo?page=' + page)
                .then((response)=>{ this.tasks = response.data})
                .catch((error)=>this.errors=error.response.data.errors);
        },
        refreshRecord(record){
            this.tasks = record.data
        },
        getRecord(id){
            axios.get('http://localhost:8000/Todo/'+id+'/edit')
            .then((response)=>this.tasks = response.data)
            .catch((error)=>this.errors=error.response.data.errors);
        },
        delectRecord(id){
            axios.post('http://localhost:8000/Todo/'+id,{
                '_method':'DELETE',
            })
            .then((response)=>this.refreshRecord(response))
            .catch((error)=>this.errors=error.response.data.errors);
        },searchRecord(){
            if(this.search.length>0){
                axios.get('http://localhost:8000/Todo/search/'+this.search)
                .then((response)=>this.refreshRecord(response))
                .catch((error)=>this.errors=error.response.data.errors);
            }else{
                this.view()
            }
        }
    },
    
}
</script>
<style scoped>

</style>