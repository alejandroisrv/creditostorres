<template>
  <div>
    <nav class="nav justify-content-center">
      <router-link to="/" class="nav-link">Home</router-link>
      <router-link to="/example" class="nav-link">Example</router-link>
    </nav>
  </div>
</template>
<script>
export default {
  data(){
    return{
      user:"25"
    }
  }
};
</script>
