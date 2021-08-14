<template>
    <div class="container">
    	<h1>Laporan Keuangan</h1>
    	{{ data }}
    </div>
</template>

<script>
import guest from '../mixins/guest';

export default {
	
	mixins:[guest],

    computed:{
        endpoint () {
            return `/api/finance`;
        },
    }
    
}
</script>