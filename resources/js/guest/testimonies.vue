<template>
    <div class="container">
    	<h1>Testimonies</h1>
    	{{ data }}
    </div>
</template>

<script>
import guest from '../mixins/guest';

export default {
	
	mixins:[guest],

    computed:{
        endpoint () {
            return `/api/testimonies`;
        },
    }
    
}
</script>