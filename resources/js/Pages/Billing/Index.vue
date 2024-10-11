<template>
  <AuthenticatedLayout title="Billing">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Billing</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-4 shadow-md rounded">
          <div class="m-4">
            <div class="flex">
              <div class="mr-2 flex">
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
              <div class="flex">
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
                <ResetSearch :isVisible="!!selectedJenis" @reset="clearJenis" />
              </div>
              <div class="ml-2 flex">
                <Datepicker 
                v-model="date" 
                range 
                :enable-time-picker="false" 
                :multi-calendars="{ solo: true }" 
                placeholder="Pilih Rentang tanggal"
                :text-input="textInputOptions"
                />
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
            />
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
      default: () => [new Date().setMonth(new Date().getFullYear() - 10), new Date()],
    }
  },
  data() {
    return {
      date: this.qdate, 
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
  },
  methods: {
    getColumns() {
      return [
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
      ];
    },
    searchData() {
      this.$inertia.get(route('billing'), { 
        cari: this.searchQuery, 
        jenis: this.selectedJenis,
        perPage: this.itemsPerPage,
        startDate: this.date[0],
        endDate: this.date[1], 
      });
    },
    clearSearch() {
      this.searchQuery = '';
      this.searchData();
    },
    clearJenis() {
      this.selectedJenis = '';
      this.searchData();
    },
    fetchPage(page) {
      this.$inertia.get(route('billing'), { 
        cari: this.searchQuery,
        jenis: this.selectedJenis,
        perPage: this.itemsPerPage,
        page 
      });
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
    qdate: {
      handler(newVal) {
        this.date = newVal;
      },
      immediate: true,
    },
  },
  mounted() {
    console.log(this);
  },
};
</script>

<style>
/* Customize the background of the range selection */
.dp__range_between {
  background-color: rgba(0, 123, 255, 0.5); /* Example: light blue */
  border-radius: 4px; /* Optional: rounded corners */
}

</style>