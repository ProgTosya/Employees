<script setup>

import {onMounted, reactive, ref} from "vue";
import {useRoute, useRouter} from "vue-router";
import axios from "axios";
const router = useRouter();
const route = useRoute();
const form = reactive({
    id: '',
    employee_id: '',
    name: '',
    sur_name: '',
    father_name: '',
    rank: '',
    pay: '',
    work_to: '',
    boss_id: '',
    image: '',
    old_boss: '',
});

onMounted(() => {
    axios
        .get(`http://localhost:8000/api/employees/${route.params.id}`)
        .then((response) => {
            form.id = response.data.id
            form.name = response.data.name;
            form.sur_name = response.data.sur_name;
            form.father_name = response.data.father_name;
            form.rank = response.data.rank;
            form.pay = response.data.pay;
            form.work_to = response.data.work_to;
            form.boss_id = response.data.boss_id;
            form.image = response.data.image;
            form.rank_level = response.data.rank_level;
            form.employee_id = response.data.employee_id;
            form.old_boss = form.boss_id;
        })
        .catch((error) => {
            console.log(error.response.data);
        });
});


function submit(){
    let name = form.name;
    let sur_name = form.sur_name;
    let father_name = form.father_name;
    let rank = form.rank;
    let pay = form.pay;
    let work_to = form.work_to
    let boss_id = form.boss_id;
    let old_boss = form.old_boss;
    axios
        .put(`http://localhost:8000/api/employees/${route.params.id}`,
            {
                name:name, sur_name:sur_name, father_name:father_name, rank: rank, pay:pay,
                work_to:work_to, boss_id:boss_id, old_boss:old_boss,
            }
        )
        .then(() => {
            router.push({
                name: 'dashboard',
            });
        });
}
function deleteEmployee(){
    if (form.rank_level !== 0) {

        axios
            .delete(`http://localhost:8000/api/employees/${route.params.id}`)
            .then(() => {
                router.push({
                    name: 'dashboard',
                });
            });
    } else {
        alert('Это генеральный директор')
    }
}
</script>

<template>
    <div class=" flex items-center justify-center bg-center py-1 px-4 sm:px-6 lg:px-8 bg-gray-300 bg-no-repeat bg-cover relative items-center">
        <div class="max-w-md w-full space-y-1 p-10 bg-white rounded-xl shadow-lg z-10">
            <form method="post" @submit.prevent="submit" enctype="multipart/form-data">
                <div class="flex items-center py-6 ">
                    <div class="w-32 h-32 mr-4 flex-none rounded-xl border overflow-hidden">
                        <img class="relative inline-block h-32 w-32 rounded-2xl object-cover object-center" alt="Image placeholder" :src="form.image">
                    </div>
                    <input class="hidden" v-model="form.old_boss">
                </div>
                <div class="md:flex flex-row md:space-x-4 w-full text-xs">
                    <div class="mb-3 space-y-2 w-full text-xs">
                        <label class="font-semibold text-gray-600 py-2">Имя<abbr title="required">*</abbr></label>
                        <input v-model="form.name" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4" required="required" type="text" name="name" >
                        <p class="text-red text-xs hidden">Пожалуйста, заполните это поле.</p>
                    </div>
                    <div class="mb-3 space-y-2 w-full text-xs">
                        <label class="font-semibold text-gray-600 py-2">Отчество <abbr title="required">*</abbr></label>
                        <input placeholder="Отчество..." class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4" required="required" type="text" name="father_name" v-model="form.father_name">
                        <p class="text-red text-xs hidden">Пожалуйста, заполните это поле.</p>
                    </div>
                </div>
                <div class="mb-3 space-y-2 w-full text-xs">
                    <div class="mb-3 space-y-2 w-full text-xs">
                        <label class="font-semibold text-gray-600 py-2">Фамилия <abbr title="required">*</abbr></label>
                        <input placeholder="Фамилия..." class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4" required="required" type="text" name="sur_name" v-model="form.sur_name">
                        <p class="text-red text-xs hidden">Пожалуйста, заполните это поле.</p>
                    </div>
                </div>
                <div class="md:flex md:flex-row md:space-x-4 w-full text-xs">
                    <div class="w-full flex flex-col mb-3">
                        <label class="font-semibold text-gray-600 py-2">Дата трудоустройства<abbr title="required">*</abbr></label>
                        <input placeholder="Год-Месяц-День" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4" type="date" name="work_to" v-model="form.work_to">
                    </div>
                    <div class="w-full flex flex-col mb-3">
                        <label class="font-semibold text-gray-600 py-2">Должность<abbr title="required">*</abbr></label>
                        <input placeholder="Должность..." class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4" type="text" name="rank" v-model="form.rank">
                    </div>
                </div>
                <div class="md:flex flex-row md:space-x-4 w-full text-xs">
                    <div class="mb-3 space-y-2 w-full text-xs">
                        <label class="font-semibold text-gray-600 py-2">Зарплата<abbr title="required">*</abbr></label>
                        <input placeholder="Сумма..." class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4" required="required" type="number" name="pay" v-model="form.pay">
                        <p class="text-red text-xs hidden">Пожалуйста, заполните это поле.</p>
                    </div>
                    <div class="mb-3 space-y-2 w-full text-xs">
                        <label class="font-semibold text-gray-600 py-2">Табель руководителя<abbr title="required">*</abbr></label>
                        <input placeholder="Номер..." class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4" required="required" type="number" name="boss_id" v-model="form.boss_id">
                        <p class="text-red text-xs hidden">Пожалуйста, заполните это поле.</p>
                    </div>
                </div>
                <p class="text-xs text-gray-500 text-right my-3">Табель: {{form.employee_id}}</p>
                <div class="ml-7 mt-5 md:space-x-3 md:block flex flex-col-reverse ">
                        <button @click.prevent="deleteEmployee()" class="mb-2 md:mb-0 bg-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-500">Удалить</button>
                    <router-link to="/dashboard">
                        <button class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100">Назад</button>
                    </router-link>
                    <button class="mb-2 md:mb-0 bg-green-400 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-green-500" type="submit">Обновить</button>
                </div>
            </form>


        </div>
    </div>
</template>


