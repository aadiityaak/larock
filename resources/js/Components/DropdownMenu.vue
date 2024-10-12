<template>
  <div class="relative" @click.stop>
    <button
      @click="toggleDropdown"
      class="px-4 py-2 text-sm text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none"
    >
      Tindakan
    </button>
    
    <div
      v-if="isOpen"
      class="absolute right-0 z-50 w-48 mt-2 bg-white rounded shadow-lg"
    >
      <ul class="py-1">
        <li @click="onEdit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">
          Edit
        </li>
        <li @click="onDelete" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">
          Hapus
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    row: {
      type: Object,
      required: true,
    },
    onEdit: {
      type: Function,
      required: true,
    },
    onDelete: {
      type: Function,
      required: true,
    },
  },
  data() {
    return {
      isOpen: false,
    };
  },
  methods: {
    toggleDropdown() {
      this.isOpen = !this.isOpen;
    },
    closeDropdown(event) {
      // Cek apakah klik berada di dalam dropdown
      if (!this.$el.contains(event.target)) {
        this.isOpen = false;
      }
    },
  },
  mounted() {
    document.addEventListener('click', this.closeDropdown);
  },
  beforeDestroy() {
    document.removeEventListener('click', this.closeDropdown);
  },
};
</script>

<style scoped>
/* Tambahkan gaya kustom di sini jika perlu */
</style>