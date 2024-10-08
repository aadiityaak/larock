<template>
    <div class="data-table">
      <table class="min-w-full border-collapse border border-gray-200">
        <thead>
          <tr class="bg-gray-200 text-gray-600">
            <th class="py-3 px-6">No</th>
            <th
              v-for="column in columns"
              :key="column.field"
              class="py-3 px-6 text-left border-b border-gray-200"
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
            class="hover:bg-gray-100 border-b border-gray-200"
          >
            <td class="py-3 px-6">{{ (currentPage - 1) * itemsPerPage + index + 1 }}</td>
            <td
              v-for="column in columns"
              :key="column.field"
              class="py-3 px-6"
            >
              {{ getValue(item, column.field) }}
            </td>
            <td class="py-3 px-6">
              <button @click="editRow(item.id)" class="text-blue-600 hover:text-blue-800">Edit</button>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="pagination mt-4">
        <button @click="prevPage" :disabled="currentPage === 1">Prev</button>
        <span>{{ currentPage }}</span>
        <button @click="nextPage" :disabled="currentPage >= pageCount">Next</button>
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
    },
    data() {
      return {
        currentPage: 1,
        itemsPerPage: 10, // Sesuaikan jumlah item per halaman
        sortKey: '',
        sortOrder: 'asc',
      };
    },
    computed: {
      pageCount() {
        return Math.ceil(this.data.length / this.itemsPerPage);
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
          this.currentPage++;
        }
      },
      prevPage() {
        if (this.currentPage > 1) {
          this.currentPage--;
        }
      },
      editRow(id) {
        // Logic for editing the row
        console.log('Edit row with id:', id);
        // You can redirect to an edit page or open a modal here
      },
    },
  };
  </script>
  
  <style scoped>
  .data-table {
    border: 1px solid #e5e7eb;
  }
  .pagination {
    display: flex;
    justify-content: center;
    margin-top: 1rem;
  }
  .pagination button {
    margin: 0 0.5rem;
    padding: 0.25rem 0.5rem;
  }
  </style>