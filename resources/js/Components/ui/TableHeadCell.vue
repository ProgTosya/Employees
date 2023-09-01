<script setup lang="ts">

import {ColumnType} from "@/Components/ui/TableHeadRow.types.d";
import Icon from "@/Components/ui/Icon.vue";
import {TAvailableSorting} from "@/Components/ui/Table.types.d";

const props = defineProps<{
    title?: string,
    type?: ColumnType,
    itemKey?: string,
    imageType?: boolean
    sortDir?: 'asc' | 'desc'
}>();

const availableSortings:Array<TAvailableSorting> = [undefined, 'asc', 'desc'];

const emit = defineEmits<{
    (e: 'sort-change', sortDir: undefined | 'asc' | 'desc', sortKey: string)
}>()

function nextSort():TAvailableSorting{
    let currentIndex = availableSortings.indexOf(props.sortDir);
    if(currentIndex === -1) currentIndex =0;
    currentIndex++;
    if (currentIndex > 2) currentIndex = 0;
    return availableSortings[currentIndex];
}

function handleClick(e){
    emit('sort-change', nextSort(), props.itemKey)
}

</script>

<template>
    <th scope="col" class="py-4 px-6 text-sm font-medium text-left rtl:text-right text-gray-1000 dark:text-black">

            <button class="flex items-center gap-x-3 focus:outline-none"
                    @click="handleClick"
                    v-if="title"
            >
                <span>{{ title }}</span>
                <Icon
                    v-if="sortDir === 'asc'"
                    type ="up"
                />
                <Icon
                    v-else-if="sortDir === 'desc'"
                    type ="down"
                />
            </button>


    </th>


</template>

