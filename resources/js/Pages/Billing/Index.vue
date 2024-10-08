<template>
  <AuthenticatedLayout title="Billing">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Billing</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="overflow-x-auto">
            <DataTable
              :data="mainprojects.data"
              :columns="columns"
              :pagination="true"
              :server-side="true"
              :total-rows="totalRows" 
              :current-page="currentPage" 
              :rows-per-page="itemsPerPage"
              @page-change="getMainProjects"
              class="min-w-full divide-y divide-gray-200"
            />
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';

DataTable.use(DataTablesCore);
export default {
  props: {
    mainprojects: {
      type: Object,
      required: true,
    },
  },
  components: {
    AuthenticatedLayout,
    DataTable,
  },
  data() {
    return {
      columns: [
        { 
          data: null, 
          title: 'No', 
          render: (data, type, row, meta) => this.getRowNumber(meta),
        },
        { data: 'jenis', title: 'Jenis' },
        { data: 'webhost.nama_web', title: 'Nama Web' },
        { 
          data: 'webhost.paket.paket', 
          title: 'Webhost Paket', 
          render: (data, type, row) => row.webhost?.paket?.paket || "-" 
        },
        { data: 'deskripsi', title: 'Deskripsi' },
        { 
          data: 'trf', 
          title: 'Transfer', 
          render: (data) => this.rupiahFormat(data),
        },
        { data: 'tgl_masuk', title: 'Tanggal Masuk' },
        { data: 'tgl_deadline', title: 'Tanggal Deadline' },
      ],
      // Menetapkan nilai default dari props mainprojects untuk current page, total rows, dan items per page
      currentPage: this.mainprojects.current_page || 1,
      itemsPerPage: this.mainprojects.per_page || 150,
      totalRows: this.mainprojects.total || 0,
      tableData: this.mainprojects.data || [], // Data tabel harus diambil dari mainprojects.data
    };
  },
  watch: {
    // Memperbarui data setiap kali props mainprojects berubah
    mainprojects: {
      immediate: true,
      handler(newVal) {
        console.log('Updated mainprojects:', newVal);
        this.currentPage = newVal.current_page || 1;
        this.itemsPerPage = newVal.per_page || 150;
        this.totalRows = newVal.total || 0;
        this.tableData = newVal.data || [];
      },
    },
  },
  methods: {
    getRowNumber(meta) {
      // Menghitung nomor urut berdasarkan pagination
      return (this.currentPage - 1) * this.itemsPerPage + meta.row + 1;
    },
    getMainProjects(page = 1) {
      // Memperbarui currentPage dan mengirim request untuk mendapatkan data baru
      this.currentPage = page;
      this.$inertia.get(route('billing'), { page });
    },
    rupiahFormat(amount) {
      // Format untuk nilai rupiah
      return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
      }).format(amount);
    },
  },
  mounted() {
    console.log('MainProjects Data:', this.mainprojects); // Cek apakah data dari props sudah benar
  },
};
</script>
