<script setup lang="ts">

import TableHeadRow from "../ui/TableHeadRow.vue";
import TableBodyRow from "../ui/TableBodyRow.vue";
import {TableColumns} from "../ui/Table.types";



defineProps<{
    columns: TableColumns,
    items: Array<object>,
    sortDir: TAvailableSortings,
    sortKey: string,
    idKey: string
}>()

const emit = defineEmits<{
    (e: 'sort-change', sortDir: TAvailableSortings, sortKey: string)
}>()

function handleSortChange(sortDir, sortKey){
    emit('sort-change', sortDir, sortKey)
}

</script>

<template>
    <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
        <TableHeadRow :columns="columns"
                      @sort-change="handleSortChange"
                      :sort-dir="sortDir"
                      :sort-key="sortKey"/>
        <TableBodyRow v-for="item in items"
                      :columns="columns"
                      :item="item"
                      :key="item[idKey]"
        />
    </table>
</template>

<style scoped>
</style>
