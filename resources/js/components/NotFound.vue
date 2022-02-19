<template>
<div>
<Navbar/>
	<h1>Oops, it looks like the page you're looking for doesn't exist.</h1>
	<img class="bg"	 src="storage/img/notfound.jpg">
</div>
</template>
<script>
import Navbar from '../components/Navbar';

export default {
    components: {
    Navbar,
     },
}
</script>
