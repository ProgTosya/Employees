<script setup>
import {ref, computed, watchEffect, toRaw} from 'vue'
import TreeItem from "./TreeItem.vue";
const props = defineProps({
    items: Object
})
const isOpen = ref(false)
const allChild = ref([])
function toggle() {
    isOpen.value = !isOpen.value
    loadChild(props.items.employee_id)
}

const isFolder = computed(() => {
    return props.items.subordinates
})

async function loadChild(item) {
    await fetch(`api/child/` + item )
        .then((response) => response.json())
        .then((json) => {allChild.value = json})
        .catch((error) => {})
}
async function loadOldBoss(boss, employee) {
    await fetch(`api/boss/` + boss + `/` + employee)
        .then((response) => response.json())
        .then((json) => {allChild.value = json})
        .catch((error) => {})
}

async function setBossEmployee(boss, employee) {
    await fetch(`api/dragEmployee/` + boss + `/` + employee)
        .catch((error) => {})
}

const dragStart = (event, item) => {
    if (item.rank_level !== 0) {
        event.dataTransfer.dropEffect = 'move'
        event.dataTransfer.effectAllowed = 'move'
        event.dataTransfer.setData('employee', item.employee_id)
        event.dataTransfer.setData('oldBoss', item.boss_id)
    }
}

const onDrop = (event, item) => {
    const itemEmployee = event.dataTransfer.getData('employee')
    setBossEmployee(item.employee_id, itemEmployee)
    loadChild(item.employee_id)

}
const getMainBoss = (event, item) => {
    const itemEmployee = event.dataTransfer.getData('employee')
    const oldBossEmployee = parseInt(event.dataTransfer.getData('oldBoss'))
    if (oldBossEmployee === item.employee_id){
        loadOldBoss(oldBossEmployee, itemEmployee)
    }
}
</script>
<template>
    <li
    @dragstart="getMainBoss($event, items)"
    >
        <div @click="toggle"
             draggable="true"
             @dragenter.prevent
             @dragover.prevent
             @dragstart="dragStart($event, items)"
             @drop="onDrop($event, items)"
        >
            <li class="py-3 sm:py-4 border border-separate border-spacing-x-32 border-slate-400 mb-2 rounded-md drop-shadow-md bg-blue-100">
                <div class="flex items-center space-x-4 ">
                    <span v-if="isFolder">[{{ isOpen ? '-' : '+' }}]</span>
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
                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                        {{items.pay}} BYN
                    </div>
                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                        {{items.work_to}}
                    </div>
                </div>
            </li>
        </div>

        <ul v-show="isOpen" v-if="isFolder">
            <li>
                <TreeItem
                    v-for="item in allChild"
                    v-if="props.items.subordinates?.length"
                    class="item"
                    :items="item"
                >
                </TreeItem>
            </li>
        </ul>
    </li>

</template>
