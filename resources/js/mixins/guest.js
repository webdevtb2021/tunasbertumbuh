export default {
	data() {
        return {
            data:{},
        }
    },
    
    mounted () {
        this.fetchData();
    },

    methods: {
        str_plural (str, count) {
            return str + (count > 1 ? 's' : '')
        },

        fetchData (page) {
            if(page == null){
               axios.get(this.endpoint)
                  .then(({data}) => {
                        this.data = data
                  })
            }
            else{
                this.page = page
                axios.get(this.endpoint, { params: { page : this.page } })
                    .then(({data}) => {
                        this.data.data.push(...data.data)
                        this.data.next_page_url = data.next_page_url
                    })
            }
        },
    },
}