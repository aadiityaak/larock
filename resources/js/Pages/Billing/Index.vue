<template>
  <AuthenticatedLayout title="Billing">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Billing
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="bg-white shadow-md rounded">

            <div class="m-2">
              <div class="flex">
                <div class="m-2">
                  <div class="flex relative">
                    <input
                      id="cari"
                      name="cari"
                      type="text"
                      v-model="searchQuery"
                      placeholder="Cari Project"
                      @input="searchData"
                      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    />

                    <button
                      v-if="searchQuery"
                      @click="clearSearch"
                      class="bg-red-500 text-white rounded-md p-2 ml-2 top-0 absolute right-0 border border-red-500"
                      aria-label="Clear search"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M6 18L18 6M6 6l12 12"
                        />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div class="overflow-x-auto">
              <Table 
                :data="filteredData" 
                :columns="columns" 
                :totalItems="totalItems" 
                :currentPage="currentPage" 
                :itemsPerPage="itemsPerPage"
                :links="links"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Table from '@/Components/Table.vue';

export default {
  props: {
    mainprojects: {
      type: Object,
      required: true,
    },
    cari: {
      type: String,
      default: null
    }
  },
  components: {
    AuthenticatedLayout,
    Table,
  },
  data() {
    return {
      searchQuery: this.cari,
      columns: [
        { field: 'jenis', label: 'Jenis', sortable: true },
        { field: 'webhost.nama_web', label: 'Nama Website', sortable: true, class: 'sticky left-0 z-10' },
        { field: 'webhost.paket.paket', label: 'Paket', sortable: true },
        { field: 'deskripsi', label: 'Deskripsi', sortable: true },
        { field: 'trf', label: 'Trf', sortable: true, type: 'rupiah' },
        { field: 'tgl_masuk', label: 'Tgl Masuk', sortable: true, type: 'date' },
        { field: 'tgl_deadline', label: 'Tgl Deadline', sortable: true, type: 'date' },
        { field: 'biaya', label: 'Biaya', sortable: true, type: 'rupiah' },
        { field: 'dibayar', label: 'Dibayar', sortable: true, type: 'rupiah' },
        { field: 'kurang', label: 'Kurang', sortable: true, type: 'rupiah' },
        { field: 'saldo', label: 'Saldo', sortable: true, type: 'rupiah' },
        { field: 'webhost.hp', label: 'HP', sortable: true },
        { field: 'webhost.telegram', label: 'Telegram', sortable: true },
        { field: 'webhost.hpads', label: 'HP Ads', sortable: true },
        { field: 'webhost.wa', label: 'WhatsApp', sortable: true },
        { field: 'webhost.email', label: 'Email', sortable: true },
        { field: 'karyawan_data', label: 'Dikerjakan Oleh', sortable: true },
      ],
      currentPage: this.mainprojects.current_page || 1,
      itemsPerPage: this.mainprojects.per_page || 100,
      totalItems: this.mainprojects.total || 0,
      links: this.mainprojects.links || [],
    };
  },
  methods: {
    searchData() {
        this.$inertia.get(route('billing'), { cari: this.searchQuery, perPage: this.itemsPerPage });
      },
      clearSearch() {
        this.searchQuery = '';
        this.$inertia.get(route('billing'), { perPage: this.itemsPerPage });
      },
      fetchPage(page) {
        this.$inertia.get(route('billing'), { cari: this.searchQuery, perPage: this.itemsPerPage, page });
      },
  },
  computed: {
    filteredData() {
      if (!this.searchQuery) {
        return this.mainprojects.data;
      }
      return this.mainprojects.data.filter(item => {
        return item.deskripsi.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
               item.webhost.nama_web.toLowerCase().includes(this.searchQuery.toLowerCase());
      });
    },
  },
  watch: {
    mainprojects(newVal) {
      this.currentPage = newVal.current_page;
      this.totalItems = newVal.total;
      this.itemsPerPage = newVal.per_page;
    },
  }
};
</script>
