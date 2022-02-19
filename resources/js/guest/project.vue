<template>
<div>
  <Navbar/>
    <section id="content-project-info" v-if="data.id">
        <div class="container pt-5">
            <div class="row justify-content-center">
                <div class="col-11 text-center mb-4" style="color: #1E6F5C; 2px solid ;">
                  <h4 ><b>{{ data.title }}</b></h4>
                    <p class="border-bottom"><i class="fas fa-edit"></i> {{ data.user.name}} &nbsp; <i class="fas fa-clock"></i> {{ data.createdDate}} &nbsp; <i class="fas fa-user-friends"></i> {{ data.volunteers_count + " " + str_plural('volunteer', data.volunteers_count) }} </p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card py-3">
                        <div class="card-body">
                            <img class="card-img-top pb-3" :src="'../storage/images/projects/'+data.image" alt="Card image cap">
                            <p class="card-text overflow-hidden" v-html="data.bodyHtml"></p>
                        </div>
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
    props:['id'],
    computed:{
        endpoint () {
            return `/api/projects/${this.id}`;
        },
    }
    
}
</script>