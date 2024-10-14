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
            <Table>
              <TableHeader>
                <TableRow>
                  <TableCell>Jenis</TableCell>
                  <TableCell class="sticky left-0 z-10 shadow">Nama Website</TableCell>
                  <TableCell>Paket</TableCell>
                  <TableCell>Deskripsi</TableCell>
                  <TableCell>Trf</TableCell>
                  <TableCell>Tgl Masuk</TableCell>
                  <TableCell>Tgl Deadline</TableCell>
                  <TableCell>Biaya</TableCell>
                  <TableCell>Dibayar</TableCell>
                  <TableCell>Kurang</TableCell>
                  <TableCell>Saldo</TableCell>
                  <TableCell>HP</TableCell>
                  <TableCell>Telegram</TableCell>
                  <TableCell>HP Ads</TableCell>
                  <TableCell>WhatsApp</TableCell>
                  <TableCell>Email</TableCell>
                  <TableCell>Dikerjakan Oleh</TableCell>
                  <TableCell class="sticky right-0 z-10 shadow">Tindakan</TableCell>
                </TableRow>
              </TableHeader>
              <TableBody>
                <TableRow v-for="(project, index) in mainprojects.data" :key="index" class="group">
                  <TableCell>{{ project.jenis }}</TableCell>
                  <TableCell class="sticky left-0 z-10 shadow bg-white group-hover:bg-gray-50">{{ project.webhost.nama_web }}</TableCell>
                  <TableCell>{{ project.webhost.paket?.paket}}</TableCell>
                  <TableCell>{{ project.deskripsi }}</TableCell>
                  <TableCell>{{ project.trf }}</TableCell>
                  <TableCell>{{ project.tgl_masuk }}</TableCell>
                  <TableCell>{{ project.tgl_deadline }}</TableCell>
                  <TableCell>{{ project.biaya }}</TableCell>
                  <TableCell>{{ project.dibayar }}</TableCell>
                  <TableCell>{{ project.kurang }}</TableCell>
                  <TableCell>{{ project.saldo }}</TableCell>
                  <TableCell>{{ project.webhost.hp }}</TableCell>
                  <TableCell>{{ project.webhost.telegram }}</TableCell>
                  <TableCell>{{ project.webhost.hpads }}</TableCell>
                  <TableCell>{{ project.webhost.wa }}</TableCell>
                  <TableCell>{{ project.webhost.email }}</TableCell>
                  <TableCell>{{ project.karyawan_data[0]?.nama }} {{ project.karyawan_data[0]?.bobot }}</TableCell>
                  <TableCell class="sticky right-0 z-10 shadow bg-white group-hover:bg-gray-50">
                    <!-- Dropdown actions for each project -->
                    <DropdownMenu>
                      <DropdownMenuTrigger>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                          <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                        </svg>
                      </DropdownMenuTrigger>
                      <DropdownMenuContent>
                        <DropdownMenuLabel class="flex">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                          </svg>
                          <span class="px-2">Edit</span>
                        </DropdownMenuLabel>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem class="text-red-500 flex">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                          </svg>
                          <span class="px-2">Hapus</span>
                        </DropdownMenuItem>
                      </DropdownMenuContent>
                    </DropdownMenu>
                  </TableCell>
                </TableRow>
              </TableBody>
            </Table>
          </div> <!-- End oveflow-x-auto -->


          <template>
            <Pagination v-slot="{ page }" :total="totalItems" :sibling-count="1" show-edges :default-page="currentPage">
              <PaginationList v-slot="{ items }" class="flex items-center gap-1">
                <PaginationFirst @click="fetchPage(1)" />
                <PaginationPrev @click="fetchPage(page - 1)" />

                <template v-for="(item, index) in items" :key="index">
                  <PaginationListItem v-if="item.type === 'page'" :value="item.value" as-child>
                    <Button class="w-10 h-10 p-0" :variant="item.value === page ? 'default' : 'outline'" @click="fetchPage(item.value)">
                      {{ item.value }}
                    </Button>
                  </PaginationListItem>
                  <PaginationEllipsis v-else :key="item.type" :index="index" />
                </template>

                <PaginationNext @click="fetchPage(page + 1)" />
                <PaginationLast @click="fetchPage(Math.ceil(totalItems / itemsPerPage))" />
              </PaginationList>
            </Pagination>
          </template>
                
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ResetSearch from '@/Components/ResetSearch.vue';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import { Table, TableHeader, TableBody, TableRow, TableCell } from '@/Components/ui/table';
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
} from '@/components/ui/button'

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

  },
  components: {
    AuthenticatedLayout,
    Table,
    TableHeader,
    TableBody,
    TableRow,
    TableCell,
    Datepicker,
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
    ResetSearch
  },

  data() {
    return {
      table: null,
      queryCari: this.qcari,
      queryDate: this.qdate,
      queryJenis: this.qjenis,
      currentPage: this.mainprojects.current_page || 1,
      itemsPerPage: this.mainprojects.per_page || 100,
      totalItems: this.mainprojects.total || 0,
      links: this.mainprojects.links || [],
    }
  },
  async mounted() {
    console.log(this.mainprojects);
    try {
      this.table = await this.fetchTableData();
    } catch (error) {
    }
  },
  methods: {
    async fetchTableData() {
      const columns = await this.getColumns();
      return {
        getColumn: (id) => columns.find(column => column.field === id),
        getAllColumns: () => columns,
      };
    },
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
      };

      Object.keys(params).forEach(key => params[key] === '' && delete params[key]);
      this.$inertia.get(route('billing'), params);
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
      };

      // Hapus parameter yang kosong dari objek params
      Object.keys(params).forEach(key => params[key] === '' && delete params[key]);

      this.$inertia.get(route('billing'), params);
    },
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