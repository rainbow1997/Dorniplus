<template>
    <Head title="مدیریت کاربری"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="flex flex-col">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    کاربران
                </h2>

                <div class="my-2 flex flex-row justify-center space-around ">

                    <button
                        class="mx-2 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                        <a :href="route('reporting','pdf')">
                            گزارش گیری PDF
                        </a>

                    </button>
                    <button
                        class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                        <a :href="route('reporting','excel')"> گزارش گیری Excel</a>
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
                                <span class="font-medium">دقت کنید!</span> برای جست و جو می توانید از پارامتر های مختلف به طور همزمان استفاده کنید.
                            </div>
                            <div class="grid grid-cols-4 gap-4 items-center justify-evenly">

                                <input id="post-title" v-model="search.fullname"
                                       class="rounded-none rounded-l-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block min-w-0  text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="نام و نام خانوادگی..."
                                       type="text">

                                <input id="search_email" v-model="search.email"
                                       class="rounded-none rounded-l-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block min-w-0  text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="ایمیل..."
                                       type="text">

                                <input id="search_province" v-model="search.province"
                                       class="rounded-none rounded-l-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block min-w-0  text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="استان..."
                                       type="text">

                                <input id="search_city"
                                       v-model="search.city"
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
                                <input id="search_birth" ref="birth"
                                       v-model="search.birth"
                                       class="datepicker rounded-none rounded-l-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block min-w-0  text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       @click="keepingDate" placeholder="تاریخ تولد" type="text">


                                <input id="search_created_at" ref="created_at"
                                       v-model="search.created_at"
                                       class="datepicker rounded-none rounded-l-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block min-w-0  text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       @click="keepingDate" placeholder="تاریخ عضویت" type="text">
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
                                <tr v-for="user in users.data"
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

                                    <td class="py-4 flex flex-row">
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

                                            <a class="btn btn-primary" @click="destroyUser(user.id)">حذف</a></button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <pagination :links="users.links" class="mt-6"/>

                            {{ $page.props.flash.message }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
<script>
import {Inertia} from '@inertiajs/inertia'
import BreezeButton from '@/Components/Button.vue'
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeCheckbox from '@/Components/Checkbox.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import './Auth/persian-datepicker.js';// in another time,use modules.env not this statically manner.
import './Auth/persian-datepicker.min.css';
import {Head, Link, useForm} from '@inertiajs/inertia-vue3'
import Pagination from '@/Layouts/pagination'
// import VueMultiselect from 'vue-multiselect'

export default {
    components: {
        Head,
        Link,
        useForm,
        BreezeButton,
        BreezeAuthenticatedLayout,
        BreezeInput,
        BreezeLabel,
        BreezeValidationErrors,
        Pagination,
        // VueMultiselect

    },
    data() {
        return {
            ali: [1,2,5],
            test: {},
            newUsers: {},
            search : {
                fullname : '',
                email : '',
                province : '',
                city : '',
                // roles: [],
                birth: '',
                created_at : '',

            },
            myDateObj : {}


        }
    },
    props: {
        users: Object,//afterwards, delete it and use Inertia attr
        roles:{}
    },
    watch:{
      search:{
          handler(val){
            this.keepingDate();
            // this.getRolesId();
            Inertia.reload({
                replace: true,
                preserveState: true,
                data: this.search
            });

          },
          deep:true
      }
    },
    methods: {
        // getRolesId()
        // {
        //     let i = this.search.roles.filter(function (role) {
        //         return role.id;
        //     });
        //     console.log(i[0]);
        // },
        // addTag (newTag) {
        //     const tag = {
        //         name: newTag,
        //         code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
        //     }
        //     this.roles.push(tag)
        //     this.search.roles.push(tag)
        // },
        keepingDate(){
            this.search.birth = this.$refs.birth.value;
            this.search.created_at = this.$refs.created_at.value;
        },
        destroyUser(id) {
            this.$inertia.delete(route("users.destroy", id));

        },
        // reset(){
        //     this.user
        // }
        datepicker() {
            console.log(this.search);
            console.log('before doucment ready');

            const pd = $(".datepicker").pDatepicker({
                "inline": false,
                "format": "L",
                "viewMode": "year",
                "initialValue": false,
                "minDate": null,
                "maxDate": 1660459870590,
                "autoClose": true,
                "position": "auto",
                "altFormat": "l",
                "altField": "#altfieldExample",
                "onlyTimePicker": false,
                "onlySelectOnDate": true,
                "calendarType": "persian",
                "inputDelay": 800,
                "observer": true,
                "calendar": {
                    "persian": {
                        "locale": "fa",
                        "showHint": true,
                        "leapYearMode": "algorithmic"
                    },
                    "gregorian": {
                        "locale": "en",
                        "showHint": false
                    }
                },
                "navigator": {
                    "enabled": true,
                    "scroll": {
                        "enabled": true
                    },
                    "text": {
                        "btnNextText": "<",
                        "btnPrevText": ">"
                    }
                },
                "toolbox": {
                    "enabled": true,
                    "calendarSwitch": {
                        "enabled": false,
                        "format": "MMMM"
                    },
                    "todayButton": {
                        "enabled": false,
                        "text": {
                            "fa": "امروز",
                            "en": "Today"
                        }
                    },
                    "submitButton": {
                        "enabled": true,
                        "text": {
                            "fa": "تایید",
                            "en": "Submit"
                        }
                    },
                    "text": {
                        "btnToday": "امروز"
                    }
                },
                "timePicker": {
                    "enabled": false,
                    "step": 1,
                    "hour": {
                        "enabled": false,
                        "step": null
                    },
                    "minute": {
                        "enabled": false,
                        "step": null
                    },
                    "second": {
                        "enabled": false,
                        "step": null
                    },
                    "meridian": {
                        "enabled": false
                    }
                },
                "dayPicker": {
                    "enabled": true,
                    "titleFormat": "YYYY MMMM"
                },
                "monthPicker": {
                    "enabled": true,
                    "titleFormat": "YYYY"
                },
                "yearPicker": {
                    "enabled": true,
                    "titleFormat": "YYYY"
                },
                "responsive": true
            });
            console.log(this.search);

            this.myDateObj = pd;


        }

    },
    mounted() {
        console.log('hi');
        this.datepicker();
        this.keepingDate();

    },
};


</script>
