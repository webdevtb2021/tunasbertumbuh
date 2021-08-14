<template>
    <div class="container">
    	<h1>Project</h1>
    	{{ data }}
    </div>
</template>

<script>
import guest from '../mixins/guest';

export default {
	
	mixins:[guest],

    props:['id'],

    computed:{
        endpoint () {
            return `/api/projects/${this.id}`;
        },
    }
    
}
</script>