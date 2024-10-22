<template>
  <AuthenticatedLayout title="Billing">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Billing</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-4 shadow-md rounded">
          <div class="flex justify-left mb-3">
            <Button @click="showModal = true">Tambah Data</Button>
            <Modal :show="showModal" :closeable="true" @close="showModal = false">
              <div class="p-4">
                <h2 class="text-lg font-bold mb-4">Tambah Data</h2>
                <form @submit.prevent="submit">
                  <div v-for="column in columns" :key="column.accessorKey">
                    <div class="grid w-full mb-3 items-center gap-1.5">
                      <Label>{{ column.header }} - {{ column.formType }}</Label>

                      <Input 
                      v-if="column.formType === 'text'" 
                      :label="column.label" 
                      :name="column.accessorKey"
                      type="text"
                      v-model="formData[column.accessorKey]"
                      />

                      <Input
                        v-if="column.formType === 'currency'"
                        :label="column.label"
                        :name="column.accessorKey"
                        type="text"
                        v-model="formData[column.accessorKey]"
                        @input="updateCurrency"
                        @blur="formatCurrency"
                      />

                      <Select 
                      v-if="column.formType === 'select'" 
                      :multiple="column.multiple"
                      v-model="formData[column.accessorKey]">
                        <SelectTrigger class="w-full">
                          <SelectValue :placeholder="column.label" />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectGroup>
                            <SelectLabel>{{ column.header }}</SelectLabel>
                            <SelectItem
                              v-for="option in column.formOptions"
                              :key="option.value"
                              :value="option.value.toString()"
                            >
                              {{ option.label }}
                            </SelectItem>
                          </SelectGroup>
                        </SelectContent>
                      </Select>

                      <!-- Date Picker -->
                      <Popover v-if="column.formType === 'date'">
                        <PopoverTrigger as-child>
                            <Button
                              variant="outline"
                              :class="['w-full ps-3 text-start font-normal', !modelValue && 'text-muted-foreground']"
                            >
                              <span>{{ formatDate(formData[column.accessorKey]) }}</span>
                              <CalendarIcon class="ms-auto h-4 w-4 opacity-50" />
                            </Button>
                        </PopoverTrigger>
                        <PopoverContent class="w-auto p-0">
                          <Calendar
                            v-model="formData[column.accessorKey]"
                            calendar-label="Tanggal"
                            initial-focus
                          />
                        </PopoverContent>
                      </Popover>
                    </div>
                  </div>
                  <Button @click="showModal = false" variant="destructive">Close</Button>
                  <Button type="submit"  class="ml-2">Submit</Button>
                </form>
              </div>
            </Modal>
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
import StatisticsCard from '@/Components/StatisticsCard.vue';
import SearchInput from '@/Components/SearchInput.vue';
import { Button } from '@/components/ui/button';
import { Calendar as CalendarIcon } from 'lucide-vue-next';
import { Calendar } from '@/Components/ui/calendar';
import { Input } from '@/Components/ui/input';
import { Label } from '@/components/ui/label';
import { BIconThreeDotsVertical } from 'bootstrap-icons-vue';
import { 
  Popover, 
  PopoverContent, 
  PopoverTrigger
} from '@/Components/ui/popover';
import {   
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue, 
} from '@/Components/ui/select';
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
    listpaket: Array,
    modelValue: String,
    listkaryawan: Array,
  },
  components: {
    AuthenticatedLayout,
    Modal,
    DataTable,
    Pagination,
    StatisticsCard,
    SearchInput,
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
    Button,
    Input,
    Label,
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
    Calendar,
    CalendarIcon,
    BIconThreeDotsVertical,
    Popover,
    PopoverContent,
    PopoverTrigger,
  },
  emits: ['update:modelValue'],
  computed: {
    paketArray() {
      return Object.values(this.listpaket);
    },
    df() {
      return new Intl.DateTimeFormat('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
      });
    },
  },
  mounted() {
    console.log('formData awal:', this.formData);
  },
  data() {
    return {
      showModal: false,
      formData: {},
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
    updateCurrency(event) {
      let value = event.target.value;  // Ambil nilai input
      // Hilangkan simbol mata uang dan karakter non-numeric
      let numericValue = value.replace(/[^\d]/g, '');  
      // Hilangkan 0 di depan (leading zeros)
      numericValue = numericValue.replace(/^0+/, '');

      // Simpan nilai numerik ke formData
      this.formData[event.target.name] = numericValue;  
    },
    
    formatCurrency(event) {
      const name = event.target.name;
      const numericValue = this.formData[name] || '';  // Ambil nilai numerik dari formData
      event.target.value = this.formatRupiah(numericValue);  // Format kembali untuk tampilan
    },

    formatRupiah(value) {
      if (!value) return 'Rp 0';
      // Format nilai menjadi format mata uang
      return 'Rp ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    },
    isDateValid(date) {
      return date instanceof Date && !isNaN(date);
    },
    formatDate(date) {
      if (!date) return 'Pilih Tanggal';
      return new Intl.DateTimeFormat('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
      }).format(new Date(date));
    },
    updateDate(date, columnKey) {
      if (date) {
        this.formData[columnKey] = date.toISOString().split('T')[0]; // Store in YYYY-MM-DD format
      } else {
        this.formData[columnKey] = null; // Set null if no date
      }
      console.log('Tanggal diperbarui:', this.formData[columnKey]);
    },
    submit() {
      // Logika untuk mengirim data form
      console.log('Data form:', this.formData);
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
      {
        accessorKey: 'jenis',
        header: 'Jenis',
        formInput: true,
        formType: 'select',
        formOptions: this.jenispaket.map((paket) => ({
          value: paket,
          label: paket
        }))
      },
      { 
        accessorKey: 'webhost.nama_web', 
        header: 'Nama Website',
        formInput: true,
        class: 'sticky left-0 bg-white group-hover:bg-gray-50',
        formType: 'text',
      },
      { 
        accessorKey: 'webhost.paket.paket', 
        header: 'Paket',
        formInput: true,
        formType: 'select',
        formOptions: this.listpaket.map((paket) => ({
          value: paket.id_paket,
          label: paket.paket
        })),
        cell: (row) => {
          // console.log(row.row); 
          return row.row.original.webhost?.paket?.paket || 'N/A';
        }
      },
      { 
        accessorKey: 'deskripsi', 
        header: 'Deskripsi',
        formInput: true,
        formType: 'text',
      },
      { 
        accessorKey: 'trf', 
        header: 'Trf',
        cell: (row) => formatRupiah(row.getValue()),
        class: 'text-nowrap',
        formInput: true,
        formType: 'currency',
      },
      {
        accessorKey: 'tgl_masuk', 
        header: 'Tgl Masuk',
        cell: (row) => formatDate(row.getValue()),
        class: 'text-nowrap',
        formInput: true,
        formType: 'date',
      },
      { 
        accessorKey: 'tgl_deadline', 
        header: 'Tgl Deadline',
        cell: (row) => formatDate(row.getValue()),
        class: 'text-nowrap',
        formInput: true,
        formType: 'date',
      },
      { 
        accessorKey: 'biaya', 
        header: 'Biaya',
        cell: (row) => formatRupiah(row.getValue()),
        class: 'text-nowrap',
        formInput: true,
        formType: 'currency',
      },
      { 
        accessorKey: 'dibayar', 
        header: 'Dibayar',
        cell: (row) => formatRupiah(row.getValue()),
        class: 'text-nowrap',
        formInput: true,
        formType: 'currency',
      },
      { 
        accessorKey: 'kurang', 
        header: 'Kurang',
        cell: (row) => formatRupiah(row.getValue()),
        class: 'text-nowrap',
        formInput: true,
        formType: 'currency',
      },
      { 
        accessorKey: 'saldo', 
        header: 'Saldo',
        cell: (row) => formatRupiah(row.getValue()),
        class: 'text-nowrap',
        formInput: true,
        formType: 'currency',
      },
      { 
        accessorKey: 'webhost.hp', 
        header: 'HP',
        formInput: true,
        formType: 'text',
      },
      { 
        accessorKey: 'webhost.telegram', 
        header: 'Telegram',
        formInput: true,
        formType: 'text',
      },
      { 
        accessorKey: 'webhost.hpads', 
        header: 'HP Ads',
        formInput: true,
        formType: 'text',
      },
      { 
        accessorKey: 'webhost.wa', 
        header: 'WhatsApp',
        formInput: true,
        formType: 'text',
      },
      { 
        accessorKey: 'webhost.email', 
        header: 'Email',
        formInput: true,
        formType: 'text',
      },
      { 
        accessorKey: 'karyawan_data[0].nama', 
        header: 'Dikerjakan Oleh',
        cell: (row) => getKaryawanName(row),
        class: 'text-nowrap',
        formInput: true,
        formType: 'select',
        multiple: true,
        formOptions: this.listkaryawan.map((karyawan) => ({
          value: karyawan.id_karyawan,
          label: karyawan.nama
        }))
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