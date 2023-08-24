<template>
  <header
      style="max-width: 1280px; margin: auto"
      class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-2">
    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
      <li>
        <router-link to="/" class="nav-link navigation">Home</router-link>
      </li>
    </ul>

    <div v-if="!auth" class="col-md-3 text-end form">
      <router-link to="/login" class="btn btn-outline-primary me-2">Login</router-link>
      <router-link to="/register" class="btn btn-outline-primary me-2">Register</router-link>
    </div>

    <div v-if="auth" class="col-md-3 text-end form">
      Logged in as: {{ username }}
      <router-link @click="logout" to="#" class="btn btn-outline-primary me-2 ml-5">Logout</router-link>
    </div>
  </header>
</template>

<script lang="ts">
import {useStore} from "vuex";
import {computed, onMounted, ref} from "vue";

export default {
  setup() {
    const store = useStore();

    const auth = computed(() => store.state.authenticated);
    const username = computed(() => store.state.username);

    const logout = async () => {
      await fetch('http://localhost/api/logout', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        credentials: 'include',
      });


      await store.dispatch('setAuth', false)
      await store.dispatch('setUsername', '')
    }

    onMounted(async () => {
        try {
          const response = await fetch('http://localhost/api/user', {
            method: 'GET',
            headers: {'Content-Type': 'application/json'},
            credentials: 'include'
          });

          const content = await response.json();

          await store.dispatch('setAuth', true)
        } catch (e) {
          await store.dispatch('setAuth', false)
        }
    });

    return {
      logout,
      username,
      auth
    }
  }
}
</script>

<style scoped>
.form {
  margin-right: 20px;
}
.btn{
  width: 90px;
}
</style>