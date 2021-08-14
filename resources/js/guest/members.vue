<template>
    <div class="container">
    	<h1>Members</h1>
    	{{ data }}
    </div>
</template>

<script>
import guest from '../mixins/guest';

export default {
	
	mixins:[guest],

    computed:{
        endpoint () {
            return `/api/members`;
        },
    }
    
}
</script>