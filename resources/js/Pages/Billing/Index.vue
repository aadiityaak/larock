<template>
  <AuthenticatedLayout title="Billing">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Billing</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-4 shadow-md rounded">
          <div class="flex justify-left">
            <button @click="showModal = true">Tambah Data</button>
            <Modal :show="showModal" :closeable="true" @close="showModal = false">
              <div class="p-4">
                <h2 class="text-lg font-bold">Tambah Data</h2>
                <form @submit.prevent="submit">
                  <InputField label="Jenis" v-model="formJenis" :options="jenispaket" />
                  <InputField label="Nama Web" v-model="formNama_web" />
                  <InputField label="Email" v-model="formEmail" type="email" />
                  <button @click="showModal = false" class="mt-4">Close</button>
                </form>
              </div>
            </Modal>
          </div>

          <div class="m-4">
            <div class="grid gap-2 grid-cols-5">
              <StatisticsCard title="Project Bulan ini" :value="project_bulan_ini" color="green" />
              <StatisticsCard title="Prediksi Bulan ini" :value="prediksi_bulan_ini" color="blue" />
              <SearchInput v-model="queryCari" @input="searchData" />
              <SelectInput v-model="queryJenis" :options="jenispaket" @change="searchData" />
              <Datepicker v-model="queryDate" @change="searchData" />
            </div>
          </div>

          <div class="overflow-x-auto">
            <DataTable :columns="columns" :data="mainprojects.data" />
          </div>

          <Pagination
            :currentPage="mainprojects.current_page"
            :lastPage="mainprojects.last_page"
            @page-changed="fetchPage"
          />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
import { h } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import DataTable from '@/Components/DataTable.vue';
import Pagination from '@/Components/Pagination.vue';
import InputField from '@/Components/InputField.vue';
import StatisticsCard from '@/Components/StatisticsCard.vue';
import SearchInput from '@/Components/SearchInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import { BIconThreeDotsVertical } from 'bootstrap-icons-vue';
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/Components/ui/dropdown-menu';


export default {
  props: {
    mainprojects: Object,
    project_bulan_ini: Number,
    prediksi_bulan_ini: Number,
    jenispaket: Array,
    
  },
  components: {
    AuthenticatedLayout,
    Modal,
    DataTable,
    Pagination,
    InputField,
    StatisticsCard,
    SearchInput,
    SelectInput,
    Datepicker,
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
  },
  
  data() {
    return {
      showModal: false,
      formJenis: '',
      formNama_web: '',
      formEmail: '',
      queryCari: '',
      queryJenis: '',
      queryDate: [],
      columns: this.getColumns(),
    };
  },
  
  methods: {
    submit() {
      // Logika untuk mengirim data form
      // console.log("Data submitted:", { formJenis: this.formJenis, formNama_web: this.formNama_web, formEmail: this.formEmail });
      this.showModal = false;
    },
    searchData() {
      const startDate = this.queryDate[0] || '';
      const endDate = this.queryDate[1] || '';
      const params = {
        cari: this.queryCari,
        jenis: this.queryJenis,
        startDate,
        endDate,
      };
      this.$inertia.get(route('billing'), params);
    },
    fetchPage(page) {
      this.$inertia.get(route('billing'), { page, cari: this.queryCari, jenis: this.queryJenis });
    },
    getColumns() {
      const getKaryawanName = (row) => {
        const karyawan = row.row.original.karyawan_data || [];
        return karyawan.length > 0 ? karyawan[0].nama + ' ' + karyawan[0].bobot : '-';
      };

      const formatRupiah = (value) => {
        if (!value) return 'Rp 0';
        return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
      };

      const formatDate = (value) => {
        if (!value) return '-';
        return new Date(value).toLocaleDateString('id-ID', {
          day: 'numeric',
          month: 'long',
          year: 'numeric',
        });
      };

      return [
      { accessorKey: 'jenis', header: 'Jenis' },
      { 
        accessorKey: 'webhost.nama_web', 
        header: 'Nama Website',
        class: 'sticky left-0 bg-white group-hover:bg-gray-50',
       },
      { accessorKey: 'webhost.paket.paket', header: 'Paket' },
      { accessorKey: 'deskripsi', header: 'Deskripsi' },
      { 
        accessorKey: 'trf', 
        header: 'Trf',
        cell: (row) => formatRupiah(row.getValue()),
        class: 'text-nowrap',
       },
      { 
        accessorKey: 'tgl_masuk', 
        header: 'Tgl Masuk',
        cell: (row) => formatDate(row.getValue()),
        class: 'text-nowrap',
      },
      { 
        accessorKey: 'tgl_deadline', 
        header: 'Tgl Deadline',
        cell: (row) => formatDate(row.getValue()),
        class: 'text-nowrap',
      },
      { 
        accessorKey: 'biaya', 
        header: 'Biaya',
        cell: (row) => formatRupiah(row.getValue()),
        class: 'text-nowrap',
       },
      { 
        accessorKey: 'dibayar', 
        header: 'Dibayar',
        cell: (row) => formatRupiah(row.getValue()),
        class: 'text-nowrap',
      },
      { 
        accessorKey: 'kurang', 
        header: 'Kurang',
        cell: (row) => formatRupiah(row.getValue()),
        class: 'text-nowrap',
      },
      { 
        accessorKey: 'saldo', 
        header: 'Saldo',
        cell: (row) => formatRupiah(row.getValue()),
        class: 'text-nowrap',
      },
      { accessorKey: 'webhost.hp', header: 'HP' },
      { accessorKey: 'webhost.telegram', header: 'Telegram' },
      { accessorKey: 'webhost.hpads', header: 'HP Ads' },
      { accessorKey: 'webhost.wa', header: 'WhatsApp' },
      { accessorKey: 'webhost.email', header: 'Email' },
      { 
        accessorKey: 'karyawan_data[0].nama', 
        header: 'Dikerjakan Oleh',
        cell: (row) => getKaryawanName(row),
        class: 'text-nowrap',
       },
       {
          accessorKey: 'tindakan',
          header: () => h('div', {}, 'Tindakan'),
          cell: ({ row }) => h('div', {}, [
            h(DropdownMenu, {}, {
              default: () => [
                h(DropdownMenuTrigger, { class: 'w-full text-center' }, () => [
                  h(BIconThreeDotsVertical, {
                    class: 'w-5 h-5 text-gray-400 group-hover:text-gray-500 mx-auto'
                  })
                ]),
                h(DropdownMenuContent, {}, () => [
                  h('span', {
                    onClick: () => handleEdit(row.original.id),
                    class: 'cursor-pointer block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100'
                  }, 'Edit'),
                  h(DropdownMenuSeparator, {}),
                  h('span', {
                    onClick: () => handleDelete(row.original.id),
                    class: 'cursor-pointer block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100'
                  }, 'Hapus')
                ])
              ]
            })
          ]),
          sortable: false,
          class: 'sticky right-0 z-10 shadow bg-white group-hover:bg-gray-50',
        }
      ];
    },
  },
};
</script>