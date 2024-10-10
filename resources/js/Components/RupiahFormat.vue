<template>
    <span>{{ formatRupiah(data) }}</span>
</template>
  
  <script>
  export default {
    props: {
      data: {
        type: Number,
        required: true
      }
    },
    methods: {
      formatRupiah(value) {
        if (!value) return 'Rp 0';
        return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      }
    }
  }
  </script>
  