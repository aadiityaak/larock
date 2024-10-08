<template>
    <div v-if="mainprojects && mainprojects.data && mainprojects.data.length > 0">
      <nav class="flex justify-between items-center pt-3">
        <span class="text-sm text-gray-600">
          Showing page {{ mainprojects.current_page }} of {{ mainprojects.last_page }}
        </span>
        <div class="inline-flex items-center">
          <button
            @click="changePage(mainprojects.prev_page_url)"
            :disabled="!mainprojects.prev_page_url"
            class="bg-gray-300 text-gray-600 py-2 px-4 rounded-l hover:bg-gray-400 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            Previous
          </button>
  
          <button
            @click="changePage(mainprojects.next_page_url)"
            :disabled="!mainprojects.next_page_url"
            class="bg-gray-300 text-gray-600 py-2 px-4 rounded-r hover:bg-gray-400 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            Next
          </button>
        </div>
      </nav>
    </div>
    <div v-else>
      <span>Data not available.</span>
    </div>
  </template>
  
  <script>
  export default {
    name: 'Pagination',
    props: {
      mainprojects: {
        type: Object,
        default: () => ({}),
      },
    },
    methods: {
      changePage(url) {
        const page = new URL(url).searchParams.get('page'); // Ambil nomor halaman dari URL
        if (page) {
          this.$emit('pagination-change-page', page); // Emit nomor halaman, bukan URL
        }
      },
    },
  };
  </script>