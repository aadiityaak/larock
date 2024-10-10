<template>
    <div>
      <div class="pagination mt-4 flex justify-between mx-4 mb-4">
        <div>
          <div v-for="link in links" :key="link.label" class="inline">
            <a @click="changePage(link.url)" class="cursor-pointer mx-2 p-2 bg-gray-300 rounded">
              {{ link.label }}
            </a>
          </div>
        </div>
      </div>
      <div class="data-table overflow-x-auto">
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
                  {{ formatValue(item, column) }}
                </div>
              </td>
            </tr>
          </tbody>
        </table>
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
      currentPage: {
        type: Number,
        required: true,
      },
      itemsPerPage: {
        type: Number,
        required: true,
      },
      links: {
        type: Array,
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
      sortedData() {
        // Sorting logic can be added here if needed
        return this.data;
      },
    },
    methods: {
      getValue(item, key) {
        if (!key) return '';
        return key.split('.').reduce((o, i) => (o ? o[i] : ''), item);
      },
      formatValue(item, column) {
        const value = this.getValue(item, column.field);
        if (column.type === 'rupiah') {
          return this.formatRupiah(value);
        }
        return value; // Return the raw value for other types
      },
      formatRupiah(amount) {
        if (!amount) return '0';
        return new Intl.NumberFormat('id-ID', {
          style: 'currency',
          currency: 'IDR',
          minimumFractionDigits: 0,
        }).format(amount);
      },
      changePage(url) {
        if (url) {
          this.$inertia.visit(url);
        }
      },
    },
  };
  </script>
  
  <style scoped>
  /* Add necessary styles here */
  </style>