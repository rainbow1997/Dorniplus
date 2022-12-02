<template>
    <div class="grid grid-cols-3 space-y-2 mt-2 w-full " >
        <div>
            <span class="font-bold">Name</span> :
            <span class="font-serif text-base	">{{ props.comment.fullname }}</span>
        </div>
        <div>
            <span class="font-bold">Email</span> :
            <span class="font-serif">{{ props.comment.email }} </span>
        </div>
        <div>
            <span class="font-bold">Datetime</span> :
            <span class="font-mono">{{ props.comment.created_at }}</span>
        </div>

        <div class="flex flex-col w-full col-span-3 ">
            <span class="break-after-column font-bold">Content :</span>

            <p>{{ props.comment.text }}</p>
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
