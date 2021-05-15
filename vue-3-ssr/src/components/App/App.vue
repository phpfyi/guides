<template>
  <div class="app">
    <PageMetaTeleport />
    <router-view />
  </div>
</template>

<script lang="ts">
import { Vue } from "vue-class-component";

export default class App extends Vue {}
</script>