<script >
import axios from 'axios'
export default {
  mounted() {
    axios.get('http://127.0.0.1:8000/api/v1/movies')
      .then(res => {
        const data = res.data;
        const movie = data.responde;
        console.log(movie);
      })
      .catch(err => {
        console.error(err);
      })
  },

}
</script>

<template>
  <div>
    hello
  </div>
</template>

<style scoped>

</style>
