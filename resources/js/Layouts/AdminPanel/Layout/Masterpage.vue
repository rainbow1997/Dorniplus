<template>
    <div class="flex items-start justify-between">
        <navbar></navbar>
        <header></header>
        <slot>

        </slot>
    </div>
</template>

<script setup>
import Navbar from './Navbar'
import Header from "./Header"
</script>

<style scoped>

</style>
