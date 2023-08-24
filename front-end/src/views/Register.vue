<template>
  <div class="d-flex justify-content-center center-container align-items-center">
    <div class="form">
      <form @submit.prevent="submit">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input v-model="data.name" type="text" required class="form-control" id="username">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">E-mail</label>
          <input v-model="data.email" type="email" required class="form-control" id="email">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input v-model="data.password" type="password" required class="form-control" id="password">
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
      </form>
    </div>
  </div>
</template>

<script lang="ts">
import {reactive} from "vue";
import {useRouter} from "vue-router";

export default {
  setup() {
    const data = reactive({
      name: '',
      email: '',
      password: '',
    });

    const router = useRouter();

    const submit = async () => {
      await fetch('http://localhost/api/register', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
      });

      await router.push('/login');
    }

    return {
      data,
      submit
    }
  }
}
</script>>

<style scoped>
.form {
  width: 300px;
  height: 400px;
}

.btn {
  width: 100%;
  margin-top: 15px;
}

form {
  width: 90%;
}

.center-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 80vh; /* This will center the content vertically */
}

.form {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
</style>