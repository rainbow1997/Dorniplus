<template>
    <comments :users="props.comments" is-from-site-admin="true"></comments>

</template>
<script setup>
import Comments from './Comments.vue'

const props = defineProps({
    comments: {}
});
</script>
