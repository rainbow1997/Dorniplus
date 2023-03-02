<script setup>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import {Link} from '@inertiajs/vue3';
import Navbar from '@/Layouts/Navbar.vue'

defineProps({
    smWidthClass: {type: String, default: 'max-w-md'},
    Navbar,

});
</script>

<template>
    <header>
        <navbar></navbar>

    </header>
    <div
        class="container shadow mx-auto min-h-screen flex flex-col sm:justify-center shadow-2xl items-center pt-6 sm:pt-0 bg-gray-100 rtl text-right">
        <div>
            <Link href="/">
                <BreezeApplicationLogo class="w-20 h-30 fill-current pt-5"/>
            </Link>
        </div>

        <div :class=" 'w-full sm:'+ smWidthClass +' mt-6 px-6 overflow-hidden sm:rounded-lg my-2'">
            <slot/>
        </div>
    </div>
</template>
