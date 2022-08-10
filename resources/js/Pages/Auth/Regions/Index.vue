<template>
    <Head title="مدیریت مناطق"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                استان ها
            </h2>
        </template>

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
                            <tr v-for="province in provinces.data" :key="province.id">
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
                        <pagination :links="provinces.links"/>
                        <div>
                            <h3 class="mb-3">شهر ها</h3>

                            <Link
                                :href="route('regions.city.create',(selectedProvince.id) ? selectedProvince.id:0)"
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
                                <tr v-for="city in this.selectedProvince.cities" :key="city.id">
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
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeNavLink from "@/Components/NavLink.vue";
import {Head} from "@inertiajs/inertia-vue3";
import {Link} from "@inertiajs/inertia-vue3";

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        BreezeNavLink,
        Link,
    },
    data() {
        return {
            selectedProvince: {},
            canShow: false
        }
    },
    props: {
        provinces: Object,
    },
    methods: {
        destroy(id) {
            this.$inertia.delete(route("regions.province.destroy", id));
        },
        destroyCity(id) {
            this.$inertia.delete(route("regions.city.destroy", id));
        },
        chooseProvince(id) {
            //alert(id);
            let t = this.provinces.data.filter(function (province) {
                if (province.id == id) {
                    //alert(province.title);
                    return province;
                }

            });
            console.log(t[0].title);//remember that filter methods in javascript always return array*
            this.selectedProvince = Object.assign({}, t[0]);
            this.canShow = true;
            console.log(this.selectedProvince);
            //alert(this.canShow);
        }
    },
    // computed:{
    //     getCities()
    //     {
    //         //alert(typeof(this.selectedProvince));
    //         return (_.isNull(this.selectedProvince)) ?  '' :  this.selectedProvince.cities
    //     }
    // },
    mounted() {
        //this.selectedProvince = thsis.provinces.data[0];
        //alert(this.selectedProvince);
        this.selectedProvince = '';
    },
};
</script>
