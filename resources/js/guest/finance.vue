<template>
    <!-- Content -->
    <section id="finance-report">
        <div
            class="container bg-white pt-3 mt-5"
            style="border: 2px solid rgb(230, 230, 230)"
        >
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label>Tanggal:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input
                                type="text"
                                class="form-control float-right"
                                id="reservation"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <table class="table w-100">
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
                        <tbody v-for="(d, index) in data.data" :key="index">
                            <tr>
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
</template>

<script>
import guest from "../mixins/guest";

export default {
    mixins: [guest],

    computed: {
        endpoint() {
            return `/api/finance`;
        },
    },
};
</script>
