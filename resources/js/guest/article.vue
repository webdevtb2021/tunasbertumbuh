<template>
  <Navbar/>
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
                        <div class="card-body justify-content-center">
                            <p class="card-text overflow-hidden" v-html="data.bodyHtml"></p>
                            <vue-picture-swipe :items="getImagesList()"></vue-picture-swipe> 
                            <br/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import guest from '../mixins/guest';
import Navbar from '../components/Navbar';
export default {
  components: {
    Navbar,},
	
	mixins:[guest],
    props:['id'],
    
    data() {
      return {
        imagesList:[],
      }
    },

    computed:{
        endpoint () {
            return `/api/articles/${this.id}`;
        },
    },

    methods: {
        getImagesList(){
            this.imagesList=[];
            for(let i = 0; i < this.data.article_images.length; i++){
                this.imagesList.push({src: '../storage/images/articles/'+this.data.article_images[i].url_image,thumbnail: '../storage/images/articles/'+this.data.article_images[i].url_image,w: 1200,h: 900
                });
            }
            return this.imagesList;
        }
    },

    
}
</script>