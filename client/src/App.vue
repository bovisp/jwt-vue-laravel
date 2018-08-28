<template>
  <div class="font-sans text-grey-darkest">
    <div v-if="$auth.ready()">
      <top-nav />
        
      <router-view />
    </div>

    <div v-if="!$auth.ready()">
      Loading ...
    </div>
  </div>
</template>

<script>
  import TopNav from './views/partials/TopNav.vue'

  export default {
    components: {
      TopNav
    }
  }
</script>