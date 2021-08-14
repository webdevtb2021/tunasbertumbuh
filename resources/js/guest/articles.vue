<template>
    <div class="container">
    	<h1>Articles</h1>
    	{{ data }}
    </div>
</template>

<script>
import guest from '../mixins/guest';

export default {
	
	mixins:[guest],

    data() {
        return {
            page : 1,
        }
    },

    computed:{
        endpoint () {
            return `/api/articles`;
        },
    }
    
}
</script>