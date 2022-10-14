<template>
    <div class="flex items-start justify-between">
        <navbar></navbar>
        <div class="flex flex-col w-full pl-0 md:p-4 md:space-y-4 h-screen">

        <my-header></my-header>
        <slot>

        </slot>
    </div>
    </div>

</template>

<script setup>
import Navbar from './Navbar'
import MyHeader from './Header'
</script>

<style scoped>

</style>
