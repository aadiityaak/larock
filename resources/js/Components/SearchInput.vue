<template>
    <div class="flex relative">
      <input
        type="text"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        placeholder="Cari Project"
        class="block w-full rounded-md border border-gray-300 shadow-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
      />
      <ResetSearch
        v-if="modelValue"
        @click="$emit('update:modelValue', '')"
        class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5"
      />
    </div>
  </template>
  
  <script>
import ResetSearch from './ResetSearch.vue';

  export default {
    props: {
      modelValue: String,
    },
    components: {
      ResetSearch
    },
  };
  </script>