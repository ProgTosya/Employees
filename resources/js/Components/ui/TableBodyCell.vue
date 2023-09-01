<script setup lang="ts">

import {BodyColumnTypes} from "@/Components/ui/TableBodyRow.types.d";

const value = 'Redact me plssss'


defineProps<{
    type?:BodyColumnTypes,
    title?: string,
    imageType?: boolean,
    href?: string,
    src?: string,
}>()

</script>

<template>
    <td class="px-6 py-4 font-medium table__body-cell"
        :class="{
            'table__body-cell__actions': type === 'actions'
        }"
    >
        <div class="relative h-10 w-10"
        v-if="type === 'avatar'"
        >
            <img
                class="h-full w-full rounded-full object-cover object-center"
                :src="src"
                alt=""
            />
        </div>
        <slot v-else>{{value}}</slot>
    </td>
</template>
