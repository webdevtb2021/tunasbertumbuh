<template>
<div>
  <Navbar/>
<!-- Content -->
<section id="content-artikel">
    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-11 text-center mb-4" style="color: #1E6F5C; border-bottom: 2px solid ;">
              <h4 class="fw-bolder">  Stay Updated Stay Informed with Our Latest and Upcoming Activities </h4>
            </div>
        </div>
        <div v-for="(d,index) in data.data" :key="index"  class="row">
            <div class="col">
                <div class="card py-3 my-2" id="bg-shadow">
                    <div class="card-body">
                        <img v-if="d.article_images.length" class="card-img-top pb-3" :src="'storage/images/articles/'+d.article_images[0].url_image" alt="Card image cap">
                        <h4 ><b>{{ d.title }}</b></h4>
                        <p class="border-bottom"><i class="fas fa-edit"></i> {{ d.user.name}} &nbsp; <i class="fas fa-clock"></i> {{ d.createdDate}} &nbsp; </p>
                        <p class="card-text overflow-hidden" style="height: 70px;"> {{ d.excerpt }} </p>
                        <router-link :to="{ name: 'articles.show', params: { id: d.id } }"  class="btn-1 px-4">See More... </router-link>
                  </div>
                </div>
            </div>
        </div>
        <div v-if="data.next_page_url" class="row justify-content-center">
              <button @click.prevent="fetchData(page+1)" type="button" class="btn-1 px-4"> Load More Previous Articles..... </button>
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
    data() {
        return {
            page : 1,
        }
    },
    computed:{
        endpoint () {
            return `/api/articles`;
        },
    }
    
}
</script>