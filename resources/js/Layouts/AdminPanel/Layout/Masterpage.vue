<template>
    <div class="grid grid-cols-4 items-start justify-between">
        <div>
        <navbar></navbar>
        </div>
        <div class="col-span-3 flex h-screen flex-col w-full pl-0 md:p-4">

            <my-header></my-header>

            <slot>

            </slot>
        </div>
    </div>

</template>

<script setup>
import Navbar from './Navbar.vue'
import MyHeader from './Header.vue'</script>

<style scoped>

</style>
