<template>
    <div class="data-table">
      <table class="min-w-full table-auto border-collapse border border-gray-200">
        <thead>
          <tr class="bg-gray-200 text-gray-600">
            <th class="py-3 px-6">No</th>
            <th
              v-for="column in columns"
              :key="column.field"
              class="py-3 px-6 text-left border-b border-gray-200 bg-gray-200 text-gray-600"
              :class="column.class"
            >
              {{ column.label }}
              <span
                v-if="column.sortable"
                @click="sortBy(column.field)"
                class="cursor-pointer"
              >
                {{ sortKey === column.field ? (sortOrder === 'asc' ? '▲' : '▼') : '' }}
              </span>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(item, index) in sortedData"
            :key="item.id"
            class="hover:bg-gray-100 border-b border-gray-200 group bg-white"
          >
            <td class="py-1 px-3">{{ (currentPage - 1) * itemsPerPage + index + 1 }}</td>
            <td
              v-for="column in columns"
              :key="column.field"
              class="py-3 px-2 text-left border-b border-gray-200 bg-white"
              :class="column.class"
            >
              <div v-if="$slots[column.field]">
                <slot :name="column.field" :row="item"></slot>
              </div>
              <div v-else>
                {{ getValue(item, column.field) }}
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="pagination mt-4 flex justify-between">
        <div>
          Page {{ currentPage }} of {{ pageCount }}
        </div>
        <div>
          <button @click="prevPage" :disabled="currentPage === 1" class="px-4 py-2 mx-2 bg-gray-300 rounded disabled:opacity-50">Prev</button>
          <span class="px-4 py-2">{{ currentPage }}</span>
          <button @click="nextPage" :disabled="currentPage >= pageCount" class="px-4 py-2 mx-2 bg-gray-300 rounded disabled:opacity-50">Next</button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      data: {
        type: Array,
        required: true,
      },
      columns: {
        type: Array,
        required: true,
      },
      totalItems: {
        type: Number,
        required: true,
      },
      currentPage: {
        type: Number,
        required: true,
      },
      itemsPerPage: {
        type: Number,
        required: true,
      },
    },
    data() {
      return {
        sortKey: '',
        sortOrder: 'asc',
      };
    },
    computed: {
      pageCount() {
        return Math.ceil(this.totalItems / this.itemsPerPage);
      },
      sortedData() {
        let data = this.data.slice();
  
        // Sort data
        if (this.sortKey) {
          data.sort((a, b) => {
            const modifier = this.sortOrder === 'asc' ? 1 : -1;
            const aValue = this.getValue(a, this.sortKey);
            const bValue = this.getValue(b, this.sortKey);
            return (aValue < bValue ? -1 : 1) * modifier;
          });
        }
        // Paginate data
        const start = (this.currentPage - 1) * this.itemsPerPage;
        return data.slice(start, start + this.itemsPerPage);
      },
    },
    methods: {
      getValue(item, key) {
        if (!key) return '';
        return key.split('.').reduce((o, i) => (o ? o[i] : ''), item);
      },
      sortBy(key) {
        this.sortOrder = this.sortKey === key && this.sortOrder === 'asc' ? 'desc' : 'asc';
        this.sortKey = key;
      },
      nextPage() {
        if (this.currentPage < this.pageCount) {
          this.$emit('update:currentPage', this.currentPage + 1);
        }
      },
      prevPage() {
        if (this.currentPage > 1) {
          this.$emit('update:currentPage', this.currentPage - 1);
        }
      },
    },
  };
  </script>
  
  <style scoped>
  /* Tambahkan gaya yang diperlukan di sini */
  </style>