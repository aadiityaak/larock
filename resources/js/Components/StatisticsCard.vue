<template>
    <div class="flex justify-between border border-gray-300 py-2 px-4 rounded relative">
      {{ title }} <span class="z-10 bg-green-500 text-white rounded-full text-xs px-3 py-1">{{ value }}</span>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      title: String,
      value: Number,
      color: String,
    },
  };
  </script>