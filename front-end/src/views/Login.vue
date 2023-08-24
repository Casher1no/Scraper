<template>
  <div class="d-flex justify-content-center center-container align-self-center">
    <div class="form container-fluid">
      <form @submit.prevent="submit">
        <v-card v-if="errorMessage"
                color="red"
                class="mb-5"
                style="height: 40px;"
                variant="tonal"
        >
          <p class="mt-2">{{ errorMessage }}</p>
        </v-card>
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input v-model="data.name" type="text" required class="form-control" id="username"
                 aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input v-model="data.password" type="password" required class="form-control" id="password">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
      </form>
    </div>
  </div>
</template>

<script>
import {reactive, ref} from "vue";
import {useRouter} from "vue-router";
import store from "@/store";

export default {
  setup() {
    const data = reactive({
      name: '',
      password: ''
    });

    const errorMessage = ref('');

    const router = useRouter();

    const submit = async () => {
      try {
        let success = true;

        const response = await fetch('http://localhost/api/login', {
          method: 'POST',
          headers: {'Content-Type': 'application/json'},
          credentials: 'include',
          body: JSON.stringify(data)
        });

        if (response.status === 401) { // Unauthorized
          errorMessage.value = 'Invalid credentials';
          success = false;
        }


        if (success) {
          await router.push('/');
        }
        success = true;

      } catch (e) {
        errorMessage.value = "Something went wrong"
      }
    }

    return {
      data,
      submit,
      errorMessage
    }
  },
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

.center-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 80vh; /* This will center the content vertically */
}

form {
  width: 90%;
}

.form {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
</style>