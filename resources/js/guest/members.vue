<template>
<div>
  <Navbar/>
    <section id="content-team">
        <div class="container pt-5">
            <div class="row justify-content-center">
                <div class="col-11 text-center mb-4" style="color: #1E6F5C; border-bottom: 2px solid ;">
                  <h4 class="fw-bolder">  Meet Our Great Team, Tunas Rangers </h4>
                </div>
            </div>
            <div class="row d-flex justify-content-center col-4 my-auto">
                <h5 class="col-5" style="color: #1E6F5C;">Generation</h5>
                <select v-model="selected" class="form-control select2 col-7" style="width: 100%;" @change="onChange()">
                    <option v-for="gen in data.period" :value="gen.id" :key="gen.id">{{ gen.name }} </option>
                </select>
            </div>
            <br>
            <div id="org" v-if="data.member" 
                style="height: 1200px; background-color: #fffeff">
                <Chart :data="nodess"></Chart>
            </div>
        </div>
    </section>
</div>
</template>

<script>


import Chart from '../components/Chart';
import guest from '../mixins/guest';
import Navbar from '../components/Navbar';

export default {
  components: {
    Navbar,Chart},
    mixins:[guest],
    data: {
        selected: "selected",
    },
    computed:{
        endpoint () {
            return `/api/members`;
        },

        nodess (){
            return this.fetchNodess();
        }
    },

    methods: {
        fetchNodess() {
            let nodesData = [];
            for(let i = 0; i < this.data.member.length; i++){
                let divisi = '';
                if(! this.data.member[i].division === null)
                    divisi = this.data.member[i].division.name;
                nodesData.push({
                                "id" : this.data.member[i].user_id,
                                "parentId" : this.data.member[i].leader,
                                "name" : this.data.member[i].user.name,
                                "positionName" : this.data.member[i].jabatan.name +" " + divisi,            
                                "imageUrl" : '../storage/images/users/'+this.data.member[i].user.dependences[0].url_image,
                                "fb" : this.data.member[i].user.dependences[0].facebook,
                                "ig" : this.data.member[i].user.dependences[0].instagram,
                                "tw" : this.data.member[i].user.dependences[0].twitter
                                });
            }            

            return nodesData;
        },

        onChange(){
            axios.get(this.endpoint+'/'+this.selected)
                    .then(({data}) => {
                        this.data = data
                        this.nodess = this.fetchNodess();
                    });
        },

    },
}
</script>
