<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Example Component</div>

          <div class="card-body">
            <small>{{ parametro }}</small>
            <pre>
                {{ response }}
            </pre>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      parametro: this.$route.params.id,
      response: ""
    };
  },
  created(){
      this.rg();
  },
  methods: {
    rg() {
        axios.get('api/example/123').then(rs=> {
            this.response = rs.data           
        });
    }
  },
  mounted() {
    console.log("Component mounted.");
  }
};
</script>
