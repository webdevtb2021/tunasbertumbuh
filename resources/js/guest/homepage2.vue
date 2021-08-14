<template>
    <div>


<section id="carousel">
  <vueper-slides @ready="$refs.myvueperslides.goToSlide(0)"
 autoplay ref="myvueperslides" fixed-height="300px" >
    <vueper-slide
      v-for="(slide, i) in slides"
      :key="i"
      :image="slide.image"
      :link="slide.link" />
  </vueper-slides>
</section>




      <!-- Content -->
      <section
        id="content-home"
        class="pb-5"
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
                <a href="patnership.html" class="small-box-footer">
                  More info <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <div class="col-lg-3">
              <div class="small-box bg-success">
                <div class="inner px-4">
                  <h3> {{ data.donaturCount }} </h3>

                  <p>Donators</p>
                </div>
                <div class="icon px-4">
                  <i class="fas fa-donate"></i>
                </div>
                <a href="donation.html" class="small-box-footer">
                  More info <i class="fas fa-arrow-circle-right"></i>
                </a>
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
                <a href="team.html" class="small-box-footer">
                  More info <i class="fas fa-arrow-circle-right"></i>
                </a>
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
                <a href="open_req.html" class="small-box-footer">
                  More info <i class="fas fa-arrow-circle-right"></i>
                </a>
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
                    <a href="marchandies.html" class="text-white text-center">
                      More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-lg">
                <div class="card mb-2 bg-gradient-dark">
                  <img
                    class="card-img-top rounded"
                    src="storage/img/photo3.jpg"
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
                      Halo para donatur diluar sana!
                    </h5>
                    <p class="card-text text-white pb-2 pt-1">
                      “The catch phrase for the day is, Do an act of kindness.
                      Help one person smile” <br />
                      -Harvey Ball-
                    </p>
                    <a href="marchandies.html" class="text-white text-center">
                      More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
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
                    <a href="testimonies.html" class="text-dark text-center">
                      <strong> More testimonies.. <i class="fas fa-arrow-circle-right"></i> </strong>
                    </a>
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
import { VueperSlides, VueperSlide } from 'vueperslides'
import 'vueperslides/dist/vueperslides.css'

export default {
	components: { VueperSlides, VueperSlide },
	mixins:[guest],

    data() {
        return {
          
        }
    },

    computed:{
        endpoint () {
            return `/api/homepage`;
        },

        slides(){
          let slidesData = [];
          for(var index in this.data.carousels)
            slidesData.push(
                            {
                            "image":this.data.carousels[index]['url_image'],
                            "link":this.data.carousels[index]['redirect_page']
                            }
            );
          return slidesData;
        },
    },


    methods:{
    },
    
}
</script>