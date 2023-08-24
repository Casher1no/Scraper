<template>
  <Navbar />
  <div class="view">
    <router-view/>
  </div>
</template>

<script setup>
import Navbar from '@/components/Navbar.vue';

</script>

<style>
#app {
  font-family: 'Montserrat', sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

.view{
  max-width: 1280px;
  margin: auto;
}
</style>
