<script setup>
import {computed} from 'vue';
import {Link} from '@inertiajs/vue3';

const props = defineProps(['href', 'active', 'type', 'as']);

const classes = computed(() => props.active
    ? 'inline-flex items-center p-3 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition  duration-150 ease-in-out'
    : 'inline-flex items-center p-3 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-200 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out'
);
</script>

<template>
    <Link :as="props.as" :class="classes" :href="props.href" :type="props.type">
        <slot/>
    </Link>
</template>
