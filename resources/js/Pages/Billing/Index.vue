<template>
  <AuthenticatedLayout title="Billing">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Billing</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-4 shadow-md rounded">
          <div class="m-4">
            <div class="grid gap-2 grid-cols-5">
              <div class="flex justify-between border border-gray-300 py-2 px-4 rounded relative">
                Project Bulan ini <span class="z-10 bg-green-500 text-white rounded-full text-xs px-3 py-1">{{ project_bulan_ini }}</span>
              </div>
              <div class="flex justify-between border border-gray-300 py-2 px-4 rounded relative">
                Prediksi Bulan ini <span class="z-10 bg-blue-500 text-white rounded-full text-xs px-3 py-1">{{ prediksi_bulan_ini }}</span>
              </div>
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
                <ResetSearch :isVisible="!!searchQuery" @reset="clearSearch" />
              </div>
              <div class="flex relative">
                <select
                  v-model="selectedJenis"
                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                  @change="searchData"
                >
                  <option value="" disabled>Pilih Jenis Paket</option>
                  <option
                    v-for="(jenis, index) in jenispaket"
                    :key="index"
                    :value="jenis"
                  >
                    {{ jenis }}
                  </option>
                </select>
                <ResetSearch 
                :isVisible="!!selectedJenis" 
                @reset="clearJenis"
                />
              </div>
              <div class="ml-2 flex relative">
                <Datepicker 
                  v-model="date" 
                  range 
                  :enable-time-picker="false" 
                  :multi-calendars="{ solo: true }" 
                  placeholder="Pilih Rentang tanggal"
                  @change="searchData"
                >
                  <template #day="{ day, date }">
                    <span class="datepicker-day">{{ day }}</span>
                  </template>
                  <template #clear-icon="{ clear }">
                    <button @click="clear" class="reset-button">
                      <svg
                          xmlns="http://www.w3.org/2000/svg"
                          class="h-3 w-3"
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
                  </template>
                </Datepicker>
              </div>
            </div>
          </div>

          <div class="overflow-x-auto">
            <Table
              :data="mainprojects.data"
              :columns="columns"
              :totalItems="totalItems"
              :currentPage="currentPage"
              :itemsPerPage="itemsPerPage"
              :links="links"
              :searchQuery="searchQuery"
              :selectedJenis="selectedJenis"
              :startDate="date[0] || ''"
              :endDate="date[1] || ''"
            >
            <template #tindakan="{ row, index }">
              <DropdownMenu>
              <DropdownMenuTrigger>Open</DropdownMenuTrigger>
              <DropdownMenuContent>
                <DropdownMenuLabel>Edit</DropdownMenuLabel>
                <DropdownMenuSeparator />
                <DropdownMenuItem>Hapus</DropdownMenuItem>
              </DropdownMenuContent>
            </DropdownMenu>
            </template>
            </Table>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ResetSearch from '@/Components/ResetSearch.vue';
import Table from '@/Components/Table.vue';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'

export default {
  props: {
    mainprojects: {
      type: Object,
      required: true,
    },
    qcari: {
      type: String,
      default: null,
    },
    listpaket: {
      type: Array,
      required: true,
    },
    jenispaket: {
      type: Array,
      required: true,
      default: () => [],
    },
    qjenis: {
      type: String,
      default: null,
    },
    qdate: {
      type: Array,
      default: () => [],
    },
    project_bulan_ini: {
      type: Number,
      default: 0,
    },
    prediksi_bulan_ini: {
      type: Number,
      default: 0,
    }
  },
  data() {
    return {
      date: Array.isArray(this.qdate) ? this.qdate : [null, null],
      searchQuery: this.qcari || '',
      selectedJenis: this.qjenis || '',
      columns: this.getColumns(),
      currentPage: this.mainprojects.current_page || 1,
      itemsPerPage: this.mainprojects.per_page || 100,
      totalItems: this.mainprojects.total || 0,
      links: this.mainprojects.links || [],
    };
  },
  components: {
    AuthenticatedLayout,
    Table,
    ResetSearch,
    Datepicker,
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
  },
  methods: {
    getColumns() {
      return [
        { field: 'jenis', label: 'Jenis', sortable: true },
        { field: 'webhost.nama_web', label: 'Nama Website', sortable: true, class: 'sticky left-0 z-10 shadow' },
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
        { field: 'tindakan', label: 'Tindakan', sortable: false, class: 'sticky right-0 z-10 shadow' },
      ];
    },
    clearSearch() {
      this.searchQuery = '';
      this.searchData();
    },
    clearJenis() {
      this.selectedJenis = '';
      this.searchData();
    },
    searchData() {
      const startDate = this.date && this.date[0] ? this.date[0] : ''; // Cek jika date[0] ada
      const endDate = this.date && this.date[1] ? this.date[1] : ''; // Cek jika date[1] ada

      const params = {
        cari: this.searchQuery,
        jenis: this.selectedJenis,
        perPage: this.itemsPerPage,
        startDate,
        endDate,
      };

      // Hapus parameter yang kosong dari objek params
      Object.keys(params).forEach(key => params[key] === '' && delete params[key]);

      this.$inertia.get(route('billing'), params);
    },
    fetchPage(page) {
      const startDate = this.date && this.date[0] ? this.date[0] : ''; // Cek jika date[0] ada
      const endDate = this.date && this.date[1] ? this.date[1] : ''; // Cek jika date[1] ada

      const params = {
        cari: this.searchQuery,
        jenis: this.selectedJenis,
        perPage: this.itemsPerPage,
        page,
        startDate,
        endDate,
      };

      // Hapus parameter yang kosong dari objek params
      Object.keys(params).forEach(key => params[key] === '' && delete params[key]);

      this.$inertia.get(route('billing'), params);
    },
  },
  watch: {
    mainprojects: {
      handler(newVal) {
        this.currentPage = newVal.current_page;
        this.totalItems = newVal.total;
        this.itemsPerPage = newVal.per_page;
      },
      immediate: true,
    },
    date: {
      handler() {
        this.searchData(); // Trigger search when date changes
      },
      deep: true, // Make sure to watch for changes in the array
    },
  },
  mounted() {
    console.log(this);
  },
};
</script>

<style scoped>
.reset-button {
  @apply bg-red-500 text-white rounded-full p-1 ml-2 border border-red-500 absolute -right-2 -top-[30px];
}
.datepicker-day {
  @apply text-gray-900 text-sm;
}
.dp__range_start .datepicker-day,
.dp__range_end .datepicker-day {
  @apply text-white;
}

.dp__range_between .datepicker-day {
  @apply text-blue-500;
}
</style>