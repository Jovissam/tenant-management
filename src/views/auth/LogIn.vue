<template>
  <auth-layout>
    <template #title>
      <h3>Login</h3>
    </template>

    <form class="mt-3">
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input
          type="email"
          class="form-el"
          id="exampleInputEmail1"
          aria-describedby="emailHelp"
        />
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-el" id="exampleInputPassword1" />
      </div>
      <button type="submit" class="button-1 form-el mt-4">Submit</button>
    </form>

    <template #link>
      <p>Don't have an Account? <router-link :to="{name: 'signUp'}">Sign up</router-link></p>
    </template>
  </auth-layout>
</template>
<script>
import AuthLayout from "@/components/layouts/AuthLayout.vue";
export default {
  components: { AuthLayout },
};
</script>

<style scoped>
</style>