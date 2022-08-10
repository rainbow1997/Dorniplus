<template>
    <BreezeGuestLayout smWidthClass="w-full">
        <Head :title="post.title"/>

        <div class="w-full w-responsive px-5 sm:px-6 lg:px-8 ">
            <div class="flex flex-col justify-center items-center gap-2">
                <img :src="'/storage/' + post.post_image" class="w-full h-full object-cover">
                <div class="flex flex-col flex-1 items-center text-right p-2 ">
                    <div class=" text-xs flex flex-row items-center gap-x-2 bg-amber-50">

                        <h6 class="font-light rtl italic ">
                            نویسنده:
                            {{ post.writer_person.fname }} {{ post.writer_person.lname }} </h6>
                        <h5 class=" font-bold">موضوع:{{ post.category.title }}</h5>
                        <h6 class="font-light">زمان تقریبی مطالعه:{{ post.estimated_time }}</h6>
                    </div>
                </div>
            </div>
            <div
                class="flex flex-col gap-y-1 my-2 w-full box-header-color rounded p-5 md:p-6 lg:p-8 xl:p-10 text-3xs font:medium leading-loose bg-blue-50 justify-center">
                <h1 class="font-extrabold">{{ post.title }}</h1>
                <span class="w-full" v-html="post.text">

            </span>
            </div>
        </div>
    </BreezeGuestLayout>
</template>

<script setup>
import BreezeGuestLayout from '@/Layouts/Guest.vue'

import {Head} from '@inertiajs/inertia-vue3'

defineProps({
    post: {}
})
</script>
