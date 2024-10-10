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
            <div class="overflow-x-auto">
              <Table 
                :data="mainprojects.data" 
                :columns="columns" 
                :totalItems="totalItems" 
                :currentPage="currentPage" 
                :itemsPerPage="itemsPerPage"
                :links="links"
              >
                <!-- <template #trf="{ row }">
                  <RupiahFormat :data="Number(row.trf) || 0"  />
                </template>
                <template #biaya="{ row }">
                  <RupiahFormat :data="Number(row.biaya) || 0" />
                </template>
                <template #dibayar="{ row }">
                  <RupiahFormat :data="Number(row.dibayar) || 0" />
                </template> -->
                <template #dikerjakan_oleh="{ row }">
                  <DikerjakanOleh :data="row.dikerjakan_oleh" />
                   <!-- {{ row.dikerjakan_oleh }} -->
                </template> 
              </Table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import RupiahFormat from '@/Components/RupiahFormat.vue';
import DikerjakanOleh from '@/Components/DikerjakanOleh.vue';
import Table from '@/Components/Table.vue';

export default {
  props: {
    mainprojects: {
      type: Object,
      required: true,
    },
  },
  components: {
    AuthenticatedLayout,
    RupiahFormat,
    DikerjakanOleh,
    Table,
  },
  data() {
    return {
      columns: [
        { field: 'jenis', label: 'Jenis', sortable: true },
        { field: 'webhost.nama_web', label: 'Nama Website', sortable: true, class: 'sticky left-0 z-10' },
        { field: 'webhost.paket.paket', label: 'Paket', sortable: true },
        { field: 'deskripsi', label: 'Deskripsi', sortable: true },
        { field: 'trf', label: 'Trf', sortable: true },
        { field: 'tgl_masuk', label: 'Tanggal Masuk', sortable: true },
        { field: 'tgl_deadline', label: 'Tanggal Deadline', sortable: true },
        { field: 'biaya', label: 'Biaya', sortable: true },
        { field: 'dibayar', label: 'Dibayar', sortable: true },
        { field: 'kurang', label: 'Kurang', sortable: true },
        { field: 'saldo', label: 'Saldo', sortable: true },
        { field: 'webhost.hp', label: 'HP', sortable: true },
        { field: 'webhost.telegram', label: 'Telegram', sortable: true },
        { field: 'webhost.hpads', label: 'HP Ads', sortable: true },
        { field: 'webhost.wa', label: 'WhatsApp', sortable: true },
        { field: 'webhost.email', label: 'Email', sortable: true },
        { field: 'dikerjakan_oleh', label: 'Dikerjakan Oleh', sortable: true },
        // { field: 'action', label: 'Action' },
      ],
      currentPage: this.mainprojects.current_page || 1,
      itemsPerPage: this.mainprojects.per_page || 100,
      totalItems: this.mainprojects.total || 0,
      links: this.mainprojects.links || [],
    };
  },
  mounted() {
    // console.log(this.mainprojects);
  },
  watch: {
    mainprojects(newVal) {
      this.currentPage = newVal.current_page;
      this.totalItems = newVal.total;
      this.itemsPerPage = newVal.per_page;
    },
  },
};
</script>

<style scoped>
/* Tambahkan gaya yang diperlukan di sini */
</style>