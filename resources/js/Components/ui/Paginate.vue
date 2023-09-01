<script setup lang="ts">
import {computed} from "vue";

const props = defineProps<{
        modelValue: number,
        pageLimit?: number,
    }>()

const emit  = defineEmits<{
    (e: 'update:modelValue', value: number)
}>()

const page = computed({
    get(){
        return props.modelValue
    },
    set(value){
        emit('update:modelValue', value)
    }
})

function updatePage(newPageNumber){
    if(newPageNumber < 1) return;
    if(props.totalPages !== undefined && newPageNumber > props.totalPages) return;
    page.value = newPageNumber;
}

</script>

<template>
    <div class="mt-6 sm:flex sm:items-center sm:justify-between align-bottom">
        <div class="text-sm text-gray-500 dark:text-gray-400">
            Записи от  <span class="font-medium text-gray-700 dark:text-gray-100">
            {{ ((page-1) * pageLimit) + 1 }} <span class="text-sm text-gray-500 dark:text-gray-400">до</span> {{page * pageLimit}}
        </span>
        </div>

        <div class="flex items-center mt-4 gap-x-4 sm:mt-0">
            <a @click.prevent="updatePage(page-1)" href="#" class="flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md sm:w-auto gap-x-2 hover:bg-gray-100 dark:bg-gray-900 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 rtl:-scale-x-100">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                </svg>

                <span>
                    previous
                </span>
            </a>

            <a @click.prevent="updatePage(page+1)" href="#" class="flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md sm:w-auto gap-x-2 hover:bg-gray-100 dark:bg-gray-900 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-800">
                <span>
                    Next
                </span>

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 rtl:-scale-x-100">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                </svg>
            </a>
        </div>
    </div>
</template>

