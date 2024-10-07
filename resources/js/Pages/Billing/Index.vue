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
            <div class="bg-white shadow-md rounded my-6">
              <table class="min-w-max w-full table-auto">
                <thead>
                  <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">No</th>
                    <th class="py-3 px-6 text-left">Jenis</th>
                    <th class="py-3 px-6 text-left">Nama Web</th>
                    <th class="py-3 px-6 text-left">Paket</th>
                  </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                  <tr v-if="projects.data && projects.data.length > 0" v-for="(project, index) in projects.data" :key="project.id" class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ index + 1 }}</td>
                    <td class="py-3 px-6 text-left">{{ project.jenis }}</td>
                    <td class="py-3 px-6 text-left">
                      <span v-if="project.webhost">{{ project.webhost.nama_web }}</span>
                      <span v-else>-</span>
                    </td>
                    <td class="py-3 px-6 text-left">
  
                      <!-- <span v-if="project.webhost.paket.paket">{{ project.webhost.paket.paket }}</span>
                      <span v-else>-</span> -->
                      </td>
                  </tr>
                  <tr v-else>
                    <td colspan="4" class="py-3 px-6 text-left">No projects found.</td>
                  </tr>
                </tbody>
              </table>
  
              <!-- Pagination -->
              <pagination :projects="projects" @pagination-change-page="getProjects" class="mt-4" />
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script>
 import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import Pagination from '@/Components/Pagination.vue';
  
  export default {
    props: {
      projects: {
        type: Object,
        default: () => ({
          data: [],
          current_page: 1,
          last_page: 1,
          prev_page_url: null,
          next_page_url: null,
        }),
      },
    },
    components: {
      AuthenticatedLayout,
      Pagination,
    },
    
    methods: {
      getProjects(page = 1) {
        this.$inertia.get(route('billing'), { page });
      },
    },
  };
  </script>