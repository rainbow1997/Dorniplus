<script setup>
import BreezeButton from '@/Components/Button.vue'
import BreezeGuestLayout from '@/Layouts/Guest.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import {Head, useForm} from '@inertiajs/vue3'
import {useStore} from 'vuex'

const store = useStore();
const lang = store.state.language.core;
const langPrefix = lang.langName;
defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route(langPrefix + 'password.email'));
};
</script>

<template>
    <BreezeGuestLayout>
        <Head title="Forgot Password"/>

        <div class="mb-4 text-sm text-gray-600">
            رمز خود را فراموش کرده اید؟ مشکلی نیست ایمیل خود را وارد کرده و لینک تغییر رمز را دریافت کنید
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <BreezeValidationErrors class="mb-4"/>

        <form @submit.prevent="submit">
            <div>
                <BreezeLabel for="email" value="ایمیل"/>
                <BreezeInput id="email" v-model="form.email" autocomplete="username" autofocus class="mt-1 block w-full"
                             required
                             type="email"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    ارسال ایمیل بازیابی رمز عبور
                </BreezeButton>
            </div>
        </form>
    </BreezeGuestLayout>
</template>
