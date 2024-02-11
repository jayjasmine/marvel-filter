<template>
  <div class="d-flex flex-column justify-content-center align-items-center">
    <h1>Marvel Characters</h1>
    <search-characters @search="query => fetchCharacters(1, query)"></search-characters>
    <!-- Spinner -->
    <div v-if="loading" class="spinner-border" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
    <div v-if="searchQuery">
      <h4>Characters starting with "{{ searchQuery }}"</h4>
    </div>
    <ul>
      <li v-for="character in characters" :key="character.id">
        <router-link :to="`/characters/${character.id}`">
          {{ character.name }}
        </router-link>
      </li>
    </ul>

    <pagination v-if="totalPages > 0" :total-pages="totalPages" :current-page="currentPage" @page-changed="fetchCharacters"></pagination>
    <div>Page: {{ currentPage }} of {{ totalPages }}</div>
  </div>
</template>

<script>
import axios from 'axios';  
import Pagination from './Pagination.vue'; // Import a pagination component
import SearchCharacters from './SearchCharacters.vue';

export default {
  data() {
    return {
      characters: [],
      currentPage: 1,
      totalPages: 0,
      limit: 20,
      searchQuery: '',
      loading: false,
    }
  },
  components: {
    Pagination,
    SearchCharacters
  },
  methods: {
  // This method will be called when the user clicks on a pagination button
    fetchCharacters(page = 1, search = null) {
      this.loading = true; // Start loading
    // We update the current page
      this.currentPage = page;
      if (search !== null) {
        this.searchQuery = search; // Update only if a new search query is provided
      }

      // Create a unique cache key based on the page number and search query
      const cacheKey = 'characters_page_' + page + '_search_' + this.searchQuery;

      // Check if the data is in local storage
      const cachedData = localStorage.getItem(cacheKey);
      if (cachedData) {
        const parsedData = JSON.parse(cachedData);
        this.characters = parsedData.characters;
        this.totalPages = parsedData.totalPages;
        this.loading = false;
        return; // Data was found in cache, no need to fetch
      }

    // We make a request to the API passing the page number
    axios.get('/api/characters?page=' + page + '&search=' + encodeURIComponent(this.searchQuery))
      // Then we update the characters array and the totalPages variable
      .then(response => {
        // We update the characters array
        this.characters = response.data.data;
        this.limit = response.data.limit;
        // We update the totalPages variable  
        this.totalPages = Math.ceil(response.data.total / this.limit);
          // Store the fetched data along with totalPages in local storage
          const dataToCache = {
          characters: this.characters,
          totalPages: this.totalPages
        };
        localStorage.setItem(cacheKey, JSON.stringify(dataToCache));
      })
      .catch(error => {
        console.log(error)
      })
      .finally(() => {
        this.loading = false; // Stop loading
      });
    }
  },
  // We fetch the characters when the component is mounted
  mounted() {
    // We call the fetchCharacters method
    this.fetchCharacters();
  }
}
</script>

<style>
.spinner {
  text-align: center;
  padding: 20px;
}
</style>