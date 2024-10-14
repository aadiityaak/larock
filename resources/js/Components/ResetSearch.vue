<template>
  <button
    v-if="isVisible"
    @click="handleClick"
    :class="['bg-red-500 text-white rounded-full p-1 ml-2 border border-red-500 absolute -right-2 -top-2', customClass]"
    aria-label="Clear search"
  >
    <BIconXLg />
  </button>
</template>

<script>
import { BIconXLg } from 'bootstrap-icons-vue';
export default {
  props: {
    isVisible: {
      type: Boolean,
      required: true,
    },
    customClass: {
      type: String,
      default: '',
    },
  },
  components: {
    BIconXLg
  },
  methods: {
    handleClick() {
      this.$emit('reset'); // Emit an event to notify the parent to reset
    },
  },
};
</script>

<style scoped>
/* Add any necessary styles here */
</style>