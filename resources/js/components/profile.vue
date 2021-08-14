<template>
	<div>
		<div class="text-center">
		  <img class="profile-user-img img-fluid img-circle"
		       :src="image"
		       alt="User profile picture">
		</div>
		<a :href="link" target="_blank">
			<h3 class="profile-username text-center">{{ name }}</h3>
		</a>
		<p class="text-muted text-center">{{ desc }}</p>

	</div>
</template>
<script>
export default {
	props:['image','name','desc','link'],
	data(){
		return{
		}
	},

	
}
</script>