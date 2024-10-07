<template>
    <div v-if="projects && projects.data && projects.data.length > 0">
      <nav class="flex justify-between items-center pt-3">
        <span class="text-sm text-gray-600">
          Showing page {{ projects.current_page }} of {{ projects.last_page }}
        </span>
        <div class="inline-flex items-center">
          <button
            @click="changePage(projects.prev_page_url)"
            :disabled="!projects.prev_page_url"
            class="bg-gray-300 text-gray-600 py-2 px-4 rounded-l hover:bg-gray-400 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            Previous
          </button>
  
          <button
            @click="changePage(projects.next_page_url)"
            :disabled="!projects.next_page_url"
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
      projects: {
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