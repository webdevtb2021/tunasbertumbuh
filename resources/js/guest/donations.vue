<template>
<div>
  <Navbar/>
    	<section>
  			<div class="container-fluid">
  			  <div class="row">
  			    <div class="col">
  			      <img class="w-100" src="storage/img/header donation web 1.png" alt="banner-donation">
  			    </div>
  			  </div>
  			</div>
		  </section>

    	<!-- Content -->
      <section id="content-donation">
          <div class="container mt-5">
              <div class="row">
                  <div class="col">
                      <div class="card" style="border: 2px solid rgb(230, 230, 230);">
                          <form @submit.prevent="handleSubmit">
                              <div class="row card-body">
                                  <div style="width:100%">                                      
                                      <div class="card" style="border: 2px solid rgb(230, 230, 230);">
                                          <div class="card-header d-flex align-items-center justify-content-start">                                      
                                              <label class="col-4">Silahkan isi data diri Anda : </label>
                                          </div>
                                          <div class="card-body"> 
                                              <!-- Form Data Diri -->
                                              <div class="form-group">
                                                <label for="inputName">Nama</label>
                                                <div class="input-group">
                                                  <input type="text" id="inputName" placeholder="Nama Depan" class="form-control mr-1" required v-model="name1">
                                                  <input type="text" id="inputName" placeholder="Nama Belakang" class="form-control ml-1" v-model="name2">
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                  <label for="inputEmail">Email</label>
                                                  <input type="email" class="form-control" id="inputEmail" placeholder="Email" required v-model="email">
                                              </div>
                                              <div class="form-group">
                                                  <label for="inputPhone">No. Telp</label>
                                                  <input class="form-control" id="inputPhone" type="text" placeholder="Nomor Telepon" v-model="phone">
                                              </div>
                                              <div class="form-group">
                                                  <label for="inputAlamat">Alamat</label>
                                                  <textarea class="form-control" id="inputAlamat" placeholder="Alamat Lengkap" rows="3" v-model="address"></textarea>
                                              </div>
                                              <!-- /.Form Data Diri -->
                                          </div>
                                      </div>
                                  </div>
                                  <div style="width:100%">
                                      <div class="card" style="border: 2px solid rgb(230, 230, 230);">
                                          <div class="card-header d-flex align-items-center justify-content-start">                                      
                                              <label class="col-4">Pilih Kategori Donasi : </label>
                                              <select class="form-control col-4" id="categoryDonasi" v-model="categoryDonasi">
                                                  <option value="1">Uang</option>
                                                  <option value="2">Barang</option>
                                              </select>
                                          </div>
                                          <div class="card-body"> 
                                              <!-- Donasi Uang -->                                     
                                              <div v-if="categoryDonasi==1">
                                                  <div class="form-group pb-2" style="border-bottom: 2px solid rgb(230, 230, 230);">
                                                      <label for="inputNominal">Nominal Uang</label>
                                                      <select class="form-control" id="inputNominalSelect"  v-model="uangNominal">
                                                          <option v-for="n in 10" :value="( n * 10000) + data.nextId">Rp. {{ formatPrice(( n * 10000) + data.nextId) }} </option>
                                                          <option> Lainnya </option>
                                                      </select>
                                                       <input v-if="uangNominal=='Lainnya'" class="form-control mt-2" id="exampleInputPhone1" type="text" placeholder="Jika pilih lainnya harap diisi disini" v-model="uangInputNominal">
                                                      <small class="form-text text-muted">*Harap cantumkan sesuai nominal yang tertera hingga 3 digit terakhir untuk kemudahan verifikasi. </small>
                                                  </div>
                                                  <div class="form-group" style="border-bottom: 2px solid rgb(230, 230, 230);">
                                                      <label for="inputPembayaran">Metode Pembayaran</label>
                                                      <select class="form-control" id="inputPembayaran" v-model="caraBayar">
                                                        <option>BNI</option>
                                                        <option>BCA</option>
                                                        <option>OVO</option>
                                                      </select>
                                                      <div class="row mt-3">
                                                          <div class="col-sm-4 text-center">
                                                            <div class="card">
                                                              <div class="card-body">
                                                                <img class="w-75" src="storage/img/BNI.png" alt="LOGO-BNI">
                                                                <p class="card-text pt-2"><b>0729976440 (BNI)</b><br>Faradila Gilsela Putri</p>
                                                              </div>
                                                            </div>
                                                          </div>
                                                          <div class="col-sm-4 text-center">
                                                              <div class="card">
                                                                <div class="card-body">
                                                                  <img class="w-75" src="storage/img/BCA_png.png" alt="LOGO-BCA">
                                                                  <p class="card-text"><b>2302542539 (BCA)</b><br>Angie Felicia Annabel</p>
                                                                </div>
                                                              </div>
                                                          </div>
                                                          <div class="col-sm-4 text-center">
                                                              <div class="card">
                                                                  <div class="card-body">
                                                                  <img class="w-75" src="storage/img/OVO_png.png" alt="LOGO-OVO">
                                                                  <p class="card-text pt-1"><b>081213634557</b><br>Angie Felicia Annabel</p>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="inputBuktiBayar">Upload Bukti Pembayaran</label>
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
                                                  </div>
                                              </div>
                                              <!-- Donasi Uang -->
                                              <!-- Donasi Barang -->
                                              <div v-if="categoryDonasi==2">
                                                  <div class="form-group pb-3" style="border-bottom: 2px solid rgb(230, 230, 230);">
                                                    <label for="inputJenisBarang">Jenis Barang</label>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="checkbox" value="pakaian" v-model="jenisBarang" >
                                                      <label class="form-check-label">Pakaian</label>
                                                    </div>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="checkbox" value="buku" v-model="jenisBarang">
                                                      <label class="form-check-label">Buku Bacaan</label>
                                                    </div>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="checkbox" value="sepatu" v-model="jenisBarang">
                                                      <label class="form-check-label">Sepatu</label>
                                                    </div>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="checkbox" value="atk" v-model="jenisBarang">
                                                      <label class="form-check-label">Alat Tulis Kantor</label>
                                                    </div>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="checkbox" value="tas" v-model="jenisBarang">
                                                      <label class="form-check-label">Tas</label>
                                                    </div>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="checkbox" value="sembako" v-model="jenisBarang">
                                                      <label class="form-check-label">Sembako</label>
                                                    </div>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="checkbox" value="mainan" v-model="jenisBarang">
                                                      <label class="form-check-label">Mainan Anak</label>
                                                    </div>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="checkbox">
                                                      <label class="form-check-label">Lainnya</label>
                                                    </div>
                                                    <input class="form-control mt-2" id="exampleInputPhone1" type="text" placeholder="Jika pilih lainnya harap diisi disini">
                                                  </div>
                                                  <div class="form-group pb-2" style="border-bottom: 2px solid rgb(230, 230, 230);">
                                                    <label for="inputCatatan">Catatan</label>
                                                    <textarea class="form-control" id="inputCatatan" rows="3" v-model="catatan"></textarea>
                                                    <small class="form-text text-muted">*Mohon lampirkan keterangan mengenai jenis barang dan jumlahnya.</small>
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="inputBuktiBayar">Upload Foto Barang yang didonasikan</label>
                                                      <div class="input-group">
                                                          <el-upload
                                                            action="/"
                                                            list-type="picture-card"
                                                            :limit= 1
                                                            :on-preview="handlePictureCardPreview"
                                                            :auto-upload="false"
                                                            :on-exceed="handleExceed"
                                                          >
                                                            <i class="el-icon-plus"></i>
                                                          </el-upload>
                                                          <el-dialog v-model="dialogVisible">
                                                            <img width="100%" :src="dialogImageUrl" alt="" />
                                                          </el-dialog>
                                                      </div>
                                                      <small id="emailHelp" class="form-text text-muted">*Jenis file harus jpeg, jpg, jpe, png.</small>
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="inputBuktiBayar">Untuk Pengiriman</label>
                                                      <small id="emailHelp" class="form-text text-muted">Nama Penerima : Angie Felicia <br>Nomor Hp : 081213634557 <br> Alamat : Jl. Curug Raya No. 6D, RT 001 RW 008, Kel. Pondok Kelapa, Kec. Duren Sawit, Jakarta Timur</small>
                                                  </div>
                                              </div>
                                              <!-- Donasi Barang -->
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-check mx-3" style="width:100%">
                                      <input type="checkbox" class="form-check-input" id="exampleCheck1" onchange="document.getElementById('submitDonation').disabled = !this.checked;"/>
                                      <label class="form-check-label text-danger" for="exampleCheck1">
                                          Saya telah mengisi data dengan benar
                                      </label>
                                  </div>
                              </div>
                              <div class="card-footer text-center">
                                  <button type="submit" class="btn-1 px-5 mr-3 btn btn-primary" id="submitDonation" disabled>
                                      Submit
                                  </button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </section>
      <!-- /.Content -->
</div>
</template>

<script>
import guest from '../mixins/guest';
import Navbar from '../components/Navbar';

export default {
  components: {
    Navbar,},

    mixins:[guest],

    data(){
        return{
            dialogImageUrl: '',
            dialogVisible: false,
            name1:'',
            name2:'',
            email:'',
            address:'',
            phone:'',
            categoryDonasi:1,
            uangNominal:'',
            uangInputNominal:'',
            caraBayar:'',
            catatan:'',
            jenisBarang:[],
            imageUpload:null


            
        }
    },

    computed:{
        endpoint () {
            return `/api/donationGuest`;
        },
    },


    methods: {
        handlePictureCardPreview(file) {
          this.dialogImageUrl = file.url
          this.dialogVisible = true
          this.imageUpload=file
        },

        updateImage (file) {
          this.imageUpload=file.raw
        },

        handleExceed(){
          this.$message.error("Anda hanya diperbolehkan upload 1 foto bukti");
          return false;
        },

        handleSubmit(){
          const formData = new FormData()
          formData.append('name', this.name1+" "+this.name2)
          formData.append('email', this.email)
          formData.append('phone', this.phone)
          formData.append('address', this.address)

          formData.append('category', this.categoryDonasi)
          if(this.categoryDonasi==1){
              if(this.uangNominal=='Lainnya')
                  formData.append('jenis_jumlah', this.uangInputNominal)
              else                  
                  formData.append('jenis_jumlah', this.uangNominal)
              formData.append('notes', this.caraBayar)
          }
          else{
              formData.append('jenis_jumlah', this.jenisBarang)
              formData.append('notes', this.catatan)
          }
          formData.append('image',this.imageUpload)

          axios.post('../api/donations', formData,{
                headers:{'Content-Type':'multipart/form-data'}
          })
           .then(({ data }) => {
               console.log(data)
           })
           .catch(({ response }) => {
               console.log(response)
           })
        }
    },

}
</script>