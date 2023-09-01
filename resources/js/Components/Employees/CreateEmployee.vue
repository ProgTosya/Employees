<script setup>

import {reactive, ref} from "vue";
import axios from "axios";
import {useRouter} from "vue-router";

const router = useRouter();

const form = reactive({
    name: '',
    sur_name: '',
    father_name: '',
    rank: '',
    pay: '',
    work_to: '',
    boss_id: '',
    image: '',
});

let image_url = ref("https://cdn.icon-icons.com/icons2/1736/PNG/512/4043260-avatar-male-man-portrait_113269.png");
function look ($event) {
    form.image = $event.target.files[0];
}
function submit(){

    let formData = new FormData();
    formData.append('name', form.name);
    formData.append('sur_name', form.sur_name);
    formData.append('father_name', form.father_name);
    formData.append('rank', form.rank);
    formData.append('pay', form.pay);
    formData.append('work_to', form.work_to);
    formData.append('boss_id', form.boss_id);
    formData.append('image', form.image);

    axios
        .post(`http://localhost:8000/api/employees`, formData)
        .then(() => {
            router.push({
                name: 'dashboard',
            });
        });

}
</script>

<template>
    <div class="relative  flex items-center justify-center bg-center py-8 px-4 sm:px-6 lg:px-8 bg-gray-300 bg-no-repeat bg-cover relative items-center">
        <div class="max-w-md w-full space-y-8 p-10 bg-white rounded-xl shadow-lg z-10">
            <form method="post" @submit.prevent="submit" enctype="multipart/form-data">
                    <div class="flex items-center py-6 ">
                        <div class="w-24 h-24 mr-4 flex-none rounded-xl border overflow-hidden">
                            <img class="relative inline-block h-24 w-24 rounded-2xl object-cover object-center" alt="Image placeholder" :src="image_url">
                        </div>
                        <label class="cursor-pointer ">
                            <span class="focus:outline-none text-white text-sm py-2 px-4 rounded-full bg-green-400 hover:bg-green-500 hover:shadow-lg">Обзор</span>
                            <input type="file" class="hidden" id="image" @input="form.image = $event.target.files[0]" @change="look">
                            <label class="font-semibold text-gray-600 py-2">{{form.image['name']}}</label>
                        </label>
                    </div>
                <div class="md:flex flex-row md:space-x-4 w-full text-xs">
                    <div class="mb-3 space-y-2 w-full text-xs">
                        <label class="font-semibold text-gray-600 py-2">Имя<abbr title="required">*</abbr></label>
                        <input placeholder="Имя..." class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4" required="required" type="text" name="name" v-model="form.name">
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

                <div class="mt-5 text-right md:space-x-3 md:block flex flex-col-reverse">
                    <router-link to="/dashboard">
                    <button class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100">Назад</button>
                    </router-link>
                    <button class="mb-2 md:mb-0 bg-green-400 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-green-500" type="submit">Создать</button>
                </div>
            </form>


        </div>
    </div>
</template>


