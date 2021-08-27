<template>
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
            <div id="org" v-if="data.member">
                <OrgChart :nodess="nodess" :key="nodess"/>
            </div>
        </div>
    </section>
</template>

<script>
import OrgChart from '../components/OrgChart.vue'
import guest from '../mixins/guest';

export default {
    mixins:[guest],
    data: {
        selected: "selected",
    },
    components: {
        OrgChart,
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
                nodesData.push({
                                "id" : this.data.member[i].user_id,
                                "pid" : this.data.member[i].leader,
                                "Tunas Rangers Name" : this.data.member[i].user.name,
                                "Position" : this.data.member[i].jabatan.name +" " + this.data.member[i].division.name,            
                                "img" : this.data.member[i].user.dependences[0].url_image,
                                "Facebook" : this.data.member[i].user.dependences[0].facebook,
                                "Instagram" : this.data.member[i].user.dependences[0].instagram,
                                "Twitter" : this.data.member[i].user.dependences[0].twitter
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

<style>
    #org {
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #2c3e50;
        margin-top: 20px;
    }

    #tree {
        width: 100% ;
        height: 75%;
    }

    .node rect {
        fill: #289672;
    }
</style>