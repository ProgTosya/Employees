<script setup>
import TreeItem from './ui/TreeItem.vue'
import {computed, ref, watchEffect} from "vue";

const items = ref([]);
async function fetchDataFromServer(){
    await fetch(`api/tree`)
        .then((response) => response.json())
        .then((json) => {
            items.value = json
        })
        .catch((error) =>{

        })
}

watchEffect(fetchDataFromServer);


</script>

<template>
    <div
        class="relative sm:flex min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
    >
        <div class="mt-12 ml-10">
            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white mb-4">Список сотрудников</h5>
            <ul>
                <TreeItem class="item"
                          :items="items"
                >
                </TreeItem>
            </ul>
        </div>
    </div>
</template>

<style>
.item{
    margin-left: 30px;
}
</style>
