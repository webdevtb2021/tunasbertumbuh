<template>
<div>
  <Navbar/>
<section id="content-testimoni">
    <div class="container pt-5">
      <div class="row justify-content-center">
        <div class="col-11 text-center mb-4" style="color: #1E6F5C; border-bottom: 2px solid ;">
          <h4 class="fw-bolder">  The Testimony Tour</h4>
        </div>
    </div>
      <div class="row justify-content-center">
        <div class="col">
          <div class="direct-chat">
            <div class="card-body">
              <ul class="contacts-list">
                <div v-for="testimoni in data.data">
                    <li>
                        <div class="text-dark py-2">
                            <span class="contacts-list-name">
                                {{ testimoni.name }}
                                <small class="contacts-list-date float-right text-dark">
                                    {{ testimoni.dependences[0].createdDate }}
                                </small>
                            </span>
                            <span class="contacts-list-msg text-dark">
                                {{ testimoni.dependences[0].testimony }}
                            </span>
                        </div>                      
                    </li>
                </div>
              </ul>
              
            </div>
            <div v-if="data.next_page_url" class="row justify-content-center">
                <button @click.prevent="fetchData(page+1)" type="button" class="btn-1 px-4"> Load More Previous Testimonies..... </button>
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
    data() {
        return {
            page : 1,
        }
    },

    computed:{
        endpoint () {
            return `/api/testimonies`;
        },
    }
    
}
</script>