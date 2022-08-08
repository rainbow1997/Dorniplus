
<template>
    <Head title="مدیریت کاربری" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="flex flex-col">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                کاربران
            </h2>

            <div class="my-2 flex flex-row justify-center space-around ">

                <button class="mx-2 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                    <a :href="route('reporting','pdf')">
                        گزارش گیری PDF
                    </a>

                </button>
                <button class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                    <a :href="route('reporting','excel')"> گزارش گیری Excel</a>
                </button>
            </div>
            </div>
        </template>


            <div class="max-w-7xl mx-auto mt-5 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex flex-col space-y-8">
                            <div class="">
                                <div class="flex flex-row">
                                    <select v-model="searchingItem" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >
                                        <option value="fname">
                                            نام
                                        </option>
                                        <option value="lname">
                                            نام خانوادگی
                                        </option>
                                        <option value="province">
                                            استان
                                        </option>
                                        <option value="city">
                                            شهرستان
                                        </option>

                                    </select>
                                    <input type="text" v-model="searchingInput" name="searchingInput" class="mx-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  v-on:keyup="onSearch">

                                </div>
                            </div>

                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <table class="table-fixed w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">

                                <tr>
                                    <th scope="col" class="py-3 px-6">شناسه</th>
                                    <th scope="col" class="py-3 px-6">نام</th>
                                    <th scope="col" class="py-3 px-6">نام خانوادگی</th>
                                    <th scope="col" class="py-3 px-6">ایمیل</th>
                                    <th scope="col" class="py-3 px-6">استان</th>
                                    <th scope="col" class="py-3 px-6">شهرستان</th>
                                    <th scope="col" class="py-3 px-6">نقش ها</th>
                                    <th scope="col" class="py-3 px-6" width="280px">عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="user in users.data" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                    <td class="py-4 px-6">{{user.id}}</td>
                                    <td class="py-4 px-6">{{ user.fname }}</td>
                                    <td class="py-4 px-6">{{ user.lname }}</td>
                                    <td class="py-4 ">{{ user.email }}</td>
                                    <td class="py-4 mr-3">{{ user.province.title ?? ''}}</td>
                                    <td class="py-4 px-6">{{ user.city.title ?? '' }}</td>
                                    <td class="py-4 px-6">
                                        <div v-if="!!user.roles" class="flex flex-row">
                                            <span v-for="role in user.roles" class="m-1">
                                                {{role.name}}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="py-4 flex flex-row">
                                        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">

                                            <Link class="btn btn-info" :href="route('users.show',user.id)">مشاهده</Link></button>
                                        <button type="button" class="text-white bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:focus:ring-yellow-900">

                                            <a class="btn btn-primary" :href="route('users.edit',user.id)">ویرایش</a></button>
                                        <button type="button" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">

                                            <a class="btn btn-primary" @click="destroyUser(user.id)">حذف</a></button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <pagination class="mt-6" :links="users.links" />

                            {{$page.props.flash.message}}
                    </div>
                        </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
<script>
import { Inertia } from '@inertiajs/inertia'
import BreezeButton from '@/Components/Button.vue';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeCheckbox from '@/Components/Checkbox.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import './Auth/persian-datepicker.js';// in another time,use modules.env not this statically manner.
import './Auth/persian-datepicker.min.css';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import Pagination from '@/Layouts/pagination'

export default {
    components:{
        Head,
        Link,
        useForm,
        BreezeButton,
        BreezeAuthenticatedLayout,
        BreezeInput,
        BreezeLabel,
        BreezeValidationErrors,
        Pagination

    },
    data(){
        return{
            test:{},
            newUsers:{},
            searchingItem: '',
            searchingInput: ''

        }},
    props: {
        users:Object,//afterwards, delete it and use Inertia attr
    },

    methods: {
        destroyUser(id){
            this.$inertia.delete(route("users.destroy", id));

        },
        // reset(){
        //     this.user
        // }
        onSearch()
        {
            let data2 = {'searchingItem': this.searchingItem,
                        'searchingInput': this.searchingInput};
            // this.newUsers = this.$inertia.post(route("users.index.search",data));
            // Inertia.post(route("users.index.search",data),{
            //     only : ['users']
            // })
            Inertia.reload({
                replace : true,
                preserveState:true,
                data : data2
            });
        }
    },
    mounted() {
    console.log('hi');


    },
};



</script>
