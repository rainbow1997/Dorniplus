<template>
    <form @submit.prevent="submit">
        <div class="grid auto-cols-auto gap-5">
            <BreezeValidationErrors class="mb-4"/>
            <div v-if="messages">
                DD {{ messages }}
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">

                <div class="relative z-0 mb-6 w-full group">
                    <input id="fullname" v-model="form.fullname"
                           :placeholder="lang.fullname"
                           class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required type="text"/>


                </div>

                <div class="relative z-0 mb-6 w-full group">
                    <input id="email" v-model="form.email"
                           :placeholder="lang.email_address"
                           class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required type="email"/>

                </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 mb-6 w-full group">
                    <input id="phone" v-model="form.phone"
                           :placeholder="lang.phone"
                           class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required type="tel"/>

                </div>
                <captcha @entered-captcha="receiveCaptcha"></captcha>

                <div>

                    <textarea id="text" v-model="form.text"
                              :placeholder="lang.leave_comment"
                              class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" rows="4"></textarea>

                </div>

            </div>
            <div class="my-3 flex justify-center">

                <button :disabled="form.processing"
                        class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                        type="submit">
                    {{ lang.send }}
                </button>
            </div>
        </div>
    </form>

</template>

<script setup>
import {useForm} from '@inertiajs/vue3'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import Captcha from '../../../Components/Captcha.vue'
import {useStore} from "vuex";


const store = useStore();
const lang = store.state.language.core;
const langPrefix = store.state.language.langName;
const props = defineProps({
    post: {},
});
const form = useForm({
    fullname: null,
    email: null,
    text: null,
    phone: '',
    post_id: props.post.id,
    captcha_status: false,
    captcha_num: null
});
const receiveCaptcha = (code) => {
    form.captcha_num = code;

}
const submit = () => {

    form.post(route(langPrefix + '.sendNewComment', form.post_id), {
        preserveScroll: true,
        replace: true,
        forceFormData: true,
    })
}

</script>

<style scoped>

</style>
