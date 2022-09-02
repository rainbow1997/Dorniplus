<template>
    <Head title="مدیریت کاربری"/>

    <BreezeAuthenticatedLayout>
        <template #header>

        </template>


        <div class="max-w-7xl mx-auto mt-5 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col space-y-8">
                        <div class="flex flex-col">
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                کاربران
                            </h2>

                            <div class="my-2 flex flex-row justify-between ">
                                <Link :href="route('site_admin.create')" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                      type="button">
                                    افزودن مدیر
                                </link>

                                <button
                                    class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                    data-modal-toggle="reporting-modal" type="button" @mouseenter="refreshPage">
                                    گزارش گیری
                                </button>


                                <!-- Main modal -->
                                <div id="reporting-modal" ref="reporting-modal" aria-hidden="true"
                                     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full"
                                     tabindex="-1">

                                    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                        <!-- Modal content -->
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <button
                                                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                                                data-modal-toggle="reporting-modal"
                                                type="button">
                                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor"
                                                     viewBox="0 0 20 20"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path clip-rule="evenodd"
                                                          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                          fill-rule="evenodd"></path>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                            <div class="py-6 px-6 lg:px-8 space-y-6">
                                                <h3 class="mt-4 mb-4 text-xl font-medium text-gray-900 dark:text-white">
                                                    دریافت گزارش
                                                    از اطلاعات کاربران</h3>
                                                <form class="space-y-6 gap-3" @submit.prevent="submitReportGenerator">
                                                    <div class="flex flex-col gap-4 ">
                                                        <div id="reportParameters" class="flex flex-col gap-3">
                                                            <label
                                                                class="flex-1 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                                for="reportParameters">
                                                                پارامتر های گزارش گیری:</label>

                                                            <div class="flex">
                                                                <label
                                                                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                                    for="parameterProvince">
                                                                    استان</label>
                                                                <input id="parameterProvince"
                                                                       v-model="ourData.report.parameters['province']"
                                                                       class="w-4 h-4 bg-gray-50 rounded border border-gray-300 focus:ring-3 focus:ring-blue-300 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800"
                                                                       type="checkbox"
                                                                       value="province">
                                                            </div>
                                                            <div class="flex">
                                                                <label
                                                                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                                    for="parameterCity">
                                                                    شهرستان</label>

                                                                <input id="parameterCity"
                                                                       v-model="ourData.report.parameters['city']"
                                                                       class="w-4 h-4 bg-gray-50 rounded border border-gray-300 focus:ring-3 focus:ring-blue-300 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800"
                                                                       type="checkbox"
                                                                       value="city">

                                                            </div>
                                                            <div class="flex">
                                                                <label
                                                                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                                    for="parameterGenders">
                                                                    جنسیت</label>

                                                                <input id="parameterGenders"
                                                                       v-model="ourData.report.parameters['gender']"
                                                                       class="w-4 h-4 bg-gray-50 rounded border border-gray-300 focus:ring-3 focus:ring-blue-300 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800"
                                                                       type="checkbox"
                                                                       value="gender">
                                                            </div>

                                                            <div class="flex">
                                                                <label
                                                                    class=" ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                                    for="parameterStartDate">
                                                                    ابتدای بازه زمانی</label>
                                                                <date-picker
                                                                    v-model="ourData.report.parameters['start_date']"
                                                                    display-format="jYYYY-jMM-jDD" format="YYYY-MM-DD"/>
                                                            </div>

                                                            <div class="flex">
                                                                <label
                                                                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                                    for="parameterEndDate">
                                                                    انتهای بازه زمانی</label>
                                                                <date-picker
                                                                    v-model="ourData.report.parameters['end_date']"
                                                                    display-format="jYYYY-jMM-jDD" format="YYYY-MM-DD"/>

                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div id="reportMethods" class="flex flex-row gap-4">
                                                        <label
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                            for="reportMethods">
                                                            نوع خروجی گزارش گیری:</label>


                                                        <div class="flex gap-2">

                                                            <input id="parameterPdf" v-model="ourData.report.methods"
                                                                   class="w-4 h-4 bg-gray-50 rounded border border-gray-300 focus:ring-3 focus:ring-blue-300 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800"

                                                                   type="checkbox"
                                                                   value="pdf">
                                                            <label
                                                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                                for="parameterPdf">
                                                                PDF </label>

                                                        </div>

                                                        <div class="flex gap-2">

                                                            <input id="parameterExcel" v-model="ourData.report.methods"
                                                                   class="w-4 h-4 bg-gray-50 rounded border border-gray-300 focus:ring-3 focus:ring-blue-300 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800"

                                                                   type="checkbox"
                                                                   value="excel">
                                                            <label
                                                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                                for="parameterExcel">
                                                                EXCEL </label>

                                                        </div>

                                                    </div>

                                                    <div class="flex justify-between">

                                                        <button
                                                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                            type="submit">
                                                            دریافت گزارش
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="flex-1">


                            <div
                                class="p-4 mb-4 text-sm text-yellow-700 bg-yellow-100 rounded-lg dark:bg-yellow-200 dark:text-yellow-800"
                                role="alert">
                                <span class="font-medium">دقت کنید!</span> برای جست و جو می توانید از پارامتر های مختلف
                                به طور همزمان استفاده کنید.
                            </div>

                            <div
                                class="p-4 mb-4 text-sm text-yellow-700 bg-yellow-100 rounded-lg dark:bg-yellow-200 dark:text-yellow-800"
                                role="alert">
                                <span class="font-medium">دقت کنید!</span>
                                جهت ویرایش نقش کاربری هر کاربر کافیست از دکمه ویرایش استفاده کنید.
                            </div>
                            <div class="grid grid-cols-4 gap-4 items-center justify-evenly">

                                <input id="post-title" v-model="ourData.search.fullname"
                                       class="rounded-none rounded-l-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block min-w-0  text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="نام و نام خانوادگی..."
                                       type="text">

                                <input id="search_email" v-model="ourData.search.email"
                                       class="rounded-none rounded-l-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block min-w-0  text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="ایمیل..."
                                       type="text">

                                <input id="search_province" v-model="ourData.search.province"
                                       class="rounded-none rounded-l-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block min-w-0  text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="استان..."
                                       type="text">

                                <input id="search_city"
                                       v-model="ourData.search.city"
                                       class="rounded-none rounded-l-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block min-w-0  text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="شهرستان" type="text">


                                <!--                                <input id="search_role"-->
                                <!--                                       v-model="search.role"-->
                                <!--                                       class="rounded-none rounded-l-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block min-w-0  text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"-->
                                <!--                                       placeholder="نقش کاربری" type="text">-->


                                <!--                                <div>-->
                                <!--                                    <label class="typo__label">Tagging</label>-->
                                <!--                                    <VueMultiselect v-model="search.roles" tag-placeholder="Add this as new tag" placeholder="Search or add a tag" label="name" track-by="id" :options="roles" :multiple="true" :taggable="true" @tag="addTag">-->


                                <!--                                    </VueMultiselect>-->

                                <!--                                </div>-->
                                <date-picker v-model="ourData.search.birth"
                                             autofocus
                                             class="rounded-none rounded-l-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block min-w-0  text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" display-format="jYYYY/jMM/jDD"
                                             editable format="YYYY/MM/DD" placeholder="تاریخ تولد ..."/>


                                <date-picker v-model="ourData.search.created_at"
                                             autofocus
                                             class="rounded-none rounded-l-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block min-w-0  text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                             display-format="jYYYY/jMM/jDD" editable
                                             format="YYYY/MM/DD" placeholder="ابتدای بازه تاریخ عضویت..."/>


                            </div>
                        </div>
                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                                <tr>
                                    <th class="py-3 px-6 bg-gray-50 dark:bg-gray-800" scope="col">شناسه</th>
                                    <th class="py-3 px-6 bg-gray-50 dark:bg-gray-800" scope="col">نام</th>
                                    <th class="py-3 px-6 bg-gray-50 dark:bg-gray-800" scope="col">نام خانوادگی</th>
                                    <th class="py-3 px-6 bg-gray-50 dark:bg-gray-800" scope="col">ایمیل</th>
                                    <th class="py-3 px-6 bg-gray-50 dark:bg-gray-800" scope="col">استان</th>
                                    <th class="py-3 px-6 bg-gray-50 dark:bg-gray-800" scope="col">>شهرستان</th>
                                    <th class="py-3 px-6 bg-gray-50 dark:bg-gray-800" scope="col">نقش ها</th>
                                    <th class="py-3 px-6 bg-gray-50 dark:bg-gray-800" scope="col" width="280px">
                                        عملیات
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="user in props.users.data"
                                    class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                    <td class="py-4 px-6">{{ user.id }}</td>
                                    <td class="py-4 px-6">{{ user.fname }}</td>
                                    <td class="py-4 px-6">{{ user.lname }}</td>
                                    <td class="py-4 ">{{ user.email }}</td>
                                    <td v-if="user.province != null" class="py-4 mr-3">{{ user.province.title ?? '' }}
                                    </td>
                                    <td v-if="user.city != null" class="py-4 px-6">{{ user.city.title ?? '' }}</td>
                                    <td class="py-4 px-6">
                                        <div v-if="!!user.roles" class="flex flex-row">
                                            <span v-for="role in user.roles" class="m-1">
                                                {{ role.name }}
                                            </span>
                                        </div>
                                    </td>

                                    <td v-if="props.isFromSiteAdminAdd">
                                        <button
                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                            @click="$emit('setUser',user.id)">
                                            انتخاب کاربر
                                        </button>

                                    </td>
                                    <td v-if="props.isFromSiteAdminAdd!=true" class="py-4 flex flex-row">
                                        <button
                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                            type="button">

                                            <Link :href="route('users.show',user.id)" class="btn btn-info">مشاهده</Link>
                                        </button>
                                        <button
                                            class="text-white bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:focus:ring-yellow-900"
                                            type="button">

                                            <a :href="route('users.edit',user.id)" class="btn btn-primary">ویرایش</a>
                                        </button>
                                        <button
                                            class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                                            type="button">

                                            <a class="btn btn-primary" @click="destroyUser(user.id)">حذف کاربر</a>
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <pagination :links="props.users.links" class="mt-6"/>

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
import BreezeButton from '@/Components/Button.vue'
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeCheckbox from '@/Components/Checkbox.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import {Head, Link, useForm} from '@inertiajs/inertia-vue3'
import {ref, watch} from 'vue'

import Pagination from '@/Layouts/pagination'
// import VueMultiselect from 'vue-multiselect'
import DatePicker from 'vue3-persian-datetime-picker'
import 'flowbite'

const ourData = useForm({
    chosenUser: {},
    ali: [1, 2, 5],
    test: {},
    newUsers: {},
    report: useForm({
        parameters: {
            province: false,
            city: false,
            gender: false,
            start_date: '',
            end_date: ''
        },
        methods: []
    }),
    search: {
        fullname: '',
        email: '',
        province: '',
        city: '',
        // roles: [],
        birth: '',
        created_at: '',

    },
    myDateObj: {}

});
const props = defineProps({
    users: Object,//afterwards, delete it and use Inertia attr
    roles: {},
    isFromSiteAdmin: false,
    isFromSiteAdminAdd: false
});
watch(ourData.search, (newValue, oldValue) => {
        Inertia.reload({
            replace: true,
            preserveState: true,
            data: ourData.search
        });
    }
);

const setUser = (user) => {

    Inertia.visit(route('site_admin.create', {
        replace: true,
        data: {
            chosenUser: user
        }
    }));
}
const refreshPage = (e) => {
    const script = document.createElement('script');
    script.setAttribute('src', '/js/flowbite.js');
    script.setAttribute('async', '');
    document.head.appendChild(script);
};

const submitReportGenerator = () => {

    this.report.post(route('users.report'), {
        preserveState: true,
        preserveScroll: true,
        onFinish: () => {
            alert(this.report);

        },


    });

};

const destroyUser = (id) => {
    Inertia.delete(route("users.destroy", id));

}


</script>
