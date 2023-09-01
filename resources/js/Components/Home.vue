<script setup lang="ts">

import {computed, ref, watchEffect} from "vue"
import Table from "@/Components/ui/Table.vue";
import Paginate from "@/Components/ui/Paginate.vue";
import {TableColumns} from "/ui/Table.types"


const columns:TableColumns = [
    {imageType: true, type: 'avatar', itemKey: 'image'},
    {title: 'Табель', itemKey: 'employee_id'},
    {title: 'Имя', itemKey: 'name'},
    {title: 'Отчество', itemKey: 'father_name'},
    {title: 'Фамилия', itemKey: 'sur_name'},
    {title: 'Должность', itemKey: 'rank'},
    {title: 'Зарплата', itemKey: 'pay'},
    {title: 'Трудоустроен', itemKey: 'work_to'},
    {title: 'Руководитель(Табель)', itemKey: 'boss_id'},
    {type: 'actions'}
];
const items = ref([]);
const sortColumn = ref('');
const sortDir = ref('');
const page = ref(1);
const limit = 5;
const searchID = ref('');
const searchName = ref('');
const searchFatherName = ref('');
const searchSurName = ref('');
const searchRank = ref('');
const searchPay = ref('');
const searchWorkTo = ref('');
const searchBoss = ref('');


const apiUrl = computed(() => {
    const offset = (page.value - 1) * limit;
    let url = `api/employees?limit=${limit}&offset=${offset}`;
    if (sortColumn.value  && sortDir.value){
        url += `&sortby=${sortColumn.value}&sortdir=${sortDir.value}`
    }
    if(searchID.value){url += `&_employee_id=${searchID.value}`}
    if(searchName.value){url += `&_name=${searchName.value}`}
    if(searchFatherName.value){url += `&_father_name=${searchFatherName.value}`}
    if(searchSurName.value){url += `&_sur_name=${searchSurName.value}`}
    if(searchRank.value){url += `&_rank=${searchRank.value}`}
    if(searchPay.value){url += `&_pay=${searchPay.value}`}
    if(searchWorkTo.value){url += `&_work_to=${searchWorkTo.value}`}
    if(searchBoss.value){url += `&_boss_id=${searchBoss.value}`}

    return url;
})

function handleSortChange(newSortDir, newSortKey){
    sortDir.value = newSortDir;
    sortColumn.value = newSortKey;
}

async function fetchDataFromServer(){
    await fetch(apiUrl.value)
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
    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md m-3">
        <div class="relative flex items-center mt-3 md:mt-0">
            <div class="ml-5">
                <input type="number" placeholder="Табель..." class="mb-2 block w-full py-1.5 pr-5 text-gray-700 bg-white border border-gray-400 rounded-lg md:w-80 placeholder-gray-600/70 pl-11 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40" v-model="searchID">
                <input type="text" placeholder="Имя..." class="block w-full py-1.5 pr-5 text-gray-700 bg-white border border-gray-400 rounded-lg md:w-80 placeholder-gray-600/70 pl-11 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40" v-model="searchName">
            </div>
            <div class="ml-7">
                <input type="text" placeholder="Отчество..." class="mb-2 block w-full py-1.5 pr-5 text-gray-700 bg-white border border-gray-400 rounded-lg md:w-80 placeholder-gray-600/70 pl-11 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40" v-model="searchFatherName">
                <input type="text" placeholder="Фамилия..." class="block w-full py-1.5 pr-5 text-gray-700 bg-white border border-gray-400 rounded-lg md:w-80 placeholder-gray-600/70 pl-11 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40" v-model="searchSurName">
            </div>
            <div class="ml-7">
                <input type="text" placeholder="Должность..." class="mb-2 block w-full py-1.5 pr-5 text-gray-700 bg-white border border-gray-400 rounded-lg md:w-80 placeholder-gray-600/70 pl-11 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40" v-model="searchRank">
                <input type="number" placeholder="Зарплата..." class="block w-full py-1.5 pr-5 text-gray-700 bg-white border border-gray-400 rounded-lg md:w-80 placeholder-gray-600/70 pl-11 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40" v-model="searchPay">
            </div>
            <div class="ml-7">
                <input type="date" placeholder="Трудоустроен..." class="mb-2 block w-full py-1.5 pr-5 text-gray-700 bg-white border border-gray-400 rounded-lg md:w-80 placeholder-gray-600/70 pl-11 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40" v-model="searchWorkTo">
                <input type="number" placeholder="Табель руководителя..." class="block w-full py-1.5 pr-5 text-gray-700 bg-white border border-gray-400 rounded-lg md:w-80 placeholder-gray-600/70 pl-11 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40" v-model="searchBoss">
            </div>
        </div>
        <Table :columns="columns"
               :items="items"
               :sort-dir="sortDir"
               id-key="id"
               :sort-key="sortColumn"
               @sort-change="handleSortChange"
        />
    </div>
    <div>
        <Paginate
            v-model="page"
            :pageLimit="limit"
        />
    </div>
</template>
