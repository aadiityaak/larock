<template>
  <div class="flex justify-end mt-4">
    <Pagination
      v-slot="{ page }"
      :current-page="currentPage"
      :total="lastPage"
      :sibling-count="1" 
      @page-changed="onPageChange"
    >
      <PaginationList v-slot="{ items }" class="flex items-center gap-1">
        <PaginationFirst @click="onPageChange(1)" />
        <PaginationPrev @click="onPageChange(currentPage - 1)" />

        <template v-for="(item, index) in items">
          <PaginationListItem v-if="item.type === 'page'" :value="item.value" :key="index" as-child>
            <Button
              class="w-10 h-10 p-0"
              :variant="item.value === currentPage ? 'default' : 'outline'"
              @click="onPageChange(item.value)"
            >
              {{ item.value }}
            </Button>
          </PaginationListItem>
          <PaginationEllipsis v-else :key="item.type" :index="index" />
        </template>

        <template v-if="lastPage > 3 && currentPage < lastPage - 1">
          <PaginationEllipsis />
          <PaginationListItem :value="lastPage" as-child>
            <Button
              class="w-10 h-10 p-0"
              :variant="lastPage === currentPage ? 'default' : 'outline'"
              @click="onPageChange(lastPage)"
            >
              {{ lastPage }}
            </Button>
          </PaginationListItem>
        </template>

        <PaginationNext @click="onPageChange(currentPage + 1)" />
        <PaginationLast @click="onPageChange(lastPage)" />
      </PaginationList>
    </Pagination>
  </div>
</template>

<script>
import { 
  Pagination, 
  PaginationList, 
  PaginationListItem, 
  PaginationEllipsis, 
  PaginationFirst, 
  PaginationLast, 
  PaginationNext, 
  PaginationPrev 
} from '@/Components/ui/pagination';
import { Button } from '@/Components/ui/button';

export default {
  props: {
    currentPage: {
      type: Number,
      required: true,
    },
    lastPage: {
      type: Number,
      required: true,
    },
  },
  components: {
    Pagination,
    PaginationList,
    PaginationListItem,
    PaginationEllipsis,
    PaginationFirst,
    PaginationLast,
    PaginationNext,
    PaginationPrev,
    Button
  },
  emits: ['page-changed'],
  methods: {
    onPageChange(page) {
      if (page >= 1 && page <= this.lastPage && page !== this.currentPage) {
        const queryParams = new URLSearchParams(window.location.search);
        queryParams.set('page', page); // Set the new page number
        this.$inertia.get(window.location.pathname + '?' + queryParams.toString(), {}, { preserveState: true });
      }
    },
  },
};
</script>