<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import {Head, useForm} from '@inertiajs/inertia-vue3';

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <BreezeGuestLayout>
        <Head title="Reset Password"/>

        <BreezeValidationErrors class="mb-4"/>

        <form @submit.prevent="submit">
            <div>
                <BreezeLabel for="email" value="ایمیل"/>
                <BreezeInput id="email" v-model="form.email" autocomplete="username" autofocus class="mt-1 block w-full"
                             required
                             type="email"/>
            </div>

            <div class="mt-4">
                <BreezeLabel for="password" value="رمز عبور"/>
                <BreezeInput id="password" v-model="form.password" autocomplete="new-password" class="mt-1 block w-full"
                             required
                             type="password"/>
            </div>

            <div class="mt-4">
                <BreezeLabel for="password_confirmation" value="تکرار رمز عبور"/>
                <BreezeInput id="password_confirmation" v-model="form.password_confirmation" autocomplete="new-password"
                             class="mt-1 block w-full" required type="password"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    بازیابی رمزعبور
                </BreezeButton>
            </div>
        </form>
    </BreezeGuestLayout>
</template>
