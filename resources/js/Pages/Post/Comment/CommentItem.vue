<template>
    <div class="grid grid-cols-3 ">
        <div>
            Name : {{ props.comment.fullname }}
        </div>
        <div>
            Email : {{ props.comment.email }}
        </div>
        <div>
            Text:
            {{ props.comment.text }}
        </div>
        <div>
            Datetime:
            {{ props.comment.created_at }}
        </div>

    </div>


</template>

<script setup>
const props = defineProps({
    comment: []
})
</script>

<style scoped>

</style>
