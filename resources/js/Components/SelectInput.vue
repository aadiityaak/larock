<template>
    <div class="flex relative">
      <select
        :value="modelValue"
        @change="$emit('update:modelValue', $event.target.value)"
        class="block w-full rounded-md border border-gray-300 shadow-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
      >
        <option value="" disabled>Pilih Jenis Paket</option>
        <option v-for="(jenis, index) in options" :key="index" :value="jenis">{{ jenis }}</option>
      </select>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      modelValue: String,
      options: Array,
    },
  };
  </script>