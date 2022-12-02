<template>
    <users-index :users="props.users" is-from-site-admin="true"></users-index>

</template>
<script setup>
import UsersIndex from '../UsersIndex.vue'

const props = defineProps({
    users: {}
});
</script>
