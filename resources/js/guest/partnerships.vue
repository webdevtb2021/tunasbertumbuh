<template>
<section id="content-patner">
    <div class="container pt-5">
        <div class="row justify-content-center border bg-white pt-4">
            <div class="col-12 h3 text-center mb-5 border-bottom">
                        <label>Our Patnerships</label>
                    </div> 
        	<div v-for="(d,index) in data" :key="index" class="col-md-2 px-4" style="border-radius: 7px;">
                <profile :image="'storage/images/partnerships/'+d.image" :name="d.name" :link="d.url"></profile>
            </div>
        </div>
    </div>
</section>
</template>

<script>
import guest from '../mixins/guest';
import profile from '../components/profile.vue'

export default {
	
	mixins:[guest],

    components:{profile},

    computed:{
        endpoint () {
            return `/api/partnerships`;
        },
    }
    
}
</script>