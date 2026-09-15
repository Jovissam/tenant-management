<template>
  <base-loader v-if="isLoading"></base-loader>
  <auth-layout>
    <template #title>
      <h3>Login</h3>
    </template>

    <form @submit.prevent="submitForm" class="mt-3">
      <p v-if="!!error" class="text-danger">{{ error }}</p>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input
          type="email"
          class="form-el"
          id="exampleInputEmail1"
          aria-describedby="emailHelp"
          v-model.trim="email"
        />
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input
          type="password"
          class="form-el"
          id="exampleInputPassword1"
          v-model.trim="password"
        />
      </div>
      <div class="mb-3">
        <label for="remember" class="form-label d-inline">Rember Me</label>
        <input
          type="checkbox"
          class="form-check d-inline ms-3 position-absolute"
          style="margin-top: 2px"
          id="remember"
          v-model="remember"
        />
      </div>
      <button type="submit" class="button-1 form-el mt-4">Submit</button>
    </form>

    <template #link>
      <p>
        Don't have an Account?
        <router-link :to="{ name: 'signUp' }">Sign up</router-link>
      </p>
    </template>
  </auth-layout>
</template>
<script setup>
import AuthLayout from "@/components/layouts/AuthLayout.vue";
import { ref } from "vue";
import { useStore } from "vuex";

const store = useStore();

const email = ref("");
const password = ref("");
const remember = ref(false);
const error = ref(null);
const isLoading = ref(false);
const isValid = ref(true);

async function submitForm() {
  isValid.value = true;

  if (!email.value || !password.value) {
    error.value = "Email Or Password Field is empty";
    isValid.value = false;
    return;
  } else if (!email.value.includes("@")) {
    error.value = "email must be a valid one";
    isValid.value = false;
    return;
  }

  try {
    isLoading.value = true;
    error.value = null

    await store.dispatch("login", {
      email: email.value,
      password: password.value,
      remember: remember.value,
    });
  } catch (err) {
    error.value = err.message;
  } finally {
    isLoading.value = false;
  }
}
</script>
