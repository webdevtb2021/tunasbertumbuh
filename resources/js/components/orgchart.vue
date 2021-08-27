<template>
    <div v-if="nodes">
        <div id="tree" ref="tree"></div>        
    </div>
</template>

<script>

    import OrgChart from '@balkangraph/orgchart.js'

    export default {

        name: 'tree',
        props:['nodess'],
        data() {
            return {
                nodes : this.nodess,
            }
        },

        methods: {
            oc: function(domEl, x) {
              this.chart = new OrgChart(domEl, {
                nodes: x,
                nodeBinding: {
                    field_0: "Tunas Rangers Name",
                    field_1: "Position",
                    field_2: "Instagram",
                    field_3: "Facebook",
                    field_4: "Twitter",
                    img_0: "img"
                },
              });
            },
      },

      mounted(){
        this.oc(this.$refs.tree, this.nodes)
      },
    }
</script>

<style scoped>
</style>