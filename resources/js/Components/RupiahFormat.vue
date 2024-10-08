<template>
    <span>{{ formatRupiah(amount) }}</span>
</template>
  
  <script>
  export default {
    props: {
      amount: {
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
  