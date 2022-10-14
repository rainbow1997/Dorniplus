<script setup>
// import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import Index from '@/Layouts/AdminPanel/Index'
import {Head} from '@inertiajs/inertia-vue3'
import { usePage } from '@inertiajs/inertia-vue3'
import {defineProps} from "vue";

const props = defineProps({
    dashboardData:{}
})
</script>

<template>
    <Head title="داشبورد"/>
<index :dashboard-data="props.dashboardData"></index>

<!--    <BreezeAuthenticatedLayout>-->
<!--        <template #header>-->
<!--            <h2 class="font-semibold text-xl text-gray-800 leading-tight">-->
<!--                داشبورد-->
<!--            </h2>-->
<!--        </template>-->

<!--        <div class="py-12">-->
<!--            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">-->
<!--                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">-->
<!--                    <div class="p-6 bg-white border-b border-gray-200">-->
<!--                        شما با موفقیت وارد شده اید.-->
<!--                        <hr/>-->
<!--                        {{ $page.props.flash.message }}-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </BreezeAuthenticatedLayout>-->
</template>

