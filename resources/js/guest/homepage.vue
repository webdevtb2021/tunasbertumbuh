<template>
<div>
  <Navbar/>
  <section id="carousel">
    <Carousel :autoplay="3000" :wrap-around="true">
      <Slide v-for="(carouselData, index) in data.carousels" :key="index"> 
        <img :src="carouselData.url_image" :alt="carouselData.title" @click="directToPath(carouselData.redirect_page)" @touchend="directToPath(carouselData.redirect_page)" class="img-fluid" /> 
      </Slide>

      <template #addons>
          <Pagination />
      </template>
    </Carousel>
  </section>

  <!-- Content -->
  <section
    id="content-home"
    style="background-color: #f3f3f3; padding-top: 100px"
  >      
    <!-- Content Juml -->
    <div class="container pb-5">
      <div class="row">
        <div class="col-lg-3">
          <div class="small-box bg-info">
            <div class="inner px-4">
              <h3> {{ data.partnershipCount }}</h3>

              <p>Patner</p>
            </div>
            <div class="icon px-4">
              <i class="fas fa-handshake"></i>
            </div>
            <router-link :to="{ name: 'partnerships' }" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="small-box bg-success">
            <div class="inner px-4">
              <h3> {{ data.donaturCount }} </h3>
              <p>Donations</p>
            </div>
            <div class="icon px-4">
              <i class="fas fa-donate"></i>
            </div>
            <router-link :to="{ name: 'donations' }" class="small-box-footer">Let's donate!<i class="fas fa-arrow-circle-right"></i></router-link>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="small-box bg-danger">
            <div class="inner px-4">
              <h3> {{ data.memberCount }} </h3>

              <p>Members</p>
            </div>
            <div class="icon px-4">
              <i class="fas fa-users"></i>
            </div>
            <router-link :to="{ name: 'members' }" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="small-box bg-secondary">
            <div class="inner px-4">
              <h3> {{ data.volunteerCount }} </h3>

              <p>Volunteer</p>
            </div>
            <div class="icon px-4">
              <i class="fas fa-user-tie"></i>
            </div>
            <router-link :to="{ name: 'volunteers' }" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
          </div>
        </div>
      </div>
    </div>
    <!-- /.Content Juml -->

    <!-- Marchandies & Donatur -->
    <section class="py-5" style="background-color: #1e6f5c">
      <div class="container">
        <div class="row justify-content-between">
          <div class="col-lg">
            <div class="card mb-2 bg-gradient-dark">
              <img
                class="card-img-top rounded"
                src="storage/img/photo1.png"
                alt="Dist Photo 1"
              />
              <div
                class="
                  card-img-overlay
                  d-flex
                  flex-column
                  justify-content-end
                  rounded
                "
              >
                <h5
                  class="card-title text-white py-3"
                  style="font-weight: bold"
                >
                  Our Marchandies
                </h5>
                <p class="card-text text-white pb-2 pt-1">
                  Interested with our marchandies?
                </p>
                <router-link :to="{ name: 'merchandises' }" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
              </div>
            </div>
          </div>
          <div class="col-lg">
            <div class="card mb-2 bg-gradient-dark">
              <img
                class="card-img-top rounded"
                src="storage/img/photo3.jpg"
                alt="Dist Photo 3"
              />
              <div
                class="
                  card-img-overlay
                  d-flex
                  flex-column
                  justify-content-end
                  rounded
                "
              >
                <h5
                  class="card-title text-white py-3"
                  style="font-weight: bold"
                >
                  Halo para donatur diluar sana!
                </h5>
                <p class="card-text text-white pb-2 pt-1">
                  “The catch phrase for the day is, Do an act of kindness.
                  Help one person smile” <br />
                  -Harvey Ball-
                </p>
                <router-link :to="{ name: 'donations' }" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.Marchandies & Donatur -->

    <!-- Direct Chat -->
    <div class="container pt-5">
      <div class="row justify-content-center">
        <div class="col">
          <div class="direct-chat">
            <div class="card-header" style="background-color: #1e6f5c">
              <h3 class="card-title text-white">Testimony</h3>
            </div>
            <div class="card-body">
              <ul class="contacts-list">
                <div v-for="testimoni in data.fiveLatestTestimony">
                    <li>
                        <div class="text-dark py-2">
                            <span class="contacts-list-name">
                                {{ testimoni.user.name }}
                                <small class="contacts-list-date float-right text-dark">
                                    {{ testimoni.createdDate }}
                                </small>
                            </span>
                            <span class="contacts-list-msg text-dark">
                                {{ testimoni.testimony }}
                            </span>
                        </div>                      
                    </li>
                </div>
              </ul>
              
            </div>
            <div class="card-footer">
                <router-link :to="{ name: 'testimonies' }" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
            </div>
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
import { Carousel, Navigation, Pagination, Slide } from 'vue3-carousel';
import 'vue3-carousel/dist/carousel.css';
import Navbar from '../components/Navbar';

export default {
	mixins:[guest],
  components: {
    Navbar,
    Carousel,
    Slide,
    Pagination,
    Navigation
  },
    data() {
        return {
          
        }
    },
    computed:{
        endpoint () {
            return `/api/homepage`;
        },
    },
    methods:{
      directToPath(url){
          window.open(url,"_blank");
      },
    },
    
}
</script>