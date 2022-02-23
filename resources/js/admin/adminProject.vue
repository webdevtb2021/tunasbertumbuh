<template>
<div>
  <Navbar/>
    <div class="container mt-2">
        <div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3>
                        Daftar Proyek
                    </h3>
                    <div class="card-tools ml-auto ">
                        <div class="input-group input-group-sm">
                          <!-- Button New -->
                            <router-link :to="{ name: 'adminproject.show', params: { id: 'create' } ,  query:{isEdit:true } }"  class="btn btn-success">
                                <i class="fas fa-calendar-plus"></i> Add new data
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table w-100" id="adminProjectTable" v-if="projects">
                        <thead>
                            <tr>
                                <th scope="col">Judul</th>
                                <th scope="col">Jumlah Volunteer</th>
                                <th scope="col">Deskripsi</th>
                                <th >Detail</th>
                                <th >Edit</th>
                                <th >Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(d, index) in projects" :key="index">
                                <td>{{ d.title }}</td>
                                <td>{{ d.volunteers_count }}</td>
                                <td>{{ d.excerpt }}</td>
                                <td>
                                    <router-link :to="{ name: 'adminproject.show', params: { id: d.id }, query:{isEdit:false } }"  class="btn btn-sm btn-link">
                                        <i class="fas fa-info-circle text-success"/> 
                                    </router-link>
                                </td>
                                <td>
                                    <router-link :to="{ name: 'adminproject.show', params: { id: d.id },  query:{isEdit:true } }"  class="btn btn-sm btn-link">
                                        <i class="fas fa-edit text-warning"/>
                                    </router-link>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-link" @click.prevent="deleteData(d.id)">
                                        <i class="fas fa-trash  text-danger"/>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
    </div>
</div>
</template>

<script>

import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import $ from 'jquery'; 
import Navbar from '../components/Navbar';
export default {
    components: {
    Navbar,
     },

    data() {
      return {
        projects:{},
        form:{id:'',}
      }
    },

    computed: {
        endpoint() {
            return `/api/adminproject`;
        },
    },

    mounted(){
        axios.get(this.endpoint, {
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            }
        })
        .then((response)=>{
            this.projects = response.data;
            this.$nextTick(function() {
                $('#adminProjectTable').DataTable();
            })
        })
    },

    methods: {
        getData(){
            axios.get(this.endpoint, {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then((response)=>{
                this.projects = response.data;
                this.$nextTick(function() {
                    $('#adminProjectTable').DataTable();
                })
            })
        },
        deleteData(id){
            swal.fire({
                title:'Are you sure?',
                text:'This action will delete data permanently',
                icon:'warning',
                showCancelButton:true,
                confirmButtonColor:'#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if(result.value){
                    axios.delete(this.endpoint + '/' + id, {
                        headers: {
                            'Authorization': 'Bearer ' + localStorage.getItem('token')
                        }
                    })
                    .then(()=>{
                        swal.fire('Deleted!',
                                    'Your data has been deleted',
                                    'success'
                                );
                        this.getData();
                    });
                }
            })
        },
    },  
};

</script>
