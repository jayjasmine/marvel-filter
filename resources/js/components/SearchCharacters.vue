<template>
  <div class="input-group mb-3 w-50">
    <input type="text" class="form-control" v-model="searchQuery" placeholder="Name Starts With..." aria-describedby="basic-addon2">
    <div class="input-group-append">
      <button class="btn btn-outline-secondary" type="button" @click="searchCharacters">Search Characters</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      searchQuery: '',
    }
  },
  emits: ['search'], // Declare the custom event
  methods: {
    searchCharacters() {
      this.$emit('search', this.searchQuery); // Emit the search event with the search query
    }
  }
}
</script>