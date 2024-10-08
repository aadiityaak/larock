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
              <DataTable :data="mainprojects.data" :columns="columns">
                <template v-slot:default="slotProps">
                  <tr v-for="(row, index) in slotProps.data" :key="row.id">
                    <td>{{ (currentPage - 1) * itemsPerPage + index + 1 }}</td>
                    <td>{{ row.jenis || '-' }}</td>
                    <td>{{ row.webhost?.nama_web || '-' }}</td>
                    <td>{{ row.webhost?.paket?.paket || '-' }}</td>
                    <td>{{ row.deskripsi || '-' }}</td>
                    <td><RupiahFormat :amount="row.trf" /></td>
                    <td>{{ row.tgl_masuk || '-' }}</td>
                    <td>{{ row.tgl_deadline || '-' }}</td>
                    <td><RupiahFormat :amount="row.biaya" /></td>
                    <td><RupiahFormat :amount="row.dibayar" /></td>
                    <td><RupiahFormat :amount="row.kurang" /></td>
                    <td><RupiahFormat :amount="row.saldo" /></td>
                    <td>{{ row.webhost?.hp || '-' }}</td>
                    <td>{{ row.webhost?.telegram || '-' }}</td>
                    <td>{{ row.webhost?.hpads || '-' }}</td>
                    <td>{{ row.webhost?.wa || '-' }}</td>
                    <td>{{ row.webhost?.email || '-' }}</td>
                    <td><DikerjakanOleh :opl="row.dikerjakan_oleh" /></td>
                    <td>
                      <!-- <button @click="editRow(row.id)">Edit</button> -->
                    </td>
                  </tr>
                </template>
              </DataTable>
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
import DataTable from '@/Components/DataTable.vue';

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
    DataTable,
  },
  data() {
    return {
      columns: [
        // { label: 'No', sortable: false },
        { field: 'jenis', label: 'Jenis', sortable: true },
        { field: 'webhost.nama_web', label: 'Nama Website', sortable: true },
        { field: 'webhost.paket.paket', label: 'Paket', sortable: true },
        { field: 'deskripsi', label: 'Deskripsi', sortable: true },
        { field: 'trf', label: 'Tarif', sortable: true },
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
        { field: 'action', label: 'Action' },
      ],
      currentPage: 1,
      itemsPerPage: 10, // Sesuaikan jumlah item per halaman
    };
  },
  mounted() {
    console.log(this.mainprojects);
  },
  methods: {
    getMainProjects(page = 1) {
      this.$inertia.get(route('billing'), { page });
    },
  },
};
</script>

<style scoped>
/* Add any necessary styles here */
</style>