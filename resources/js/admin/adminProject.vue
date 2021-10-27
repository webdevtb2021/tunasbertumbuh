<template>
    <!-- Content -->
    <section id="project">
        <div class="container mt-2">
            <div>
                <div class="card">
                    <div class="
                            card-header
                            d-flex
                            align-items-center
                            justify-content-between
                        ">
                        <h3>Data Project</h3>
                        <div class="card-tools ml-auto">
                            <div class="input-group input-group-sm">
                                <!-- Button New -->
                                <button type="submit" class="btn btn-success" data-toggle="modal"
                                    data-target="#exampleModal" @click.prevent="showModal">
                                    <i class="fas fa-calendar-plus"></i> Add new
                                    data
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table w-100" id="adminProjectTable" v-if="data">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Created Date</th>
                                    <th>Created By</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(d, index) in data" :key="index">
                                    <td>{{ d.title }}</td>
                                    <td>
                                        {{ d.datetime }}
                                    </td>
                                    <td>{{ d.body }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-link" @click.prevent="editData(d)">
                                            <i class="fas fa-edit text-warning" />
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-link" @click.prevent="deleteData(d.id)">
                                            <i class="fas fa-trash text-danger" />
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Modal containing dynamic form for adding/updating data details. -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <!-- Show/hide headings dynamically based on /isFormCreateMode value (true/false) -->
                                <h5 v-show="isFormCreateMode" class="modal-title" id="exampleModalLabel">
                                    Add new data project
                                </h5>
                                <h5 v-show="!isFormCreateMode" class="modal-title" id="exampleModalLabel">
                                    Update data project
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <!-- Form for adding/updating user details. When submitted call /createData() function if /isFormCreateMode value is true. Otherwise call /updateData() function. -->
                            <form @submit.prevent="
                                    isFormCreateMode
                                        ? createData()
                                        : updateData()
                                ">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input v-model="form.title" type="text" name="title" class="form-control"
                                            placeholder="Title" aria-label="title" aria-describedby="basic-addon1" />
                                    </div>
                                    <div class="form-group">
                                        <label>Created Date</label>
                                        <input v-model="form.datetime" type="text" name="datetime" class="form-control"
                                            placeholder="dd-mm-yyyy" aria-label="datetime"
                                            aria-describedby="basic-addon1" />
                                    </div>
                                    <div class="form-group">
                                        <label>Created By</label>
                                        <textarea v-model="form.body" type="text" name="body" class="form-control"
                                            placeholder="Created By" aria-label="body"
                                            aria-describedby="basic-addon1" />
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                        data-dismiss="modal"
                                    >
                                        Close
                                    </button>
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                        v-show="isFormCreateMode"
                                    >
                                        Save changes
                                    </button>
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                        v-show="!isFormCreateMode"
                                    >
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ./Content -->
</template>

<script>
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import $ from "jquery";

export default {
    data() {
        return {
            data: {},
            form: new Form({
                id: "",
                title: "",
                body: "",
                datetime: "",
            }),
            isFormCreateMode: true,
        };
    },

    computed: {
        endpoint() {
            return `/api/adminproject`;
        },
    },

    mounted() {
        axios.get(this.endpoint).then((response) => {
            this.data = response.data;
            this.$nextTick(function () {
                $("#adminProjectTable").DataTable();
            });
        });
    },

    methods: {
        getData() {
            axios.get(this.endpoint).then((response) => {
                this.data = response.data;
                this.$nextTick(function () {
                    $("#adminProjectTable").DataTable();
                });
            });
        },

        showModal() {
            this.isFormCreateMode = true;
            this.form.reset(); // v form reset
            $("#exampleModal").modal("show");
        },

        createData() {
            this.form
                .post(this.endpoint, {})
                .then(() => {
                    $("#exampleModal").modal("hide");
                    swal.fire({
                        icon: "success",
                        title: "Data keuangan created successfully",
                    });
                    this.getData();
                })
                .catch(() => {
                    console.log("submit failed");
                });
        },

        editData(d) {
            this.isFormCreateMode = false;
            this.form.reset();
            this.form.clear();
            $("#exampleModal").modal("show");
            this.form.fill(d);
        },

        updateData() {
            console.log(this.form.id);
            this.form
                .put(this.endpoint + "/" + this.form.id, {})
                .then(() => {
                    $("#exampleModal").modal("hide");
                    swal.fire({
                        icon: "success",
                        title: "Data keuangan updated successfully",
                    });
                    this.getData();
                })
                .catch(() => {
                    swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!",
                        footer: "Please contact web development team for details",
                    });
                });
        },

        deleteData(id) {
            swal.fire({
                title: "Are you sure?",
                text: "This action will delete data permanently",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.value) {
                    this.form
                        .delete(this.endpoint + "/" + id, {})
                        .then(() => {
                            swal.fire(
                                "Deleted!",
                                "Your data has been deleted",
                                "success"
                            );
                            this.getData();
                        })
                        .catch(() => {
                            swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Something went wrong!",
                                footer: "Please contact web development team for details",
                            });
                        });
                }
            });
        },
    },
};
</script>
