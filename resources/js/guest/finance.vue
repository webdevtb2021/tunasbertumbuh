<template>
<div>
  <Navbar/>
    <!-- Content -->
    <section id="finance-report">
        <div class="container pt-5">
            <div class="row justify-content-center">
                <div class="col-11 text-center mb-4" style="color: #1E6F5C; border-bottom: 2px solid ;">
                  <h4 class="fw-bolder"> Laporan Keuangan Tunas Bertumbuh </h4>
                </div>
            </div>
        </div>
        <div
            class="container bg-white pt-3 mt-2"
            style="border: 2px solid rgb(230, 230, 230)"
        >
            <div class="row">
                <div class="col">
                    <table class="table w-100" id="financeTable" v-if="data">
                        <thead>
                            <tr>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Pemasukan</th>
                                <th scope="col">Sumber Pemasukan</th>
                                <th scope="col">Pengeluaran</th>
                                <th scope="col">Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(d, index) in data" :key="index">
                                <td>{{ d.date }}</td>
                                <td>
                                    {{ d.notes }}
                                </td>
                                <td>{{ d.debit }}</td>
                                <td>
                                    {{ d.source }}
                                </td>
                                <td>{{ d.kredit }}</td>
                                <td>{{ d.saldo }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- ./Content -->
</div>
</template>

<script>
import guest from "../mixins/guest";
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import $ from 'jquery'; 
import Navbar from '../components/Navbar';

export default {
  components: {
    Navbar,},
    mixins: [guest],

    computed: {
        endpoint() {
            return `/api/finance`;
        },
    },

    mounted () {
        axios.get(this.endpoint)
        .then((response)=>{
              this.data = response.data;
              $('#financeTable').DataTable();
        })
    },
};
</script>
