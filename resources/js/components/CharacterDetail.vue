<template>
  <div class="d-flex flex-column justify-content-center align-items-center text-center">
    <div v-if="loading" class="spinner-border" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
    <div v-if="character" class="d-flex flex-column w-50 g-15">
      <h2>{{ character.name }}</h2>
      <img class="w-25 m-auto" :src="character.thumbnail.path + '.' + character.thumbnail.extension" :alt="character.name">
      
      <p>{{ character.description }}</p>
    </div>
    <router-link :to="`/`">Back to Characters</router-link>
  </div>  
</template>


<script>
import axios from 'axios';

export default {
  data() {
    return {
      character: null,
      loading: false,
    }
  },
  props: {
    id: { 
      type: String,
      required: true
    }
  },
  methods: {
    fetchCharacter() {
      this.loading = true; // Start loading
      const characterId = Number(this.id); // Convert the id to a number
      axios.get('/api/characters/' + this.id)
        .then(response => {
          this.character = response.data.data.results[0];
        })
        .catch(error => {
          console.log(error)
        })
        .finally(() => {
          this.loading = false; // Stop loading
        })
    }
  },
  mounted() {
    this.fetchCharacter();
  },  
}
</script>