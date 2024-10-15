<template>
    <div class="flex relative">
      <input
        type="text"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        placeholder="Cari Project"
        class="block w-full rounded-md border border-gray-300 shadow-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
      />
    </div>
  </template>
  
  <script>
  export default {
    props: {
      modelValue: String,
    },
  };
  </script>