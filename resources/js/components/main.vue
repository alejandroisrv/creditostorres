<template>
  <div>
    <navbar></navbar>
    <div class="container" style="margin-top: 2rem">
      <router-view></router-view>
    </div>
  </div>
</template>
<script>
import navbar from './navbar'
export default {

    data(){
        return {

            title:''
        }
    },
    components:{
        navbar
    }
}
</script>
