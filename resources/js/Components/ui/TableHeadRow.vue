<script setup lang="ts">

import TableHeadCell from "@/Components/ui/TableHeadCell.vue";
import {TColumns} from "@/Components/ui/TableHeadRow.types.d";
import {TAvailableSorting} from "@/Components/ui/Table.types.d";

const props = defineProps<{
   columns: TColumns,
   sortDir: TAvailableSorting,
   sortKey: string
}>();

const emit = defineEmits<{
    (e: 'sort-change', sortDir: TAvailableSorting, sortKey: string)
}>()

function handleSortChange(sortDir, sortKey){
    emit('sort-change', sortDir, sortKey)
}

</script>

<template>
    <thead class="bg-gray-50">
    <tr>
        <TableHeadCell v-for="column in columns"
            v-bind="column"
            @sort-change = "handleSortChange"
            :sort-dir="sortKey === column.itemKey ? sortDir : '' "
        />
        <th scope="col" class="px-10 py-10 "></th>
    </tr>
    </thead>
</template>

<style scoped>

</style>
