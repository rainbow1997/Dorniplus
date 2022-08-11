<template>
    <Head title="مدیریت مطالب"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="flex flex-col">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    مطالب سایت
                </h2>

                <div class="my-2 flex flex-row space-around ">

                    <button
                        class="mx-2 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                        <a :href="route('posts.create')">
                            افزودن مطلب جدید
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
                                <span class="font-medium">دقت کنید!</span> برای جست و جو می توانید از پارامتر های مختلف به طور همزمان استفاده کنید.
                            </div>
                            <div class="flex  items-center justify-evenly">

                                <input id="post-title" v-model="search.title"
                                       class="rounded-none rounded-l-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block min-w-0  text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="عنوان مطلب..."
                                       type="text">

                                <input id="post-category-title" v-model="search.category_title"
                                       class="rounded-none rounded-l-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block min-w-0  text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="موضوع..."
                                       type="text">

                                <input id="post-title" v-model="search.writer_name"
                                       class="rounded-none rounded-l-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block min-w-0  text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="نویسنده..."
                                       type="text">

                                <input id="post-title" ref="start_date"
                                       v-model="search.start_date"
                                       class="datepicker rounded-none rounded-l-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block min-w-0  text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="ابتدای بازه زمانی مورد نظر..." type="text">


                                <input id="post-title" ref="end_date"
                                       v-model="search.end_date"
                                       class="datepicker rounded-none rounded-l-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block min-w-0  text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="انتهای بازه زمانی موردنظر..." type="text">

                                <!--&lt;!&ndash;                                <select v-model="searchingItem"&ndash;&gt;-->
                                <!--&lt;!&ndash;                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">&ndash;&gt;-->
                                <!--&lt;!&ndash;                                    <option value="fname">&ndash;&gt;-->
                                <!--&lt;!&ndash;                                        عنوان&ndash;&gt;-->
                                <!--&lt;!&ndash;                                    </option>&ndash;&gt;-->
                                <!--&lt;!&ndash;                                    <option value="lname">&ndash;&gt;-->
                                <!--&lt;!&ndash;                                        موضوع&ndash;&gt;-->
                                <!--&lt;!&ndash;                                    </option>&ndash;&gt;-->
                                <!--&lt;!&ndash;                                    <option value="province">&ndash;&gt;-->
                                <!--&lt;!&ndash;                                        نویسنده&ndash;&gt;-->
                                <!--&lt;!&ndash;                                    </option>&ndash;&gt;-->
                                <!--&lt;!&ndash;                                    <option value="city">&ndash;&gt;-->
                                <!--&lt;!&ndash;                                        زمان آخرین تغییر&ndash;&gt;-->
                                <!--&lt;!&ndash;                                    </option>&ndash;&gt;-->

                                <!--&lt;!&ndash;                                </select>&ndash;&gt;-->
                                <!--                                <input v-model="searchingInput"-->
                                <!--                                       class="mx-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"-->
                                <!--                                       name="searchingInput"-->
                                <!--                                       type="text"-->
                                <!--                                       v-on:keyup="onSearch">-->

                            </div>
                        </div>

                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                                <tr>
                                    <th class="py-3 px-6 bg-gray-50 dark:bg-gray-800" scope="col">شناسه</th>
                                    <th class="py-3 px-6 bg-gray-50 dark:bg-gray-800" scope="col">عنوان</th>
                                    <th class="py-3 px-6 bg-gray-50 dark:bg-gray-800" scope="col">موضوع</th>
                                    <th class="py-3 px-6 bg-gray-50 dark:bg-gray-800" scope="col">نویسنده</th>
                                    <th class="py-3 px-6 bg-gray-50 dark:bg-gray-800" scope="col">زمان تقریبی مطالعه
                                    </th>
                                    <th class="py-3 px-6 bg-gray-50 dark:bg-gray-800" scope="col">زمان ایجاد</th>
                                    <th class="py-3 px-6 bg-gray-50 dark:bg-gray-800" scope="col">زمان آخرین بروزرسانی
                                    </th>
                                    <th class="py-3 px-6 bg-gray-50 dark:bg-gray-800" scope="col" width="280px">
                                        عملیات
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="post in posts.data"
                                    class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                    <td class="py-4 px-6">{{ post.id }}</td>
                                    <td class="py-4 px-6">{{ post.title }}</td>
                                    <td class="py-4 px-6">{{ post.category.title }}</td>
                                    <td class="py-4 px-6">{{ post.writer_person.fname }} - {{
                                            post.writer_person.lname
                                        }}
                                    </td>
                                    <td class="py-4 ">{{ post.estimated_time }}</td>
                                    <td class="py-4 mr-3">{{ post.created_at }}
                                    </td>
                                    <td class="py-4 px-6">{{ post.updated_at }}</td>


                                    <td class="py-4 flex flex-row">
                                        <button
                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                            type="button">

                                            <Link :href="route('posts.show',post.id)" class="btn btn-info">مشاهده</Link>
                                        </button>
                                        <button
                                            class="text-white bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:focus:ring-yellow-900"
                                            type="button">

                                            <a :href="route('posts.edit',post.id)" class="btn btn-primary">ویرایش</a>
                                        </button>
                                        <button
                                            class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                                            type="button">

                                            <a class="btn btn-primary" @click="destroyUser(post.id)">حذف</a></button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <pagination :links="posts.links" class="mt-6"/>

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
import BreezeButton from '@/Components/Button.vue';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeCheckbox from '@/Components/Checkbox.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import '../Auth/persian-datepicker.js';// in another time,use modules.env not this statically manner.
import '../Auth/persian-datepicker.min.css';
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';
import Pagination from '@/Layouts/pagination'

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
        Pagination

    },
    data() {
        return {
            test: {},
            newPosts: {},
            search: {
                title: '',
                category_title: '',
                writer_name: '',
                start_date: '',
                end_date: ''
            },

            myDateObj: {}

        }
    },
    props: {
        posts: Object,//afterwards, delete it and use Inertia attr
    },
    watch: {
        search: {
            handler(val) {

                // this.search = val;
                console.log(this.search);
                this.keepDating();
                Inertia.reload({
                    replace: true,
                    preserveState: true,
                    data: this.search
                });
            },
            deep: true

        },

    },
    methods: {
        keepDating() {
            this.search.start_date = this.$refs.start_date.value;
            this.search.end_date = this.$refs.end_date.value;
        },
        destroyUser(id) {
            this.$inertia.delete(route("posts.destroy", id));

        },
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
        // reset(){
        //     this.user
        // }
    },
    mounted() {
        console.log('hi');

        this.datepicker();
        this.keepDating();

    },
};


</script>
