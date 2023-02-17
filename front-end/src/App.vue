<script >
import axios from 'axios'
export default {
  data() {
    return {
      linkApi: 'http://localhost:8000/api/v1/',
      movies: [],
      tags: [],
      genres: [],
      movieCreating: false,
      movie_name: '',
      movie_year: '',
      movie_cashOut: '',
      movie_genre: '',
      movie_tags: [],

    }
  },
  methods: {
    axiosRequest() {
      axios.get(this.linkApi + 'movies')
        .then(res => {
          const data = res.data;
          const success = data.success;
          const response = data.response;

          const movies = response.movies;
          const genres = response.genres;
          const tags = response.tags;

          if (success) {

            this.movies = movies;
            this.genres = genres;
            this.tags = tags;
          }
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
    },
    // apertura e chiusura del form di creazione
    openCreateMovie() {
      this.movieCreating = true;
    },

    // store movie
    storeMovie(e) {
      e.preventDefault();

      const movie = this.buildMovie();

      axios.post(this.linkApi + 'movie/store', movie)
        .then(res => {

          const data = res.data;
          const success = data.success;

          if (success) {

            // this.clearForms();
            this.axiosRequest();
          }
        }).catch(err => console.error(err));

    },
    buildMovie() {

      return {

        'name': this.movie_name,
        'year': this.movie_year,
        'cashOut': this.movie_cashOut,
        'genre_id': this.movie_genre,
        'tags_id': this.movie_tags,
      };
    },
  },
  mounted() {
    this.axiosRequest();
  },

}
</script>

<template>
  <div>
    <h1>Movies</h1>
    <form v-if="movieCreating">
      
      <div>
        <label for="name">Name</label>
        <input type="text" name='name' v-model="movie_name">
      </div>

      <div>
        <label for="year">year</label>
        <input type="text" name='year' v-model="movie_year">
      </div>

      <div>
        <label for="cashOut">cashOut</label>
        <input type="text" name='cashOut' v-model="movie_cashOut">
      </div>

      <select name="genres"  v-model="movie_genre">

        <option v-for="genre in genres" :key="genre.id" :value="genre.id"> 
          {{ genre.name }}
        </option>

      </select>



      <div v-for="tag in tags" :key="tag.id">

        <input type="checkbox" :value="tag.id" :id="tag.id" v-model="movie_tags">
        <label :for="tag.id">{{ tag.name }}</label>

      </div>

      <input type="submit" value="CREATE NEW MOVIE" @click="storeMovie">
    </form>
    <button @click="openCreateMovie" v-else>create new element</button>

    <div v-for="(film, index) in movies" :key="index">
      {{ film.name }}--
      {{ film.year }}--
      {{ film.cashOut }}
       <button @click="deleteMovie(film.id)">DELETE</button>
    </div>
  </div>
</template>

<style scoped>

</style>
