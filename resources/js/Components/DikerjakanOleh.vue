<template>
  <div>
    <div v-if="loading">Loading...</div>
    <div v-else>
      <div v-for="person in processedKaryawan" :key="person.id_karyawan">
        {{ person.nama }} ({{ person.bobot }})
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    data: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      karyawanData: [],
      loading: true,
    };
  },
  computed: {
    processedKaryawan() {
      const pls = this.data.split(',');
      return pls.filter(pl => pl).map(pl => {
        const cs = pl.indexOf('[');
        const id_karyawan = parseInt(pl.substring(0, cs)); // Convert to integer
        const bobot = pl.substring(cs + 1, pl.length - 1); // Extract bobot

        const karyawan = this.karyawanData.find(k => k.id_karyawan === id_karyawan);
        return karyawan ? { ...karyawan, bobot } : { nama: 'Tidak Ditemukan', bobot };
      });
    },
  },
  methods: {
    async fetchKaryawanData() {
      this.loading = true; // Set loading to true before fetching
      const ids = this.data.split(',').filter(pl => pl).map(pl => {
        const cs = pl.indexOf('[');
        return pl.substring(0, cs);
      });

      // Fetch data only if ids are present
      if (ids.length) {
        try {
          const response = await axios.post('/karyawan-by-ids', { ids });
          this.karyawanData = response.data;
        } catch (error) {
          console.error('Error fetching karyawan data:', error);
        }
      }
      this.loading = false; // Set loading to false after fetching
    },
  },
  watch: {
    data: {
      immediate: true,
      handler() {
        this.fetchKaryawanData(); // Fetch data whenever the data prop changes
      },
    },
  },
};
</script>

<style scoped>
/* Add necessary styles here */
</style>