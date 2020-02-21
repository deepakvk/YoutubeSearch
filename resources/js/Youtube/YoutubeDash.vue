<template>
  <div class="YoutubeDash__wrapper">
    <finder></finder>

    <div v-if="!loading">
      <video-group :videos="videos"></video-group>
    </div>

    <div v-if="loading">Loading...</div>

  </div>
</template>

<script>
  import VideoGroup from './VideoGroup.vue';
  import Finder from './Finder.vue';
  import Search from './Search';
 

  export default {
	name: 'dashboard',  
    components: {
      VideoGroup, Finder
    },

    created() {
      Search({
        apiKey: 'AIzaSyB_9UoK0EwZG9FGN2amrNXlYKBycMk9rns',
        term: 'searchTerm',
        items: 10
      }, response => this.handleSearchResults(response));

      window.eventBus.$on('searchForYoutubeStarted', (string) => {
        this.loading = true;
      });

      window.eventBus.$on('searchResultFromYoutube', videos => {
        console.log('search result', videos);
        this.loading = false;
        this.videos = videos;
      });
    },

    data() {
      return {
        videos: null,
        loading: true
      }
    },

    methods: {
      handleSearchResults(result) {
        this.loading = false;
        this.videos = result;
      }
    }
  }
</script>
