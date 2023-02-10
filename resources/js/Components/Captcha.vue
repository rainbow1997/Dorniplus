<template>
    <div class="flex mt-4">
        <img id="captcha" :src="route(store.state.language.langName + '.captchaImg')" class="shadow ">
        <input v-model="captcha_num" :placeholder="store.state.language.core.security_code + '*'" class="shadow"
               name="captcha_num"
               required style="width:168px;height: 50px" type="number"
               @blur="$emit('enteredCaptcha',captcha_num)">


    </div>
</template>

<script setup>
import {ref} from 'vue'

import {useStore} from 'vuex'

const store = useStore();
const captcha_num = ref();

</script>

<style scoped>

</style>
