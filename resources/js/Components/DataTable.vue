<template>
    <div class="border rounded-md">
      <Table>
        <TableHeader>
          <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
            <TableHead class="text-nowrap" v-for="header in headerGroup.headers" :key="header.id" :class="header.column.columnDef.class">
              <FlexRender
                v-if="!header.isPlaceholder"
                :render="header.column.columnDef.header"
                :props="header.getContext()"
              />
            </TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          <template v-if="table.getRowModel().rows?.length">
            <TableRow
              v-for="row in table.getRowModel().rows"
              class="group"
              :key="row.id"
              :data-state="row.getIsSelected() ? 'selected' : undefined"
            >
              <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id" :class="cell.column.columnDef.class">
                <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()"/>
              </TableCell>
            </TableRow>
          </template>
          <template v-else>
            <TableRow>
              <TableCell :colspan="props.columns.length" class="h-24 text-center">
                No results.
              </TableCell>
            </TableRow>
          </template>
        </TableBody>
      </Table>
    </div>
  </template>
  
  <script>
  import { h } from 'vue'; 
  import {
    FlexRender,
    getCoreRowModel,
    useVueTable,
  } from '@tanstack/vue-table';
  
  import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
  } from '@/Components/ui/table';
  
  export default {
    props: {
      columns: {
        type: Array,
        required: true,
      },
      data: {
        type: Array,
        required: true,
      },
    },
    components: {
      FlexRender,
      Table,
      TableBody,
      TableCell,
      TableHead,
      TableHeader,
      TableRow,
      h
    },
    setup(props) {
      const table = useVueTable({
        get data() {
          return props.data;
        },
        get columns() {
          return props.columns;
        },
        getCoreRowModel: getCoreRowModel(),
      });
  
      return { table };
    },

    mounted() {
    },
  };
  </script>
  
  <style scoped>
  /* Add any necessary styles here */
  </style>