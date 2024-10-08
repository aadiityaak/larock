<template>
    <div>
      <div v-if="loading">Loading...</div>
      <div v-else>
        <div v-for="person in processedKaryawan" :key="person.id_karyawan">
          {{ person.nama }} bobot{{ person.bobot }}
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      opl: {
        type: String,
        required: true
      }
    },
    data() {
      return {
        karyawanData: [],
        loading: true
      };
    },
    computed: {
        processedKaryawan() {
        const pls = this.opl.split(',');
        return pls.filter(pl => pl).map(pl => {
            const cs = pl.indexOf('[');
            const id_karyawan = parseInt(pl.substring(0, cs)); // Konversi ke integer
            const bobot = pl.substring(cs + 1, pl.length - 1); // Mengambil bobot pengerjaan di dalam []
            const karyawan = this.karyawanData.find(k => k.id_karyawan === id_karyawan);            
            if (karyawan) {
            return { ...karyawan, bobot: bobot };
            } else {
            return { nama: 'Tidak Ditemukan', bobot: bobot };
            }
        });
        }

    },
    methods: {
      async fetchKaryawanData() {
        const ids = this.opl.split(',').filter(pl => pl).map(pl => {
          const cs = pl.indexOf('[');
          return pl.substring(0, cs);
        });
  
        try {
          const response = await axios.post('/karyawan-by-ids', { ids });
          this.karyawanData = response.data;
        } catch (error) {
          console.error('Error fetching karyawan data:', error);
        } finally {
          this.loading = false;
        }
      }
    },
    mounted() {
      this.fetchKaryawanData();
    }
  };
  </script>
  