<template>
    <div class="container">
    	<h1>Open Recruitment</h1>
    	{{ data }}
    </div>
</template>

<script>
import guest from '../mixins/guest';

export default {
	
	mixins:[guest],

    computed:{
        endpoint () {
            return `/api/recruitments`;
        },
    }
    
}
</script>