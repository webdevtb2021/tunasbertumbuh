<template>
    <section id="content-patner">
        <div class="container pt-5">
            <div class="row justify-content-center border bg-white pt-4">
                <div class="col-12 h3 text-center mb-5 border-bottom">
                <label>Our Free Merchandises</label>
                </div> 
                <div class="row d-flex justify-content-end">
                <div v-for="(d,index) in data" :key="index" class="col-lg-3">
                    <button class="btn btn-default card mr-auto ml-auto w-75 h-100" data-toggle="modal" data-target="#modal-lg-f1" v-if="d.id">
                        <img class="card-img-top" :src="'storage/images/merchandises/'+d.image" alt="Card image cap" />
                        <div class="card-body">
                        <h5 class="card-title"><b>{{ d.title}}</b></h5>
                        </div>
                    </button>
                </div>
            </div>
            </div>
        </div>

        <div class="container pt-5">
            <div class="row justify-content-center border bg-white pt-4">
                <div class="col-12 h3 text-center mb-5 border-bottom">
                <label>Our Premium Merchandises</label>
                </div> 
                <div class="row d-flex justify-content-end">
                <div v-for="(d,index) in data" :key="index" class="col-lg-3">
                <button class="btn btn-default card mr-auto ml-auto w-75 h-100" data-toggle="modal" data-target="#modal-lg-f">
                    <img class="card-img-top" :src="'storage/images/merchandises/'+d.image" alt="Card image cap" />
                    <div class="card-body">
                    <h5 class="card-title"><b>{{ d.title}}</b></h5>
                    </div>
                </button>
                </div>
            </div>
            </div>
        </div>

        <!-- Modal -->
        <!-- Modal Free Marchandies -->
        <div class="modal fade" id="modal-lg-f">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">Nama Marchandies</h4>
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
                            <h3 class="d-inline-block d-sm-none">
                            LOWA Men’s Renegade GTX Mid Hiking Boots Review
                            </h3>
                            <div class="col-12">
                            <img
                                src="storage/img/prod-1.jpg"
                                class="product-image"
                                alt="Product Image"
                            />
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <h3 class="my-3">
                            Lorem ipsum, dolor sit amet consectetur adipisicing
                            elit.
                            </h3>
                            <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Nostrum, vel dolores? Ipsam dolore saepe aperiam
                            aliquam exercitationem omnis possimus. Rem voluptates
                            labore ipsum odio illum neque. Perspiciatis illum id
                            dignissimos!
                            </p>
                            <hr />
                            <h4 class="mt-3">
                            Size <small>Please select one</small>
                            </h4>
                            <div
                            class="btn-group btn-group-toggle"
                            data-toggle="buttons"
                            >
                            <label class="btn btn-default text-center">
                                <input
                                type="radio"
                                name="color_option"
                                id="color_option_b1"
                                autocomplete="off"
                                />
                                <span class="text-xl">S</span>
                                <br />
                                Small
                            </label>
                            <label class="btn btn-default text-center">
                                <input
                                type="radio"
                                name="color_option"
                                id="color_option_b2"
                                autocomplete="off"
                                />
                                <span class="text-xl">M</span>
                                <br />
                                Medium
                            </label>
                            <label class="btn btn-default text-center">
                                <input
                                type="radio"
                                name="color_option"
                                id="color_option_b3"
                                autocomplete="off"
                                />
                                <span class="text-xl">L</span>
                                <br />
                                Large
                            </label>
                            <label class="btn btn-default text-center">
                                <input
                                type="radio"
                                name="color_option"
                                id="color_option_b4"
                                autocomplete="off"
                                />
                                <span class="text-xl">XL</span>
                                <br />
                                Xtra-Large
                            </label>
                            </div>

                            <div
                            class="bg-gray py-2 px-3 mt-4"
                            style="border-radius: 7px"
                            >
                            <h4 class="mb-0">Rp. 80.000</h4>
                            </div>

                            <div class="mt-4">
                            <div class="btn btn-primary btn-lg btn-flat">
                                <i class="fas fa-cart-plus fa-lg mr-2"></i>
                                Add to Cart
                            </div>

                            <div class="btn btn-default btn-lg btn-flat">
                                <i class="fas fa-heart fa-lg mr-2"></i>
                                Add to Wishlist
                            </div>
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
        <!-- ./Modal Free Marchandies -->
    </section>
</template>

<script>
import guest from '../mixins/guest';

export default {
	
	mixins:[guest],

    computed:{
        endpoint () {
            return `/api/merchandises`;
        },
    }
    
}
</script>