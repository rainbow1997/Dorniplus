<script setup>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import {Link, usePage} from '@inertiajs/inertia-vue3';
import {Inertia} from '@inertiajs/inertia'
import {computed} from 'vue'

import NavLink from '@/Components/NavLink'
import {useStore} from 'vuex'

let store = useStore();
let lang = computed(() => store.state.language.core);

const props = defineProps({
    smWidthClass: {type: String, default: 'max-w-md'}
});

const changeLangInVuex = async (site_locale) => {

    try {
        const langsFromInertia = await usePage().props.value.langs;
        await store.commit('setLangName', langsFromInertia.site_locale);
        await store.commit('setLang', langsFromInertia[store.state.language.langName]);//what is the anothe
    } catch (e) {

    }
};
const changeLang = async (site_locale) => {
    Inertia.visit(route('setLang', site_locale),
        {
            forceFormData: true, replace: true, onFinish: () => {
                changeLangInVuex(site_locale)
            }
        });


}
</script>

<template>

    <div class=" container mx-auto w-50 ">
        <nav
            class="shadow-2xl navbar-sticky px-2 sm:px-4 py-2.5 justify-between dark:bg-gray-900  w-full z-20 top-0 left-0 border-b border-gray-200 dark:border-gray-600">
            <div class=" flex flex-wrap   b md:justify-between justify-around ">

                <div class="self-center order-1">

                    <nav-link aria-current="page"
                              class="focus:outline-none text-white focus:text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900"
                              :href="route('homepage')">{{ lang.homepage }}
                    </nav-link>

                </div>


                <div class="flex items-center order-2 justify-between gap-x-4">
                    <div class="flex gap-x-4 ">
                        <button
                            class=" "
                            @click="changeLang('fa_IR')">
                            <img alt="Iran" class="w-full h-10" src="/img/flag-for-iran-svgrepo-com.svg">
                        </button>

                        <nav-link
                            class=" "
                            @click="changeLang('en_US')">

                            <img alt="United states of America" class="w-full h-10"
                                 src="/img/united-states-of-america-svgrepo-com.svg">
                        </nav-link>

                    </div>
                    <Link href="/">
                        <BreezeApplicationLogo class="mr-3 h-6 text-gray-500"/>
                    </Link>
                    <span
                        class="m-2 self-center text-xl font-semibold whitespace-nowrap dark:text-white">
                    {{ lang.appName }}</span>
                    <div class="flex">
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

                </div>
                <div id="navbar-sticky" class="hidden w-full md:flex md:w-auto order-3">
                    <ul class="md:order-3  flex md:flex-row flex-col p-4 mt-4 justify-between bg-gray-50  rounded-lg border border-gray-100 md:flex-row  w-full md:mt-0 md:text-sm md:font-medium md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                        <li class="text-center">
                        <span v-if="!$page.props.auth.user"
                              class="flex md:flex-row flex-col w-full gap-x-4 gap-y-4   text-center ">


                            <nav-link
                                class="  focus:outline-none focus:text-white text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm md:px-5  dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900"
                                href="/register">{{ lang.register }}
                            </nav-link>


                            <nav-link v-if="!$page.props.auth.user"
                                      class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm md:px-5  dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900 focus:text-white"
                                      href="/login">
                                {{ lang.login }}
                            </nav-link>


                        </span>
                        </li>


                        <li v-if="$page.props.auth.user">

                            <nav-link
                                class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 mx-2  dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900 focus:text-white"

                                href="/admin/dashboard">
                                {{ lang.panel }}
                            </nav-link>

                        </li>

                    </ul>
                </div>
            </div>
        </nav>
    </div>
</template>
