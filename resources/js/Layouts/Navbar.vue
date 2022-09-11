<script setup>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import {Link} from '@inertiajs/inertia-vue3';
import NavLink from '@/Components/NavLink'

defineProps({
    smWidthClass: {type: String, default: 'max-w-md'}
});
</script>

<template>


    <nav
        class="navbar-sticky bg-white px-2 sm:px-4 py-2.5 justify-between dark:bg-gray-900  w-full z-20 top-0 left-0 border-b border-gray-200 dark:border-gray-600">
        <div class="container flex flex-wrap items-center  justify-between mx-auto">
            <div class="flex items-center">
                <Link href="/">
                    <BreezeApplicationLogo class="mr-3 h-6 text-gray-500"/>
                </Link>
                <span
                    class="m-2 self-center text-xl font-semibold whitespace-nowrap dark:text-white">{{
                        $page.props.appName
                    }}</span>
            </div>


            <div v-if="!$page.props.auth.user" class="flex md:order-2">


                <nav-link
                    class="focus:outline-none focus:text-white text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900"
                    href="/register">ثبت نام
                </nav-link>
                <div v-if="!$page.props.auth.user">


                    <nav-link
                        class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 mx-2  dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900 focus:text-white"
                        href="/login">
                        ورود
                    </nav-link>

                </div>

                <button aria-controls="navbar-sticky" aria-expanded="false"
                        class=" focus:text-white m-2 inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                        data-collapse-toggle="navbar-sticky" type="button">
                    <span class="sr-only">Open main menu</span>
                    <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd"
                              d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                              fill-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            <div id="navbar-sticky" class="hidden justify-between items-center w-full md:flex md:w-auto md:order-1">
                <ul class="flex flex-col p-4 mt-4 bg-gray-50  rounded-lg border border-gray-100 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    <li>

                        <nav-link aria-current="page"
                                  class="focus:outline-none text-white focus:text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900"
                                  href="/">صفحه اصلی
                        </nav-link>

                    </li>


                    <li v-if="$page.props.auth.user">

                        <nav-link
                            class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 mx-2  dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900 focus:text-white"

                            href="/dashboard">
                            پنل کاربری
                        </nav-link>

                    </li>


                </ul>
            </div>
        </div>
    </nav>
</template>
