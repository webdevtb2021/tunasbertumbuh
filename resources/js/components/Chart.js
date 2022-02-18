import { OrgChart } from 'd3-org-chart';

export default {
  template: `  <div ref="svgElementContainer" ></div>`,
  name: 'Chart',
  props: ['data'],
  data() {
    return {
      chartReference: null
    };
  },
  watch: {
    data(value) {
      this.renderChart(value);
    }
  },
  mounted() {
      this.renderChart(this.data);
  },
  methods: {
    renderChart(data) {
      if (!this.chartReference) {
        this.chartReference = new OrgChart();
      }
      this.chartReference.container(this.$refs.svgElementContainer)
          .data(data)
          .nodeHeight((d) => 70)
          .nodeWidth((d) => {
              if (d.depth == 0) return 250;
              if (d.depth == 1) return 220;
              return 140;
            })
          .childrenMargin((d) => 50)
          .compactMarginBetween((d) => 35)
          .compactMarginPair((d) => 30)
          .neightbourMargin((a, b) => 20)
          .buttonContent(({ node, state }) => {
            return `<div style="border-radius:3px;padding:3px;font-size:10px;margin:auto auto;background-color:lightgray"> <span style="font-size:9px">${
              node.children
                ? `<i class="fas fa-chevron-up"></i>`
                : `<i class="fas fa-chevron-down"></i>`
            }</span> ${node.data._directSubordinates}  </div>`;
          })
          .nodeContent(function (d, i, arr, state) {
            const colors = ['#278B8D', '#404040', '#0C5C73', '#33C6CB'];
            const color = colors[d.depth % colors.length];
            return `
            <div style="background-color:${color}; position:absolute;margin-top:-1px; margin-left:-1px;width:${d.width}px;height:${d.height}px;border-radius:50px">
               <img src=" ${
                 d.data.imageUrl
               }" style="position:absolute;margin-top:5px;margin-left:${5}px;border-radius:100px;width:60px;height:60px;" />
               <div style="position:absolute;top:-15px;width:${
                 d.width
               }px;text-align:center;color:#fafafa;">
              </div>

              <div style="color:#fafafa;font-size:${
                d.depth < 2 ? 16 : 12
              }px;font-weight:bold;margin-left:70px;margin-top:15px"> ${d.depth < 2 ? d.data.name : (d.data.name || '').trim().split(/\s+/g)[0]} </div>
              <div style="color:#fafafa;margin-left:70px;margin-top:5px"> ${
                d.data.positionName 
              } </div>
           </div>
            `;
          });

        try {
            this.chartReference.render();
        }
        catch(err) {
            swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: err.message,
                footer: 'Please contact web development team for details'
            });
        }
    }
  }
};
