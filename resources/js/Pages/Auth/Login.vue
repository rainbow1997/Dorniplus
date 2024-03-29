<script setup>
import BreezeButton from '@/Components/Button.vue'
import BreezeCheckbox from '@/Components/Checkbox.vue'
import BreezeGuestLayout from '@/Layouts/Guest.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import {Head, Link, useForm} from '@inertiajs/vue3'
import {useStore} from 'vuex'
import Captcha from '../../Components/Captcha.vue'

const store = useStore();
const lang = store.state.language.core;
const langPrefix = store.state.language.langName;

lang.direction = store.state.language.langInfo.direction;
defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
    captcha_status: false,
    captcha_num: null
});
const receiveCaptcha = (code) => {
    form.captcha_num = code;

}
const submit = () => {
    form.post(route(langPrefix + '.login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <BreezeGuestLayout>
        <Head :title="lang.login"/>

        <BreezeValidationErrors class="mb-4"/>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form :class="lang.direction == 'rtl'?'text-right':'text-left'" @submit.prevent="submit">
            <div>
                <BreezeLabel :value="lang.email_address" for="email"/>
                <BreezeInput id="email" v-model="form.email" autocomplete="username" autofocus class="mt-1 block w-full"
                             required
                             type="email"/>
            </div>

            <div class="mt-4">
                <BreezeLabel :value="lang.password" for="password"/>
                <BreezeInput id="password" v-model="form.password" autocomplete="current-password"
                             class="mt-1 block w-full" required
                             type="password"/>
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <BreezeCheckbox v-model:checked="form.remember" name="remember"/>
                    <span class="ml-2 text-sm text-gray-600">{{ lang.remember_me }}</span>
                </label>
            </div>

            <div class="block mt-4">
                <captcha @entered-captcha="receiveCaptcha"></captcha>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link v-if="canResetPassword" :href="route(langPrefix + '.password.request')"
                      class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ lang.forget_password }}
                </Link>

                <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="mr-4">
                    {{ lang.login }}
                </BreezeButton>
            </div>
        </form>
    </BreezeGuestLayout>
</template>
