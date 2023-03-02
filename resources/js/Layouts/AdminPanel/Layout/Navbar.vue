<template>

    <!-- Nav Bar -->
    <div class="min-h-screen hidden lg:block my-4 mr-4 shadow-lg relative w-80">
        <div class="min-h-screen bg-white h-full rounded-2xl dark:bg-gray-700">
            <div class="flex items-center justify-center pt-6">
                <svg class="block h-9 w-auto" viewBox="0 0 316 316" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M305.8 81.125C305.77 80.995 305.69 80.885 305.65 80.755C305.56 80.525 305.49 80.285 305.37 80.075C305.29 79.935 305.17 79.815 305.07 79.685C304.94 79.515 304.83 79.325 304.68 79.175C304.55 79.045 304.39 78.955 304.25 78.845C304.09 78.715 303.95 78.575 303.77 78.475L251.32 48.275C249.97 47.495 248.31 47.495 246.96 48.275L194.51 78.475C194.33 78.575 194.19 78.725 194.03 78.845C193.89 78.955 193.73 79.045 193.6 79.175C193.45 79.325 193.34 79.515 193.21 79.685C193.11 79.815 192.99 79.935 192.91 80.075C192.79 80.285 192.71 80.525 192.63 80.755C192.58 80.875 192.51 80.995 192.48 81.125C192.38 81.495 192.33 81.875 192.33 82.265V139.625L148.62 164.795V52.575C148.62 52.185 148.57 51.805 148.47 51.435C148.44 51.305 148.36 51.195 148.32 51.065C148.23 50.835 148.16 50.595 148.04 50.385C147.96 50.245 147.84 50.125 147.74 49.995C147.61 49.825 147.5 49.635 147.35 49.485C147.22 49.355 147.06 49.265 146.92 49.155C146.76 49.025 146.62 48.885 146.44 48.785L93.99 18.585C92.64 17.805 90.98 17.805 89.63 18.585L37.18 48.785C37 48.885 36.86 49.035 36.7 49.155C36.56 49.265 36.4 49.355 36.27 49.485C36.12 49.635 36.01 49.825 35.88 49.995C35.78 50.125 35.66 50.245 35.58 50.385C35.46 50.595 35.38 50.835 35.3 51.065C35.25 51.185 35.18 51.305 35.15 51.435C35.05 51.805 35 52.185 35 52.575V232.235C35 233.795 35.84 235.245 37.19 236.025L142.1 296.425C142.33 296.555 142.58 296.635 142.82 296.725C142.93 296.765 143.04 296.835 143.16 296.865C143.53 296.965 143.9 297.015 144.28 297.015C144.66 297.015 145.03 296.965 145.4 296.865C145.5 296.835 145.59 296.775 145.69 296.745C145.95 296.655 146.21 296.565 146.45 296.435L251.36 236.035C252.72 235.255 253.55 233.815 253.55 232.245V174.885L303.81 145.945C305.17 145.165 306 143.725 306 142.155V82.265C305.95 81.875 305.89 81.495 305.8 81.125ZM144.2 227.205L100.57 202.515L146.39 176.135L196.66 147.195L240.33 172.335L208.29 190.625L144.2 227.205ZM244.75 114.995V164.795L226.39 154.225L201.03 139.625V89.825L219.39 100.395L244.75 114.995ZM249.12 57.105L292.81 82.265L249.12 107.425L205.43 82.265L249.12 57.105ZM114.49 184.425L96.13 194.995V85.305L121.49 70.705L139.85 60.135V169.815L114.49 184.425ZM91.76 27.425L135.45 52.585L91.76 77.745L48.07 52.585L91.76 27.425ZM43.67 60.135L62.03 70.705L87.39 85.305V202.545V202.555V202.565C87.39 202.735 87.44 202.895 87.46 203.055C87.49 203.265 87.49 203.485 87.55 203.695V203.705C87.6 203.875 87.69 204.035 87.76 204.195C87.84 204.375 87.89 204.575 87.99 204.745C87.99 204.745 87.99 204.755 88 204.755C88.09 204.905 88.22 205.035 88.33 205.175C88.45 205.335 88.55 205.495 88.69 205.635L88.7 205.645C88.82 205.765 88.98 205.855 89.12 205.965C89.28 206.085 89.42 206.225 89.59 206.325C89.6 206.325 89.6 206.325 89.61 206.335C89.62 206.335 89.62 206.345 89.63 206.345L139.87 234.775V285.065L43.67 229.705V60.135ZM244.75 229.705L148.58 285.075V234.775L219.8 194.115L244.75 179.875V229.705ZM297.2 139.625L253.49 164.795V114.995L278.85 100.395L297.21 89.825V139.625H297.2Z"></path>
                </svg>

            </div>
            <nav class="mt-6">
                <div>
                    <Link :class="isActiveItem(langPrefix + '.dashboard')"
                          :href="route(langPrefix +'.dashboard')">
                            <span class="text-left">
                                <svg fill="currentColor" height="20" viewBox="0 0 2048 1792" width="20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1070 1178l306-564h-654l-306 564h654zm722-282q0 182-71 348t-191 286-286 191-348 71-348-71-286-191-191-286-71-348 71-348 191-286 286-191 348-71 348 71 286 191 191 286 71 348z">
                                    </path>
                                </svg>
                            </span>
                        <span class="mx-4  font-normal text-lg">
                                داشبورد
                            </span>
                    </Link>


                    <Link :class="isActiveItem(langPrefix + '.users.index')"
                          :href="route(langPrefix +'.users.index')">
                            <span class="text-left">
                                <svg class="h-5 w-5" fill="currentColor" stroke="currentColor"
                                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"/>
                                </svg>
                            </span>
                        <span class="mx-4 text-sm font-normal">
                                کاربران
                            </span>
                    </Link>
                    <Link :class="isActiveItem(langPrefix + '.categories.index')"
                          :href="route(langPrefix +'.categories.index')">
                            <span class="text-left">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                                </svg>
                            </span>
                        <span class="mx-4 text-sm font-normal">
                                موضوعات
                            </span>
                    </Link>

                    <Link :class="isActiveItem(langPrefix + '.posts.index')"
                          :href="route(langPrefix +'.posts.index')">
                            <span class="text-left">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                </svg>
                            </span>
                        <span class="mx-4 text-sm font-normal">
                                مطالب
                            </span>
                    </Link>

                    <Link :class="isActiveItem(langPrefix + '.comments.index')"
                          :href="route(langPrefix +'.comments.index')">
                            <span class="text-left">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                </svg>
                            </span>
                        <span class="mx-4 text-sm font-normal">
                                نظرات

                            </span>
                    </Link>

                    <Link :class="isActiveItem(langPrefix + '.permissions.index')"
                          :href="route(langPrefix +'.permissions.index')">
                            <span class="text-left">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path clip-rule="evenodd"
                                          d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z"
                                          fill-rule="evenodd"/>
                                </svg>
                            </span>
                        <span class="mx-4 text-sm font-normal">
                                دسترسی و مجوز
                            </span>
                    </Link>


                    <Link :class="isActiveItem(langPrefix + '.roles.index')"
                          :href="route(langPrefix +'.roles.index')">
                            <span class="text-left">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                                </svg>
                            </span>
                        <span class="mx-4 text-sm font-normal">
                                نقش های کاربری
                            </span>
                    </Link>

                    <Link :class="isActiveItem(langPrefix + '.site_admin.index')"
                          :href="route(langPrefix +'.site_admin.index')">
                            <span class="text-left">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                                </svg>
                            </span>
                        <span class="mx-4 text-sm font-normal">
                                مدیران سایت
                            </span>
                    </Link>

                    <Link :class="isActiveItem(langPrefix + '.regions.index')"
                          :href="route(langPrefix +'.regions.index')">
                            <span class="text-left">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                                </svg>
                            </span>
                        <span class="mx-4 text-sm font-normal">
                                مناطق
                            </span>
                    </Link>
                    <Link :class="isActiveItem(langPrefix + '.logs')"
                          :href="route(langPrefix +'.logs')">
                            <span class="text-left">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                                </svg>
                            </span>
                        <span class="mx-4 text-sm font-normal">
                                گزارشات (لاگ ها)
                            </span>
                    </Link>
                    <form @submit.prevent="logoutForm.post(route(langPrefix +'.logout'))">
                        <button :class="isActiveItem(langPrefix + '.logout')" :href="route(langPrefix +'.logout')"
                                type="submit">
                            <span class="text-left">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                                </svg>
                            </span>

                            <span class="mx-4 text-sm font-normal">
                                خروج
                            </span>
                        </button>
                    </form>

                </div>
            </nav>
            <!--            <div class="absolute bottom-0 my-10">-->
            <!--                <Link class="text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 transition-colors duration-200 flex items-center py-2 px-8"-->
            <!--                   href="https://github.com/aminesmkhani/aminpanel">-->
            <!--                    <svg width="20" xmlns="http:/www.w3.org/2000/svg" class="text-blue-500 h-5 w-5"-->
            <!--                         viewBox="0 0 20 20" fill="currentColor">-->
            <!--                        <path fill-rule="evenodd"-->
            <!--                              d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"-->
            <!--                              clip-rule="evenodd" />-->
            <!--                    </svg>-->
            <!--                    <span class="mx-4">-->
            <!--                            امین پنل-->
            <!--                        </span>-->
            <!--                </Link>-->
            <!--            </div>-->
        </div>
    </div>
    <!-- End Navbar  -->
</template>

<script setup>
import {Link, useForm} from '@inertiajs/vue3'
import {useStore} from "vuex";
import {computed} from 'vue'

const store = useStore();
const lang = store.state.language;
const langPrefix = lang.langName;

const isActiveItem = (routeName) => {
    const url = window.location.href;

    const classesForActive = 'w-full font-thin text-blue-500 flex items-center p-4 my-2 transition-colors ' +
        'duration-200 justify-start bg-gradient-to-l from-white to-blue-100 border-l-4 ' +
        'border-blue-500 dark:from-gray-700 dark:to-gray-800 border-l-4 border-blue-500';

    const classesForOthers = 'w-full font-thin text-gray-500 dark:text-gray-200 flex items-center p-4 my-2 ' +
        'transition-colors duration-200 justify-start hover:text-blue-500';

    if (route(routeName) == url)
        return classesForActive;

    return classesForOthers;

}
const logoutForm = useForm({});
</script>

<style scoped>

</style>
