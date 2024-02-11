<template>
  <div class="mb-3">
    <button class="btn btn-secondary mx-1" v-if="currentPage > 1" @click="changePage(currentPage - 1)">Previous</button>
    <button class="btn btn-secondary mx-1" v-if="currentPage < totalPages" @click="changePage(currentPage + 1)">Next</button>
  </div>
</template>

<script>
// We import the event bus
export default {
  // We define the props
  props: {
    totalPages: Number,
    currentPage: Number,
  },
  mounted() {
    console.log('Pagination: ' + 'total ' + this.totalPages + ' currentPage ' + this.currentPage)
  },
  // We define the methods
  methods: {
    // This method will be called when the user clicks on a pagination button
    changePage(page) {
      console.log(page)
      // We emit the page-changed event and pass the page number as a parameter
      this.$emit('page-changed', page)
    }
  }
}

</script>