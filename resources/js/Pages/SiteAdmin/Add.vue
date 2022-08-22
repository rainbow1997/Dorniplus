<template>
<users-index v-if="chosenUser.status == false" @set-user="callback" :users="users" :is-from-site-admin-add="true">

</users-index>
<div v-if="chosenUser.status">
    کاربر انتخابی

</div>
</template>

<script setup>
import UsersIndex from '../UsersIndex';
import {Head, useForm} from '@inertiajs/inertia-vue3';
import { ref, reactive, computed } from 'vue'
import { Inertia } from '@inertiajs/inertia'

defineProps({
    users: [],
});
let chosenUser = reactive({
    status:false,
    user_id:null
});
const callback = (n) => {
    if ( confirm('آیا مطمئنید ؟') )
    {
        console.log('hi');
        chosenUser.user_id = n;
        chosenUser.status = true;
        console.log(chosenUser);
        storeNewAdmin();
    }

};
const storeNewAdmin = () =>{
  Inertia.visit(route('site_admin.store'),{
      method : 'post',
      data : { id:chosenUser.user_id}
  });
}



</script>

<style scoped>

</style>
