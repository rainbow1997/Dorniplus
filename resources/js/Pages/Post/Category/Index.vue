<template>
    <Head title="مدیریت موضوعات"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="flex flex-col">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    موضوعات سایت
                </h2>

                <div class="my-2 flex flex-row space-around ">

                    <button
                        class="mx-2 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                        <a :href="route('categories.create')">
                            افزودن موضوع جدید
                        </a>

                    </button>

                </div>
            </div>
        </template>


        <div class="max-w-7xl mx-auto mt-5 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col space-y-8">
                        <div class="flex-1">
                            <div
                                class="p-4 mb-4 text-sm text-yellow-700 bg-yellow-100 rounded-lg dark:bg-yellow-200 dark:text-yellow-800"
                                role="alert">
                                <span class="font-medium">دقت کنید!</span> برای جست و جو می توانید از پارامتر های مختلف
                                به طور همزمان استفاده کنید.
                            </div>
                            <div class="flex  items-center justify-evenly">

                                <input id="category-title" v-model="ourData.search.title"
                                       class="rounded-none rounded-l-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block min-w-0  text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="عنوان موضوع..."
                                       type="text">

                                <date-picker editable
                                             class="rounded-none rounded-l-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block min-w-0  text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                             placeholder="ابتدای بازه زمانی ایجاد..." v-model="ourData.search.created_at"
                                             format="YYYY/MM/DD" display-format="jYYYY/jMM/jDD" autofocus/>


                                <date-picker editable
                                             class="rounded-none rounded-l-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block min-w-0  text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                             placeholder="ابتدای بازه زمانی بروزرسانی..." v-model="ourData.search.updated_at"
                                             format="YYYY/MM/DD" display-format="jYYYY/jMM/jDD" autofocus/>


                            </div>
                        </div>

                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                                <tr>
                                    <th class="py-3 px-6 bg-gray-50 dark:bg-gray-800" scope="col">شناسه</th>
                                    <th class="py-3 px-6 bg-gray-50 dark:bg-gray-800" scope="col">عنوان</th>
                                    <th class="py-3 px-6 bg-gray-50 dark:bg-gray-800" scope="col">تعداد مطلب</th>
                                    <th class="py-3 px-6 bg-gray-50 dark:bg-gray-800" scope="col">زمان ایجاد</th>
                                    <th class="py-3 px-6 bg-gray-50 dark:bg-gray-800" scope="col">زمان آخرین بروزرسانی
                                    </th>
                                    <th class="py-3 px-6 bg-gray-50 dark:bg-gray-800" scope="col" width="280px">
                                        عملیات
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="category in props.categories.data"
                                    class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                    <td class="py-4 px-6">{{ category.id }}</td>
                                    <td class="py-4 px-6">{{ category.title }}</td>
                                    <td class="py-4 px-6">{{ category.posts_count }}</td>

                                    <td class="py-4 mr-3">{{ category.created_at }}</td>
                                    <td class="py-4 px-6">{{ category.updated_at }}</td>


                                    <td class="py-4 flex flex-row">

                                        <button
                                            class="text-white bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:focus:ring-yellow-900"
                                            type="button">

                                            <a :href="route('categories.edit',category.id)" class="btn btn-primary">ویرایش</a>
                                        </button>
                                        <button
                                            class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                                            type="button">

                                            <a class="btn btn-primary" @click="destroyUser(category.id)">حذف</a>
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <pagination :links="props.categories.links" class="mt-6"/>

                            {{ $page.props.flash.message }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
<script setup>
import {Inertia} from '@inertiajs/inertia'
import BreezeButton from '@/Components/Button.vue';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeCheckbox from '@/Components/Checkbox.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';
import Pagination from '@/Layouts/pagination'
import DatePicker from 'vue3-persian-datetime-picker'
import {ref, watch} from 'vue'

let ourData = useForm({
    test: {},
    search: {
        title: '',
        created_at: '',
        updated_at: ''
    },

    myDateObj: {}

});
const props = defineProps({
    categories: Object,//afterwards, delete it and use Inertia attr

});
watch(ourData.search, (newValue, oldValue) => {
        Inertia.reload({
            replace: true,
            preserveState: true,
            data: ourData.search
        });
    }
);
const destroyUser = (id) => {
    Inertia.delete(route("categories.destroy", id));

};

</script>
