<script >
import axios from 'axios'
export default {
  data() {
    return {
      linkApi: 'http://127.0.0.1:8000/api/v1/movies',
      movie: '',

    }
  },
  methods: {
    axiosRequest() {
      axios.get(this.linkApi)
        .then(res => {
          const data = res.data;
          this.movie = data.responde;
        })
        .catch(err => {
          console.error(err);
        })
    }
  },
  mounted() {
    this.axiosRequest();
  },

}
</script>

<template>
  <div v-for="(film, index) in movie" :key="index">
    {{ film.name }}--
    {{ film.year }}--
    {{ film.cashOut }}
  </div>
</template>

<style scoped>

</style>
