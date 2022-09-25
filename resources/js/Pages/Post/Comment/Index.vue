<template>
    <div class="flex flex-col">
    <h2 class="p-3 font-bold italic">Users' comments:</h2>
    <div class="w-full flex flex-col shadow-2xl text-left p-3 divide-y ">
    <comment-item v-for="comment in props.comments" :comment="comment"></comment-item>
    </div>
    </div>
<!--    <comment-item  :comment="props.comments[0]"></comment-item>-->
</template>

<script setup>
import CommentItem  from "./CommentItem";
const props = defineProps({
    comments:[]
})
console.log(props.comments[0]);
</script>

<style scoped>

</style>
