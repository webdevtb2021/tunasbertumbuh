<template>
    <div class="container">
    	<h1>Projects</h1>
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
            return `/api/projects`;
        },
    }
    
}
</script>