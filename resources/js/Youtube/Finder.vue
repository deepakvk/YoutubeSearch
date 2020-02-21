<script>
  import Search from './Search';

  export default {
    created () {
      let placeholder = this.searchString
      if (placeholder) {
        this.setPlaceHolder(placeholder);
      }
    },
    data () {
      return {
        searchString: '',
        placeholder: ''
      }
    },

    methods: {
      handleFormSubmit() {
        window.eventBus.$emit('searchForYoutubeStarted', this.searchString);

        Search({
          apiKey: 'AIzaSyB_9UoK0EwZG9FGN2amrNXlYKBycMk9rns',
          term: this.searchString,
          items: 10
        }, data => {
          window.eventBus.$emit('searchResultFromYoutube', data);
          this.setPlaceHolder(this.searchString);
          this.searchString = '';
        });
      },
      setPlaceHolder (string) {
        this.placeholder = "Search result for " + string;
      }
    }
  }
</script>

<template>
  <div class="Search__wrapper">
    <div class="container">
      <form v-on:submit.prevent="handleFormSubmit">
        Search: <input
          v-bind:placeholder="placeholder"
          v-model="searchString"
          type="text"
          class="form-control">
      </form>
    </div>
  </div>
</template>

<style lang="scss">
  .Search__wrapper {
    margin-bottom: 10px;
  }
</style>
