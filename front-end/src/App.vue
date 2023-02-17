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

      movie_updating: -1,

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
    closeCreateMovie() {
      this.movieCreating = false;
    },
    turnOnUpdateMovie(id) {

      const movie = this.getMovieById(id);
      this.movie_updating = id;

      for (let x = 0; x < this.tags.length; x++) {

        const tag = this.tags[x];
        if (this.isTagPresentInMovie(movie, tag)) {

          this.movie_tags.push(tag.id);
        }
      }

    },
    turnOffUpdateMovie() {

      this.movie_updating = -1;
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

            this.clearForms();
            this.axiosRequest();
          }
        }).catch(err => console.error(err));

    },
    buildMovie() {

      return {

        'name': this.movie_name,
        'year': this.movie_year,
        'cashOut': this.movie_cashOut,
        'genres': this.movie_genre,
        'tags': this.movie_tags,
      };
    },
    clearForms() {
      this.movie_name = '';
      this.movie_year = '';
      this.movie_cashOut = '';
      this.movie_genre = '';
      this.movie_tags = [];

      this.closeCreateMovie();
    }, isTagPresentInMovie(movie, tag) {

      for (let x = 0; x < movie.tags.length; x++) {

        const movieTag = movie.tags[x];

        if (movieTag.id == tag.id) {

          return true;
        }
      }

      return false;
    }, updateMovie(e) {

      e.preventDefault();

      const movie = this.getMovieById(this.movie_updating);
      movie['tags_id'] = this.movie_tags;

      axios.post(this.linkApi + 'movie/update/' + this.movie_updating, movie)
        .then(res => {

          const data = res.data;
          const success = data.success;

          if (success) {

            this.turnOffUpdateMovie();
            this.axiosRequest();
          }
        }).catch(err => console.error(err));
    }, cancelUpdateMovie(e) {

      e.preventDefault();
      this.turnOffUpdateMovie();
    }, cancelUpdateMovie(e) {

      e.preventDefault();
      this.turnOffUpdateMovie();
    },

    deleteClick(id) {

      axios.get(API_URL + 'movie/delete/' + id)
        .then(res => {

          const data = res.data;
          const success = data.success;

          if (success) {

            this.updateMovies();
          }
        })
        .catch(err => console.error(err));
    },

    getMovieIndexById(id) {

      for (let x = 0; x < this.movies.length; x++) {

        const movie = this.movies[x];

        if (movie.id == id)
          return x;
      }

      return null;
    },
    getMovieById(id) {
      return this.movies[this.getMovieIndexById(id)];
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
    <form v-if="movieCreating">
      
      <div>
        <label for="name">Name</label>
        <input type="text" name='name' v-model="movie_name">
      </div>

      <div>
        <label for="year">year</label>
        <input type="number" name='year' v-model="movie_year">
      </div>

      <div>
        <label for="cashOut">cashOut</label>
        <input type="number" name='cashOut' v-model="movie_cashOut">
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
    
    <ul>

      <li v-for="(movie, index) in movies" :key="index">

        {{ movie.name }}  --
        {{ movie.year }}  --
        {{ movie.cashOut }} --  

        <div v-if="movie_updating != movie.id">
          <button @click="deleteMovie(movie.id)">DELETE</button>
          <button @click="turnOnUpdateMovie(movie.id)">EDIT</button>
        </div>

        <form v-else>
          
          <label for="name">Name</label>
            <input type="text" name="name" v-model="movie.name">
            <br>
            <label for="year">Year</label>
            <input type="number" name="year" v-model="movie.year">
            <br>
            <label for="cashOut">Cash out</label>
            <input type="number" name="cashOut" v-model="movie.cashOut">
            <br>
            <label for="genre_id">Genre</label>
            <select name="genre_id" v-model="movie.genre_id">
              <option 
                v-for="genre in genres"
                :key="genre.id"
                :value="genre.id"
                >
                {{ genre.name }}
              </option>
            </select>
            <br>
            <label>Tag</label>
            <br>
            <div 
              v-for="tag in tags"
              :key="tag.id">
              <input 
                @click="updateCheckbox" 
                type="checkbox" 
                :value="tag.id" 
                :id="tag.id" 
                :checked="isTagPresentInMovie(movie, tag)"
                v-model="movie_tags"
                >
              <label :for="tag.id">{{ tag.name }}</label>
              <br>
            </div>
            <button @click="cancelUpdateMovie">CANCEL</button>
            <input @click="updateMovie" type="submit" :value="'UPDATE MOVIE: ' + movie.id">
        </form>
      </li>
    </ul>
  </div>
</template>

<style scoped>

</style>
