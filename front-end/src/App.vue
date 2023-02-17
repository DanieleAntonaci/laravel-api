<script >
import axios from 'axios'
export default {
  data() {
    return {
      linkApi: 'http://localhost:8000/api/v1/',
      movie: '',

    }
  },
  methods: {
    axiosRequest() {
      axios.get(this.linkApi + 'movies')
        .then(res => {
          const data = res.data;
          this.movie = data.responde;
        })
        .catch(err => {
          console.error(err);
        })
    },
    deleteMovie(index) {
      axios.get(this.linkApi + 'movie/delete/' + index)
        .then(res => {
          const data = res.data;
          const success = data.success;

          if (success) {
            console.log('delete');
            this.axiosRequest();
          }
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
  <div>
    <h1>Movies</h1>
    <div v-for="(film, index) in movie" :key="index">
      {{ film.name }}--
      {{ film.year }}--
      {{ film.cashOut }}
       <button @click="deleteMovie(film.id)">DELETE</button>
    </div>
  </div>
</template>

<style scoped>

</style>
