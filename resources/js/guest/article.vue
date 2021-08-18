<template>
    <section id="content-artikel-info" v-if="data.id">
        <div class="container pt-5">
            <div class="row justify-content-center">
                <div class="col-11 text-center mb-4" style="color: #1E6F5C; 2px solid ;">
                  <h4 ><b>{{ data.title }}</b></h4>
                    <p class="border-bottom"><i class="fas fa-edit"></i> {{ data.user.name}} &nbsp; <i class="fas fa-clock"></i> {{ data.createdDate}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card py-3">
                        <div class="card-body">
                            <Carousel v-if="data.article_images.length" :autoplay="3000" :wrap-around="true">
                              <Slide v-for="(images, index) in data.article_images" :key="index"> 
                                <img :src="'../storage/images/articles/'+images.url_image" :alt="images.url_image" /> 
                              </Slide>
                              <template #addons>
                                  <Pagination />
                              </template>
                            </Carousel>

                            <p class="card-text overflow-hidden" v-html="data.bodyHtml"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import guest from '../mixins/guest';
import { Carousel, Navigation, Pagination, Slide } from 'vue3-carousel';
import 'vue3-carousel/dist/carousel.css';

export default {
	
	mixins:[guest],

    components: {
        Carousel,
        Slide,
        Pagination,
        Navigation
    },

    props:['id'],

    computed:{
        endpoint () {
            return `/api/articles/${this.id}`;
        },
    }
    
}
</script>