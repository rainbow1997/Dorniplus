<template>
    <div class="flex flex-col divide-y divide-gray-300 ">
        <h2 class="p-3 font-bold font-mono self-center ">Users' comments:</h2>
        <div class="font-mono
 w-full flex flex-col leading-loose	text-slate-600	 text-left p-3 divide-y divide-slate-400 gap-3 space-y-3">
            <comment-item v-for="comment in props.comments" :comment="comment"></comment-item>
        </div>
    </div>
    <!--    <comment-item  :comment="props.comments[0]"></comment-item>-->
</template>

<script setup>
import CommentItem from "./CommentItem.vue";

const props = defineProps({
    comments: []
})
</script>

<style scoped>

</style>
