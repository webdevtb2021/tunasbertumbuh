<template>
    
<!-- Content -->
<section id="content-project">
    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-11 text-center mb-4" style="color: #1E6F5C; border-bottom: 2px solid ;">
              <h4 class="fw-bolder">  Take a Look Our Wonderful Projects </h4>
            </div>
        </div>
        <div v-for="(d,index) in data.data" :key="index"  class="row">
            <div class="col">
                <div class="card py-3">
                    <div class="card-body" v-if="d.id">
                        <img class="card-img-top pb-3" :src="'storage/images/projects/'+d.image" alt="Card image cap">
                        <h4 ><b>{{ d.title }}</b></h4>
                        <p class="border-bottom"><i class="fas fa-edit"></i> {{ d.user.name}} &nbsp; <i class="fas fa-clock"></i> {{ d.createdDate}} &nbsp; <i class="fas fa-user-friends"></i> {{ d.volunteers_count + " " + str_plural('volunteer', d.volunteers_count) }} </p>
                        <p class="card-text overflow-hidden" style="height: 70px;"> {{ d.excerpt }} </p>
                        <router-link :to="{ name: 'projects.show', params: { id: d.id } }"  class="btn-1 px-4">See More... </router-link>
                  </div>
                </div>
            </div>
        </div>
        <div v-if="data.next_page_url" class="row justify-content-center">
              <button @click.prevent="fetchData(page+1)" type="button" class="btn-1 px-4"> Load More Previous Projects..... </button>
        </div>
    </div>
</section>
<!-- /.Content -->

</template>

<script>
import guest from '../mixins/guest';

export default {
	
	mixins:[guest],

    data() {
        return {
            page : 1,
        }
    },

    computed:{
        endpoint () {
            return `/api/projects`;
        },
    }
    
}
</script>