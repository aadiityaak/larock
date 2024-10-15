<template>
  <AuthenticatedLayout title="Billing">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Billing</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-4 shadow-md rounded">

          <div class="flex justify-left">
            <!-- Modal Input Project -->
            <button @click="showModal = true">Tambah Data</button>
            <Modal
              :show="showModal"
              :closeable="true"
              @close="showModal = false"
            >
              <div class="p-4">
                <h2 class="text-lg font-bold">Tambah Data</h2>
                <form @submit.prevent="submit">
                  <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="jenis" >Jenis </label>
                    <select v-model="formJenis" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                      <option v-for="(jenispaket, index) in jenispaket" :key="index" :value="jenispaket">{{jenispaket}}</option>
                    </select>
                  </div>
                  <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_web">Nama Web</label>
                    <input v-model="formNama_web" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                  </div>
                  <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                    <input v-model="formEmail" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">  
                  </div>
                  <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                    <input v-model="formEmail" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">  
                  </div>
                </form> 
                <button @click="showModal = false" class="mt-4">Close</button>
              </div>
            </Modal>
          </div>

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
                    v-model="queryCari"
                    placeholder="Cari Project"
                    @input="searchData"
                    class="block w-full rounded-md border border-gray-300 shadow-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                  />
                  <ResetSearch :isVisible="!!queryCari" @reset="clearSearch" />
                </div>
                <div class="flex relative">
                  <select
                    v-model="queryJenis"
                    class="block w-full rounded-md border border-gray-300 shadow-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
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
                  :isVisible="!!queryJenis" 
                  @reset="clearJenis"
                  />
                </div>
                <div class="ml-2 flex relative">
                  <Datepicker 
                    v-model="queryDate" 
                    range 
                    :enable-time-picker="false" 
                    :multi-calendars="{ solo: true }" 
                    placeholder="Pilih Rentang tanggal"
                    @change="searchData"
                  >
                    <template #day="{ day, date }">
                      <span class="datepicker-day">{{ day }}</span>
                    </template>
                  </Datepicker>
                </div>
            </div>
          </div>

          <div class="overflow-x-auto">
            <DataTable :columns="columns" :data="mainprojects.data" />
          </div> <!-- End oveflow-x-auto -->

          <div class="flex justify-end mt-4">
            <Pagination v-slot="{ page }" :current-page="mainprojects.current_page" :total="mainprojects.last_page" :sibling-count="1" show-edges :default-page="currentPage">
              <PaginationList v-slot="{ items }" class="flex items-center gap-1">
                <PaginationFirst @click="fetchPage(1)" />
                <PaginationPrev @click="fetchPage(mainprojects.current_page - 1)" />

                <template v-for="(item, index) in items" :key="index">
                  <PaginationListItem v-if="item.type === 'page'" :value="item.value" as-child>
                    <Button class="w-10 h-10 p-0" :variant="item.value === page ? 'default' : 'outline'" @click="fetchPage(item.value)">
                      {{ item.value }}
                    </Button>
                  </PaginationListItem>
                  <PaginationEllipsis v-else :index="index" />
                </template>

                <PaginationNext @click="fetchPage(mainprojects.current_page + 1)" />
                <PaginationLast @click="fetchPage(mainprojects.last_page)" />
              </PaginationList>
            </Pagination>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
import { h } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ResetSearch from '@/Components/ResetSearch.vue';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import DataTable from '@/Components/DataTable.vue';
import Modal from '@/Components/Modal.vue';
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/Components/ui/dropdown-menu';

import {
  Pagination,
  PaginationEllipsis,
  PaginationFirst,
  PaginationLast,
  PaginationList,
  PaginationListItem,
  PaginationNext,
  PaginationPrev,
} from '@/Components/ui/pagination'

import {
  Button,
} from '@/Components/ui/button';
import { BIconThreeDotsVertical } from 'bootstrap-icons-vue';
export default {
  props: {
    mainprojects: Object,
    qcari: String,
    listpaket: Array,
    jenispaket: Array,
    qjenis: String,
    qdate: Array,
    project_bulan_ini: Number,
    prediksi_bulan_ini: Number,
    emptyMessage: String,
    qdirection: String,
    qsort: String,
  },
  components: {
    AuthenticatedLayout,
    Datepicker,
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
    ResetSearch,
    Button,
    Pagination,
    PaginationEllipsis,
    PaginationFirst,
    PaginationLast,
    PaginationList,
    PaginationListItem,
    PaginationNext,
    PaginationPrev,
    DataTable,
    Modal,
    h
  },

  data() {
    return {
      table: null,
      columns: this.getColumns(),
      queryCari: this.qcari,
      queryDate: this.qdate,
      queryJenis: this.qjenis,
      currentPage: this.mainprojects.current_page || 1,
      itemsPerPage: this.mainprojects.per_page || 100,
      queryDirection: this.qdirection || 'asc',
      querySort: this.qsort || 'id',
      showModal: false,
    }
  },
  methods: {
    openModal() {
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false; 
    },
    sortColumn(column) {
      const direction = this.sort === column && this.direction === 'asc' ? 'desc' : 'asc';
      this.$inertia.get(route('billing'), { sort: column, direction });
    },
    getColumns() {
      const formatCurrency = (value) => {
        return new Intl.NumberFormat('id-ID', {
          style: 'currency',
          currency: 'IDR',
        }).format(Number.parseFloat(value) || 0);
      };

      const getWebhostValue = (row, key, defaultValue = '-') => {
        const webhost = row.original.webhost || {};
        return webhost[key] || defaultValue;
      };

      const getKaryawanName = (row) => {
        const karyawan = row.original.karyawan_data || [];
        return karyawan.length > 0 ? karyawan[0].nama + ' ' + karyawan[0].bobot : '-';
      };

      return [
        {
          accessorKey: 'jenis',
          header: () => h('div', {}, 'Jenis'),
          cell: ({ row }) => h('div', {}, row.getValue('jenis')),
          sortable: true,
        },
        {
          accessorKey: 'webhost.nama_web',
          header: () => h('div', { class: 'cursor-pointer', onClick: () => this.sortColumn('webhost.nama_web') }, 'Nama Website'),
          cell: ({ row }) => h('div', {}, getWebhostValue(row, 'nama_web')),
          class: 'sticky left-0 z-10 shadow bg-white group-hover:bg-gray-50',
          sortable: true,
        },
        {
          accessorKey: 'webhost.paket.paket',
          header: () => h('div', {}, 'Paket'),
          cell: ({ row }) => h('div', {}, getWebhostValue(row, 'paket')?.paket),
          sortable: true,
        },
        {
          accessorKey: 'deskripsi',
          header: () => h('div', {}, 'Deskripsi'),
          cell: ({ row }) => h('div', {}, row.getValue('deskripsi')),
          sortable: true,
        },
        {
          accessorKey: 'trf',
          header: () => h('div', {}, 'Trf'),
          cell: ({ row }) => h('div', {}, formatCurrency(row.getValue('trf'))),
          sortable: true,
          type: 'rupiah',
        },
        {
          accessorKey: 'tgl_masuk',
          header: () => h('div', {}, 'Tgl Masuk'),
          cell: ({ row }) => h('div', {}, new Date(
            row.getValue('tgl_masuk')).toLocaleDateString(
              'id-ID',
              {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
              }
            )
          ),
          class: 'text-nowrap',
          sortable: true,
          type: 'date',
        },
        {
          accessorKey: 'tgl_deadline',
          header: () => h('div', {}, 'Tgl Deadline'),
          cell: ({ row }) => h('div', {}, new Date(row.getValue('tgl_deadline')).toLocaleDateString(
            'id-ID',
            {
              year: 'numeric',
              month: 'long',
              day: 'numeric',
            }
          )),
          class: 'text-nowrap',
          sortable: true,
          type: 'date',
        },
        {
          accessorKey: 'biaya',
          header: () => h('div', {}, 'Biaya'),
          cell: ({ row }) => h('div', {}, formatCurrency(row.getValue('biaya'))),
          sortable: true,
          type: 'rupiah',
        },
        {
          accessorKey: 'dibayar',
          header: () => h('div', {}, 'Dibayar'),
          cell: ({ row }) => h('div', {}, formatCurrency(row.getValue('dibayar'))),
          sortable: true,
          type: 'rupiah',
        },
        {
          accessorKey: 'kurang',
          header: () => h('div', {}, 'Kurang'),
          cell: ({ row }) => h('div', {}, formatCurrency(row.getValue('kurang'))),
          sortable: true,
          type: 'rupiah',
        },
        {
          accessorKey: 'saldo',
          header: () => h('div', {}, 'Saldo'),
          cell: ({ row }) => h('div', {}, formatCurrency(row.getValue('saldo'))),
          sortable: true,
          type: 'rupiah',
        },
        {
          accessorKey: 'webhost.hp',
          header: () => h('div', {}, 'HP'),
          cell: ({ row }) => h('div', {}, getWebhostValue(row, 'hp')),
          sortable: true,
        },
        {
          accessorKey: 'webhost.telegram',
          header: () => h('div', {}, 'Telegram'),
          cell: ({ row }) => h('div', {}, getWebhostValue(row, 'telegram')),
          sortable: true,
        },
        {
          accessorKey: 'webhost.hpads',
          header: () => h('div', {}, 'HP Ads'),
          cell: ({ row }) => h('div', {}, getWebhostValue(row, 'hpads')),
          sortable: true,
        },
        {
          accessorKey: 'webhost.wa',
          header: () => h('div', {}, 'WhatsApp'),
          cell: ({ row }) => h('div', {}, getWebhostValue(row, 'wa')),
          sortable: true,
        },
        {
          accessorKey: 'webhost.email',
          header: () => h('div', {}, 'Email'),
          cell: ({ row }) => h('div', {}, getWebhostValue(row, 'email')),
          sortable: true,
        },
        {
          accessorKey: 'karyawan_data[0].nama',
          header: () => h('div', {}, 'Dikerjakan Oleh'),
          cell: ({ row }) => h('div', {}, getKaryawanName(row)),
          class: 'text-nowrap',
          sortable: true,
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
    getCanHide(column) {
      return column.field === 'tindakan';
    },
    clearSearch() {
      this.queryCari = '';
      this.searchData();
    },
    clearJenis() {
      this.queryJenis = '';
      this.searchData();
    },
    searchData() {
      const startDate = this.queryDate && this.queryDate[0] ? this.queryDate[0] : ''; 
      const endDate = this.queryDate && this.queryDate[1] ? this.queryDate[1] : ''; 

      const params = {
        cari: this.queryCari,
        jenis: this.queryJenis,
        perPage: this.itemsPerPage,
        startDate,
        endDate,
        direction: this.queryDirection,
        sort: this.querySort
      };

      Object.keys(params).forEach(key => params[key] === '' && delete params[key]);
      this.$inertia.get(route('billing'), params, {
        preserveState: true,
        preserveState: true
      });
    },
    fetchPage(page) {
      const startDate = this.queryDate && this.queryDate[0] ? this.queryDate[0] : '';
      const endDate = this.queryDate && this.queryDate[1] ? this.queryDate[1] : '';

      const params = {
        cari: this.queryCari,
        jenis: this.queryJenis,
        perPage: this.itemsPerPage,
        page,
        startDate,
        endDate,
        direction: this.queryDirection,
        sort: this.querySort
      };

      Object.keys(params).forEach(key => params[key] === '' && delete params[key]);
      this.$inertia.get(route('billing'), params);
    },
  },
};
</script>
