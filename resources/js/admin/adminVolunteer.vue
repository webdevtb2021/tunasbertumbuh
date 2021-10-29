<template>

    <div class="container mt-2">
        <div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 >Data Volunteer</h3>
                    <div class="card-tools ml-auto ">
                        <div class="input-group input-group-sm">
                          <!-- Button New -->
                          <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" @click.prevent="showModal"><i class="fas fa-calendar-plus"></i> Add new data</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table w-100" id="adminVolunteerTable" v-if="data">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">URL</th>
                                <th scope="col">Status</th>
                                <th scope="col">Note</th>
                                <th scope="col">Project</th>
                                <th ></th>
                                <th ></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(d, index) in data" :key="index">
                                <td>
                                    <div class="col-md-2 px-4" style="border-radius: 7px;">
                                        <profile :image="'storage/app/images/volunteers/0eaf56e0338386c4f25f5c77325021dd.png'"></profile>
                                    </div>
                                    {{ d.name }}
                                </td>
                                <td>{{ d.url }}</td>
                                <td>{{ d.status }}</td>
                                <td>{{ d.notes }}</td>
                                <td>{{ d.project_id }}</td>
                                <td>
                                    <button class="btn btn-sm btn-link" @click.prevent="editData(d)">
                                        <i class="fas fa-edit text-warning"/>
                                    </button>
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
            <!-- Modal containing dynamic form for adding/updating data details. -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <!-- Show/hide headings dynamically based on /isFormCreateMode value (true/false) -->
                    <h5 v-show="isFormCreateMode" class="modal-title" id="exampleModalLabel">Add new data Volunteer</h5>
                    <h5 v-show="!isFormCreateMode" class="modal-title" id="exampleModalLabel">Update data Volunteer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <!-- Form for adding/updating user details. When submitted call /createData() function if /isFormCreateMode value is true. Otherwise call /updateData() function. -->
                  <form @submit.prevent="isFormCreateMode ? createData() : updateData()">
                    <div class="modal-body">
                        <!-- <div class="form-group">
                            <label for="inputPhoto">Upload Foto Profile</label>
                            <div class="input-group">
                                <el-upload
                                    action="/"
                                    list-type="picture-card"
                                    :limit= 1
                                    :on-preview="handlePictureCardPreview"
                                    :auto-upload="false"
                                    :on-exceed="handleExceed"
                                    :on-change="updateImage"
                                    >
                                    <i class="el-icon-plus"></i>
                                </el-upload>
                                <el-dialog v-model="dialogVisible">
                                    <img width="100%" :src="dialogImageUrl" alt="" />
                                </el-dialog>
                            </div>
                            <small id="emailHelp" class="form-text text-muted">*Jenis file harus jpeg, jpg, jpe, png.</small>
                        </div> -->
                        <div class="form-group">
                            <label>Name</label>
                            <input v-model="form.name" type="text" name="name" class="form-control" placeholder="Name" aria-label="name" aria-describedby="basic-addon1"/>
                        </div>
                        <div class="form-group">
                            <label>URL</label>
                            <input v-model="form.url" type="text" name="url" class="form-control" placeholder="URL" aria-label="url" aria-describedby="basic-addon1"/>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" id="status">
                                <option value="1">Nonktif</option>
                                <option value="2">Aktif</option>
                            </select>
                            <!-- <input v-model="form.status" type="number" name="status" class="form-control" placeholder="Status" aria-label="status" aria-describedby="basic-addon1"/> -->
                        </div>
                        <div class="form-group">
                          <label>Notes</label>
                          <input v-model="form.notes" type="text" name="notes" class="form-control" placeholder="Notes" aria-label="notes" aria-describedby="basic-addon1"/>
                        </div>
                        <div class="form-group">
                          <label>Project</label>
                            <!-- <select class='form-control' v-model='project'>
                                <option value='0' >Select Project</option>
                                <option v-for='data in projects' :value='data.id'>{{ data.name }}</option>
                            </select> -->
                          <input v-model="form.project_id" type="number" name="project_id" class="form-control" placeholder="Project" aria-label="project_id" aria-describedby="basic-addon1"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary" v-show="isFormCreateMode">Save changes</button>
                      <button type="submit" class="btn btn-primary" v-show="!isFormCreateMode">Update</button>
                    </div>
                  </form>
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

export default {

    data() {
      return {
        // project: 0,
        // projects: [],
        data:{},
        form: new Form({
          id:'',
          name: '',
          image: '',
          url: '',
          status: '',
          notes: '',
          project_id: ''
        }),
        isFormCreateMode: true
      }
    },

    computed: {
        endpoint() {
            return `/api/adminvolunteer`;
        },
    },

    mounted(){
        axios.get(this.endpoint)
        .then((response)=>{
            this.data = response.data;
            this.$nextTick(function() {
                $('#adminVolunteerTable').DataTable();
            })
        })
    },

    methods: {
        // getProject: function(){
        //     axios.get('/get_project')
        //         .then(function (response) {
        //             this.projects = response.data;
        //         }.bind(this));
        // },

        getData() {
            axios.get(this.endpoint)
            .then((response)=>{
                this.data = response.data;
                this.$nextTick(function() {
                    $('#adminVolunteerTable').DataTable();
                })
            })
        },

        showModal() {
            this.isFormCreateMode = true;
            this.form.reset(); // v form reset
            $('#exampleModal').modal('show'); 
        },

        createData(){
            this.form.post(this.endpoint,{})
            .then(()=>{
                $('#exampleModal').modal('hide');
                swal.fire({
                    icon:'success',
                    title:'Data volunteer created successfully'
                })
                this.getData();
            }).catch(()=>{
                console.log('submit failed');
            });
        },

        editData(d){
            this.isFormCreateMode=false;
            this.form.reset();
            this.form.clear();
            $('#exampleModal').modal('show'); 
            this.form.fill(d);
        },

        updateData(){
            console.log(this.form.id)
            this.form.put(this.endpoint + '/' + this.form.id,{})
            .then(()=>{
                $('#exampleModal').modal('hide');
                swal.fire({
                    icon:'success',
                    title:'Data volunteer updated successfully'
                })
                this.getData();
            }).catch(()=>{
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please contact web development team for details'
                });
            });
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
                    this.form.delete(this.endpoint + '/' + id,{})
                    .then(()=>{
                        swal.fire('Deleted!',
                                    'Your data has been deleted',
                                    'success'
                                );
                        this.getData();
                    }).catch(()=>{
                        swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            footer: 'Please contact web development team for details'
                        });
                    });
                }
            })
        },
    },  
};

</script>
