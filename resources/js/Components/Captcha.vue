<template>
    <div class="flex mt-4">
        <img id="captcha" class="shadow " :src="route('captchaImg')">
        <input name="captcha_num" class="shadow" style="width:168px;height: 50px" v-model="captcha_num" :placeholder="store.state.language.core.security_code + '*'" required type="number" @blur="$emit('enteredCaptcha',captcha_num)">


    </div>
</template>

<script setup>
import { ref } from 'vue'

import {useStore} from 'vuex'

const store = useStore();
const captcha_num = ref();




</script>

<style scoped>

</style>
