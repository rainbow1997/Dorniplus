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
                           class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                           placeholder=" " required type="text"/>
                    <label
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        for="floating_first_name">Full
                        name</label>
                </div>

                <div class="relative z-0 mb-6 w-full group">
                    <input id="email" v-model="form.email"
                           class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                           placeholder=" " required type="email"/>
                    <label
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        for="floating_first_name">Email</label>
                </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 mb-6 w-full group">
                    <input id="phone" v-model="form.phone"
                           class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                           placeholder=" " required type="tel"/>
                    <label
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        for="floating_first_name">Phone(optional)</label>
                </div>
                <captcha @entered-captcha="receiveCaptcha"></captcha>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400" for="message">Your
                        message</label>
                    <textarea id="text" v-model="form.text"
                              class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                              placeholder="Leave a comment..." rows="4"></textarea>

                </div>

            </div>
            <div>

                <button :disabled="form.processing"
                        class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                        type="submit">
                    Send
                </button>
            </div>
        </div>
    </form>

</template>

<script setup>
import {useForm} from '@inertiajs/inertia-vue3'
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
    phone: '+98',
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
