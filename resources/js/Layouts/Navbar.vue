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
        class="navbar-sticky bg-white px-2 sm:px-4 py-2.5 dark:bg-gray-900  w-full z-20 top-0 left-0 border-b border-gray-200 dark:border-gray-600">
        <div class="container flex flex-wrap justify-between items-center mx-auto">
            <div class="flex items-center">
                <Link href="/">
                    <BreezeApplicationLogo class="mr-3 h-6 text-gray-500"/>
                </Link>
                <span
                    class="m-2 self-center text-xl font-semibold whitespace-nowrap dark:text-white">{{ $page.props.appName }}</span>
            </div>

            <div class="flex md:order-2">


                <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-3 md:mr-0 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">
                    <nav-link class="text-white" href="/register">ثبت نام</nav-link>
                </button>
                <button aria-controls="navbar-sticky" aria-expanded="false"
                        class="m-2 inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
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
                        <button class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                type="button">

                            <nav-link aria-current="page"
                                      class="block py-2 pr-4 pl-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white hover:text-red-400"
                                      href="/">صفحه اصلی
                            </nav-link>
                        </button>
                    </li>
                    <li>
                        <button class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-10 py-2.5 text-center mr-2 mb-2"
                                type="button">

                            <nav-link class="block py-2 pr-4 pl-3 text-gray-300 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-white-700 md:p-0 md:dark:hover:text-white dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"
                                      href="/login">
                                ورود
                            </nav-link>
                        </button>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</template>
