<template>
    <users-index :users="users" is-from-site-admin="true"></users-index>

</template>
<script setup>
import UsersIndex from '../UsersIndex';
import {Head, useForm} from '@inertiajs/inertia-vue3';
import { ref, reactive, computed } from 'vue'
import { Inertia } from '@inertiajs/inertia'
defineProps({
    users:{}
});
</script>
