<script setup lang="ts">

import TableBodyCell from "@/Components/ui/TableBodyCell.vue";
import {TBodyColumns} from "@/Components/ui/TableBodyRow.types.d";

defineProps<{
    columns: TBodyColumns,
    item: object
}>()


</script>

<template>
    <tr class="hover:bg-gray-50">
        <TableBodyCell
            v-for="column in columns"
            v-bind="column"
            :src="column.type === 'avatar' ? item[column.itemKey] : undefined"
            :href="column.type === 'link' ? 'http://google.com' : undefined"
        >
            <template v-if="column.type !== 'action' && column.itemKey">{{ item[column.itemKey] }}</template>
            <template v-else>
                <div class="flex justify-end gap-3">
                    <router-link :to="{name: 'edit', params: {id: item['id']}}">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-6 w-6"
                            x-tooltip="tooltip"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"
                            />
                        </svg>
                    </router-link>
                </div>
            </template>
        </TableBodyCell>

    </tr>

</template>

