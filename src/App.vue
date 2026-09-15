<template>
  <router-view/>
</template>

<script setup>
import { useStore } from "vuex";
import { watch, onMounted } from "vue";
import { useRouter } from "vue-router";

const store = useStore()
const router = useRouter()

watch(() => store.state.auth.autoLogout, (newVal, oldVal) => {
if (newVal && newVal !== oldVal) {
  router.replace('/')
  
}
})
onMounted(() => {
  store.dispatch('tryLogin')
})
</script>
<style>

</style>
