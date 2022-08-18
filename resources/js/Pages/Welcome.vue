<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3';
import Pagination from '@/Layouts/pagination'
import Navbar from '@/Layouts/Navbar'

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    posts: {},
    Pagination,
    Navbar,
})
</script>

<template>
<div class="">
    <Head title="Welcome"/>
<header>
    <navbar></navbar>

</header>
    <main class="container mx-auto ">
    <section class=" flex flex-col flex-wrap  bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">


            <!-- For testing -->
            <div
                class="bg-white  md:p-2  flex flex-col   md:flex-row   box-header-color md:gap-y-2 md:mt-8  dark:bg-gray-800 overflow-hidden md:gap-x-3 shadow text-right">
                <div v-for="post in posts.data" class=" flex bg-white md:w-1/3">
                    <article class=" shadow flex flex-col  gap-x-4 bg-slate-50">
                        <div class="w-full  h-full  h-48">
                        <Link  :href="route('posts.show',{post: post.id,title: post.title})" class="opacity-80 hover:opacity-100">
                            <img :alt="post.title" :src="'/storage/'+post.post_image"
                                 class=" object-fill h-48  w-full rounded">
                        </Link>
                        </div>
                        <div class="flex flex-1 flex-col gap-3 ps-4 pt-2 px-2">
                            <div class="shadow border-gray-200 flex h-10 items-center justify-center">
                            <Link :href="route('posts.show',{post: post.id,title: post.title})"
                               class="max-w-sm text-xs text-black md:text-base font-medium box-text-color-darker paragraph-ellipsis-2 leading-relaxed">
                                <h1 class="text-sm  text-black md:text-base font-medium box-text-color-darker paragraph-ellipsis-2 leading-relaxed">
                                    {{ post.title }}</h1>
                            </Link>
                            </div>
                            <div class=" text-xs flex flex-row  p-1 rounded items-center gap-2 bg-zinc-400 text-white">

                                <h6 class="font-light rtl italic ">
                                    نویسنده:
                                    {{ post.writer_person.fname }} {{ post.writer_person.lname }} </h6>
                                <h5 class=" font-medium">موضوع:{{ post.category.title }}</h5>
                                <h6 class="font-light">زمان تقریبی مطالعه:{{ post.estimated_time }}</h6>
                            </div>

                            <div
                                class="h-48 flex flex-col  leading-loose m-1 mt-1 blog-card-paragraph text-sm paragraph-ellipsis-4 sm:paragraph-ellipsis-2 md:paragraph-ellipsis-4 leading-loose text-gray-500">
                                <span v-html="post.text"></span>

                            </div>
                            <button :v-show="post.hasContinue" type="button" class=" flex my-3   w-1/4 text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-3 py-1.5 mr-2  dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                                <Link :href="route('posts.show',{post: post.id,title: post.title})">
                                    ادامه مطلب
                                </Link>

                            </button>


                        </div>
                    </article>
                </div>


            </div>
            <pagination :links="posts.links" class="mt-6"/>

            <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
                <div class="text-center text-sm text-gray-500 sm:text-left">
                    <div class="flex items-center">
                        <svg class="-mt-px w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                             stroke-linecap="round"
                             stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                            <path
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>

                        <a class="ml-1 underline" href="https://laravel.bigcartel.com">
                            Shop
                        </a>

                        <svg class="ml-4 -mt-px w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                             stroke-linecap="round"
                             stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                            <path
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>

                        <a class="ml-1 underline" href="https://github.com/sponsors/taylorotwell">
                            Sponsor
                        </a>
                    </div>
                </div>

                <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </div>
            </div>
        </section>
    </main>
</div>
</template>

<style scoped>
.bg-gray-100 {
    background-color: #f7fafc;
    background-color: rgba(247, 250, 252, var(--tw-bg-opacity));
}

.border-gray-200 {
    border-color: #edf2f7;
    border-color: rgba(237, 242, 247, var(--tw-border-opacity));
}

.text-gray-400 {
    color: #cbd5e0;
    color: rgba(203, 213, 224, var(--tw-text-opacity));
}

.text-gray-500 {
    color: #a0aec0;
    color: rgba(160, 174, 192, var(--tw-text-opacity));
}

.text-gray-600 {
    color: #718096;
    color: rgba(113, 128, 150, var(--tw-text-opacity));
}

.text-gray-700 {
    color: #4a5568;
    color: rgba(74, 85, 104, var(--tw-text-opacity));
}

.text-gray-900 {
    color: #1a202c;
    color: rgba(26, 32, 44, var(--tw-text-opacity));
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-gray-800 {
        background-color: #2d3748;
        background-color: rgba(45, 55, 72, var(--tw-bg-opacity));
    }

    .dark\:bg-gray-900 {
        background-color: #1a202c;
        background-color: rgba(26, 32, 44, var(--tw-bg-opacity));
    }

    .dark\:border-gray-700 {
        border-color: #4a5568;
        border-color: rgba(74, 85, 104, var(--tw-border-opacity));
    }

    .dark\:text-white {
        color: #fff;
        color: rgba(255, 255, 255, var(--tw-text-opacity));
    }

    .dark\:text-gray-400 {
        color: #cbd5e0;
        color: rgba(203, 213, 224, var(--tw-text-opacity));
    }
}
</style>
