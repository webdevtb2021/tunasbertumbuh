<template>
    <div class="card d-flex flex-fill">
      <div class="card-header text-muted border-bottom-0">
        {{ header }}
      </div>
      <div class="card-body pt-0">
        <div class="row">
          <div class="col-7">
            <h2 class="lead"><b> {{ name }}</b></h2>
            <p class="text-muted text-sm"><b>Kategori : </b> {{category}} </p>
            <p class="text-muted text-sm"><b>Notes : </b> {{notes}} </p>
            <ul class="ml-4 mb-0 fa-ul text-muted">
              <!--<li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: Demo Street 123, Demo City 04312, NJ</li>-->
              <li class="small"><span class="fa-li"><i class="fab fa-instagram"></i></span> {{ ig }}</li>
            </ul>
          </div>
          <div class="col-5 text-center">
            <img :src="image" alt="user-avatar" class="img-circle img-fluid">
          </div>
        </div>
      </div>
      <!--
      <div class="card-footer">
        <div class="text-right">
          <a href="#" class="btn btn-sm bg-teal">
            <i class="fas fa-comments"></i>
          </a>
          <a href="#" class="btn btn-sm btn-primary">
            <i class="fas fa-user"></i> View Profile
          </a>
        </div>
      </div>
      -->
    </div>
</template>
<script>
export default {
  props:['header','name','category','notes','ig','image'],
  data(){
    return{
    }
  },

  
}
</script>