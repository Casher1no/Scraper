<template>
  <div class="center-container">
    <div v-if="auth">
      <DataTable/>
    </div>
    <div v-else>
      <h2 class="login-to-continue" @click="router('/login')">
        Login to continue
      </h2>
    </div>
  </div>
</template>

<script lang="ts">
import {computed, onMounted, ref} from "vue";
import {useStore} from "vuex";
import DataTable from "@/components/DataTable.vue";
import router from "@/router";

export default {
  methods: {
    router(path: string) {
      router.push(path);
    }
  },
  components: {DataTable},

  setup() {
    const message = ref("You are not logged in!");
    const store = useStore();
    const auth = computed(() => store.state.authenticated);

    onMounted(async () => {
      try {
        const fetchUser = await fetch('http://localhost/api/user', {
          method: 'GET',
          headers: {'Content-Type': 'application/json'},
          credentials: 'include'
        });

        const contentUser = await fetchUser.json();

        message.value = contentUser.name;
        await store.dispatch('setAuth', true)
        await store.dispatch('setUsername', contentUser.name)
      } catch (e) {
        message.value = '';
        await store.dispatch('setAuth', false)
        await store.dispatch('setUsername', '')

      }
    });

    return {
      message,
      auth
    }
  },

}

</script>

<style scoped>
.center-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 80vh; /* This will center the content vertically */
}

.login-card {
  text-align: center;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.login-to-continue {
  color: dodgerblue;
  transition: 0.2s;
}
.login-to-continue:hover{
  cursor: pointer;
  opacity: 0.7;
  transition: 0.2s;
}
</style>