<template>
    <users-index v-if="chosenUser.status == false" :is-from-site-admin-add="true" :users="props.users"
                 @set-user="callback">

    </users-index>
    <div v-if="chosenUser.status">
        کاربر انتخابی

    </div>
</template>

<script setup>
import UsersIndex from '../UsersIndex.vue'
import {reactive} from 'vue'
import { router } from '@inertiajs/vue3'
import {useStore} from "vuex";
const store = useStore();

const lang =  store.state.language;
const langPrefix = lang.langName;
const props = defineProps({
    users: [],
});
const chosenUser = reactive({
    status: false,
    user_id: null
});
const callback = (n) => {
    if (confirm('آیا مطمئنید ؟')) {
        chosenUser.user_id = n;
        chosenUser.status = true;
        storeNewAdmin();
    }

};
const storeNewAdmin = () => {
    Inertia.visit(route(langPrefix + '.site_admin.store'), {
        method: 'post',
        data: {id: chosenUser.user_id}
    });
}


</script>

<style scoped>

</style>
