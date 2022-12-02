<template>
    <Head title="مدیریت مناطق"/>

<masterpage>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                استان ها
            </h2>


        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="mb-4">
                            <Link
                                :href="route('regions.province.create')"
                                class="
                                    px-6
                                    py-2
                                    mb-2
                                   text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700
                                "
                            >
                                افزودن استان
                            </Link>
                            <p class="mt-5">
                                جهت مشاهده شهرهای هر استان و انجام عملیات مورد نظر یک استان را انتخاب کنید
                            </p>
                        </div>
                        <table>
                            <thead class="font-bold bg-gray-300 border-b-2">
                            <td class="px-4 py-2">شناسه</td>
                            <td class="px-4 py-2">عنوان</td>

                            <td class="px-4 py-2">عملیات</td>
                            </thead>
                            <tbody>
                            <tr v-for="province in props.provinces.data" :key="province.id">
                                <td class="px-4 py-2">{{ province.id }}</td>
                                <td class="px-4 py-2">{{ province.title }}</td>
                                <td class="px-4 py-2 font-extrabold flex flex-row space-around">
                                    <BreezeButton
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                        @click="chooseProvince(province.id)">
                                        انتخاب
                                    </BreezeButton> <!-- remember that , link try to remount and it makes conflicts-->

                                    <Link
                                        :href="route('regions.province.edit', province.id)"
                                        class="text-white bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:focus:ring-yellow-900"
                                    >
                                        ویرایش
                                    </Link>
                                    <Link
                                        class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                                        @click="destroy(province.id)"
                                    >حذف
                                    </Link
                                    >


                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <pagination :links="props.provinces.links"/>

                        <div v-if="states.selectedProvince">
                            <h3 class="mb-3">شهر ها</h3>

                            <Link
                                :href="route('regions.city.create',states.selectedProvince.id)"
                                class="
                                    px-6
                                    py-2
                                    text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700
                                "
                            >
                                افزودن شهر به این استان
                            </Link>
                            <table class="table-fixed mt-5">
                                <thead class="font-bold bg-gray-300 border-b-2">
                                <td class="px-4 py-2">شناسه</td>
                                <td class="px-4 py-2">عنوان</td>

                                <td class="px-4 py-2">عملیات</td>
                                </thead>
                                <tbody>
                                <tr v-for="city in states.selectedProvince.cities" :key="city.id">
                                    <td class="px-4 py-2">{{ city.id }}</td>
                                    <td class="px-4 py-2">{{ city.title }}</td>
                                    <td class="px-4 py-2 font-extrabold">

                                        <Link
                                            class="text-red-700"
                                            @click="destroyCity(city.id)"
                                        >حذف
                                        </Link
                                        >

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</masterpage>
</template>

<script setup>

import {Head, Link, useForm} from '@inertiajs/inertia-vue3'

import {ref, reactive} from 'vue'
import Pagination from '@/Layouts/pagination.vue'

import {Inertia} from '@inertiajs/inertia'

import BreezeButton from '@/Components/Button.vue'
import Masterpage from "@/Layouts/AdminPanel/Layout/Masterpage.vue";

const props = defineProps({
    provinces: {},
});
const states = reactive({
    selectedProvince: null,
    canShow: false
});
const destroy = (id) => {
    Inertia.delete(route("regions.province.destroy", id));
}
const destroyCity = (id) => {
    Inertia.delete(route("regions.city.destroy", id), {replace: true});
    states.selectedProvince = null;

}
const chooseProvince = (id) => {
    const filteredProvinces = props.provinces.data.filter(function (province) {
        if (province.id == id) {
            //alert(province.title);
            return province;
        }

    });
    states.selectedProvince = {...filteredProvinces[0]};
    states.canShow = true;
};
</script>
