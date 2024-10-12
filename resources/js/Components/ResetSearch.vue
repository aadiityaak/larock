<template>
  <button
    v-if="isVisible"
    @click="handleClick"
    :class="['bg-red-500 text-white rounded-full p-1 ml-2 border border-red-500 absolute -right-2 -top-2', customClass]"
    aria-label="Clear search"
  >
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="h-3 w-3"
      fill="none"
      viewBox="0 0 24 24"
      stroke="currentColor"
      stroke-width="2"
    >
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        d="M6 18L18 6M6 6l12 12"
      />
    </svg>
  </button>
</template>

<script>
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