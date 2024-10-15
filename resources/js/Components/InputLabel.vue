<template>
    <div class="mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-2">{{ label }}</label>
      <select v-if="options" :value="modelValue" @change="$emit('update:modelValue', $event.target.value)" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight">
        <option v-for="(option, index) in options" :key="index" :value="option">{{ option }}</option>
      </select>
      <input v-else type="text" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" />
    </div>
  </template>
  
  <script>
  export default {
    props: {
      label: String,
      modelValue: String,
      options: Array,
    },
  };
  </script>