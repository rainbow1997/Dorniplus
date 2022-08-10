<script setup>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import {Link} from '@inertiajs/inertia-vue3';

defineProps({
    smWidthClass: {type: String, default: 'max-w-md'}
});
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 rtl text-right">
        <div>
            <Link href="/">
                <BreezeApplicationLogo class="w-20 h-20 fill-current text-gray-500"/>
            </Link>
        </div>

        <div :class=" 'w-full sm:'+ smWidthClass +' mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg'">
            <slot/>
        </div>
    </div>
</template>
