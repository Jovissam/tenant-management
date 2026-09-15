<template>
  <auth-layout>
    <template #title>
      <h3>Create An Account</h3>
    </template>

    <form @submit.prevent="register" class="mt-3">
      <div class="mb-3">
        <label for="fname" class="form-label">First Name</label>
        <input v-model="firstName"
          type="text"
          class="form-el"
          id="fname"
          aria-describedby="emailHelp"
        />
      </div>
      <div class="mb-3">
        <label for="lname" class="form-label">Last Name</label>
        <input v-model="lastName"
          type="text"
          class="form-el"
          id="lname"
          aria-describedby="emailHelp"
        />
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input v-model="email"
          type="email"
          class="form-el"
          id="exampleInputEmail1"
          aria-describedby="emailHelp"
        />
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input v-model="password" type="password" class="form-el" id="exampleInputPassword1" />
      </div>
      <button type="submit" class="button-1 form-el mt-4">Submit</button>
    </form>

    <template #link>
      <p>
        Have an Account?
        <router-link :to="{ name: 'login' }">Login</router-link>
      </p>
    </template>
  </auth-layout>
</template>
<script setup>
import AuthLayout from "@/components/layouts/AuthLayout.vue";
import { ref } from "vue";
import { useStore } from "vuex";

const store = useStore();

const firstName = ref("");
const lastName = ref("");
const email = ref("");
const password = ref("");
const error = ref(null);
const isLoading = ref(false);
const isValid = ref(true);

async function register() {
  isValid.value = true;

  if (!firstName.value || !lastName.value || !email.value || !password.value) {
    error.value = "Please fill in all Fields";
    isValid.value = false;
    return;
  } else if (!email.value.includes("@")) {
    error.value = "email must be a valid one";
    isValid.value = false;
    return;
  }

  try {
   
    error.value = null
    await store.dispatch("register", {
      firstName: firstName.value,
      lastName: lastName.value,
      email: email.value,
      password: password.value,
    });
  } catch (err) {
    error.value = err.message;
  } finally{
     isLoading.value = false;
  }
}
</script>

<style scoped>
</style>