<script setup>
import Home from "../Components/Home.vue";
import {ref, watchEffect} from "vue";

const items = ref([]);
const boss = ref()
const isOpen = ref(false)
async function fetchDataFromServer(){
    await fetch(`api/tree`)
        .then((response) => response.json())
        .then((json) => {
            items.value = json
        })
}

async function setMainBoss(boss) {
    await fetch(`api/employees/mainBoss/` + boss)
    location.reload()
}


watchEffect(fetchDataFromServer);

</script>

<template>
    <div class="mb-2 ml-8">

            <router-link to="api/employees/create">
            <button
                class="ml-10 m-3 middle none center mr-5 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                data-ripple-light="true"
            >Добавить работника</button>
            </router-link>
        <button
            class="middle none center mr-10 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
            data-ripple-light="true"
            @click="isOpen = true"
        >Новый генеральный</button>
    </div>
    <div class="ml-10 mr-0">
        <Home>
        </Home>
    </div>
    <div
        v-show="isOpen"
        class="absolute inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50
        "
    >
        <div class="max-w-2xl p-6 bg-white rounded-md shadow-xl">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl">Новый генеральный директор</h3>
                <svg
                    @click="isOpen = false"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-8 h-8 text-red-900 cursor-pointer"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
            </div>

            <div class="mt-4">
                <h4>Текущий генеральный:</h4>
                <div class="flex items-center space-x-4 ">
                    <div class="flex-shrink-1">
                        <img class="w-10 h-10 rounded-full" :src="items.image" alt="Neil image">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                            {{items.name}} {{items.father_name}} {{items.sur_name}}
                        </p>
                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                            {{items.rank}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-6 mb-6">
                <h4>Новый генеральный:</h4>
                <input type="number" placeholder="Табель..." v-model="boss" class="block w-full py-1.5 text-gray-700 bg-white border border-gray-400 rounded-lg md:w-52 placeholder-gray-600/70 pl-11 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40">
            </div>
            <button
                @click="isOpen = false"
                class="px-6 py-2 text-blue-800 border border-blue-600 rounded"
            >
                Назад
            </button>
            <button
                class="px-6 py-2 ml-2 text-blue-100 bg-blue-600 rounded"
                @click="setMainBoss(boss) , isOpen = false , boss= null"
            >
                Обновить
            </button>

        </div>
    </div>
</template>
