<template>
    <users-index v-if="chosenUser.status == false" :is-from-site-admin-add="true" :users="props.users"
                 @set-user="callback">

    </users-index>
    <div v-if="chosenUser.status">
        کاربر انتخابی

    </div>
</template>

<script setup>
import UsersIndex from '../UsersIndex'
import {reactive} from 'vue'
import {Inertia} from '@inertiajs/inertia'

const props = defineProps({
    users: [],
});
const chosenUser = reactive({
    status: false,
    user_id: null
});
const callback = (n) => {
    if (confirm('آیا مطمئنید ؟')) {
        console.log('hi');
        chosenUser.user_id = n;
        chosenUser.status = true;
        console.log(chosenUser);
        storeNewAdmin();
    }

};
const storeNewAdmin = () => {
    Inertia.visit(route('site_admin.store'), {
        method: 'post',
        data: {id: chosenUser.user_id}
    });
}


</script>

<style scoped>

</style>
