<template>
    <!-- Content -->
    <section id="donation-data">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <section class="content">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-header mb-3">List Project</h4>
                                <div class="card-tools ml-auto">
                                    <div class="input-group input-group-sm">
                                        <!-- Button New -->
                                        <button
                                            type="submit"
                                            class="btn btn-success"
                                            data-toggle="modal"
                                            data-target="#exampleModal"
                                            @click.prevent="showModal"
                                        >
                                            <i class="fas fa-calendar-plus"></i>
                                            Add new data
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body p-0">
                                <table
                                    class="table w-100"
                                    id="adminProjectTable"
                                    v-if="data"
                                >
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Created Date</th>
                                            <th>Created By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(d, index) in data"
                                            :key="index"
                                        >
                                            <td>Title A</td>
                                            <td>Created Date A</td>
                                            <td>Created By A</td>
                                            <td
                                                class="
                                                    project-actions
                                                    text-right
                                                "
                                            >
                                                <a
                                                    class="
                                                        btn btn-primary btn-sm
                                                    "
                                                    data-toggle="modal"
                                                    data-target="#exampleModal1"
                                                >
                                                    <i class="fas fa-folder">
                                                    </i>
                                                    View
                                                </a>
                                                <a
                                                    class="btn btn-info btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#exampleModalEdit1"
                                                    href="#"
                                                >
                                                    <i
                                                        class="
                                                            fas
                                                            fa-pencil-alt
                                                        "
                                                    >
                                                    </i>
                                                    Edit
                                                </a>
                                                <a
                                                    class="
                                                        btn btn-danger btn-sm
                                                    "
                                                    data-toggle="modal"
                                                    data-target="#exampleModalDelete"
                                                    href="#"
                                                >
                                                    <i class="fas fa-trash">
                                                    </i>
                                                    Delete
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
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
                date: "",
                notes: "",
                debit: "",
                source: "",
                kredit: "",
                saldo: "",
            }),
            isFormCreateMode: true,
        };
    },
    computed: {
        endpoint() {
            return `/api/adminfinance`;
        },
    },
    mounted() {
        axios.get(this.endpoint).then((response) => {
            this.data = response.data;
            this.$nextTick(function () {
                $("#adminFinanceTable").DataTable();
            });
        });
    },
    methods: {
        getData() {
            axios.get(this.endpoint).then((response) => {
                this.data = response.data;
                this.$nextTick(function () {
                    $("#adminFinanceTable").DataTable();
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
