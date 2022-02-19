<template>
<div>
  <Navbar/>
    <section id="content-free-march">
        <div class="container bg-white pb-5 mt-5">
            <div class="row justify-content-center bg-white pt-4">
                <div class="col-12 h3 text-center mb-5 border-bottom">
                    <label>Our Free Merchandises</label>
                </div> 
                <div class="row d-flex justify-content-around">
                    <div v-for="(d,index) in data.free" :key="index" class="col-lg-3">
                        <button class="card mr-auto ml-auto w-75 h-90 btn btn-default" data-toggle="modal" :data-target="'#modal-lg-f'+index" v-if="d.id">
                            <img class="card-img-top" :src="'storage/images/merchandises/'+d.image" alt="Card image cap" />
                            <div class="card-body">
                                <h5 class="card-title"><b>{{ d.title}}</b></h5>
                            </div>
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" :id="'modal-lg-f'+index" v-if="d.id">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h4 class="modal-title">Premium Merchandise</h4>
                                    <button
                                        type="button"
                                        class="close"
                                        data-dismiss="modal"
                                        aria-label="Close"
                                    >
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <section class="content">
                                            <!-- Default box -->
                                            <div class="card card-solid">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-6">
                                                            <div class="col-12">
                                                            <img
                                                                :src="'storage/images/merchandises/'+d.image" 
                                                                class="product-image"
                                                                alt="Product Image"
                                                            />
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <h3 class="my-3">
                                                            {{ d.title}}
                                                            </h3>
                                                            <p>
                                                            {{ d.description}}
                                                            </p>
                                                            <hr />

                                                            <div
                                                            class="bg-gray py-2 px-3 mt-4"
                                                            style="border-radius: 7px"
                                                            >
                                                                <h4 class="mb-0">Rp. {{ formatPrice(d.price) }}</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <!-- /.card -->
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ./Modal -->
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container bg-white pb-5 mt-5">
            <div class="row justify-content-center bg-white pt-4">
                <div class="col-12 h3 text-center mb-5 border-bottom">
                    <label>Our Premium Merchandises</label>
                </div> 
                <div class="row d-flex justify-content-around">
                    <div v-for="(d,index) in data.premium" :key="index" class="col-lg-3">
                        <button class="card mr-auto ml-auto w-75 h-90 btn btn-default" data-toggle="modal" :data-target="'#modal-lg-p'+index" v-if="d.id">
                            <img class="card-img-top" :src="'storage/images/merchandises/'+d.image" alt="Card image cap" />
                            <div class="card-body">
                                <h5 class="card-title"><b>{{ d.title}}</b></h5>
                            </div>
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" :id="'modal-lg-p'+index" v-if="d.id">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h4 class="modal-title">Premium Merchandise</h4>
                                    <button
                                        type="button"
                                        class="close"
                                        data-dismiss="modal"
                                        aria-label="Close"
                                    >
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <section class="content">
                                            <!-- Default box -->
                                            <div class="card card-solid">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-6">
                                                            <div class="col-12">
                                                            <img
                                                                :src="'storage/images/merchandises/'+d.image" 
                                                                class="product-image"
                                                                alt="Product Image"
                                                            />
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <h3 class="my-3">
                                                            {{ d.title}}
                                                            </h3>
                                                            <p>
                                                            {{ d.description}}
                                                            </p>
                                                            <hr />

                                                            <div
                                                            class="bg-gray py-2 px-3 mt-4"
                                                            style="border-radius: 7px"
                                                            >
                                                                <h4 class="mb-0">Rp. {{ formatPrice(d.price) }}</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <!-- /.card -->
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ./Modal -->
                    </div>
                </div>
            </div>
        </div>

        
    </section>
</div>
</template>

<script>
import guest from '../mixins/guest';
import Navbar from '../components/Navbar';

export default {
  components: {
    Navbar,},
	
	mixins:[guest],

    computed:{
        endpoint () {
            return `/api/merchandises`;
        },
    }
    
}
</script>