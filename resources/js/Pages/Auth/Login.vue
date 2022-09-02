<script setup>
import BreezeButton from '@/Components/Button.vue'
import BreezeCheckbox from '@/Components/Checkbox.vue'
import BreezeGuestLayout from '@/Layouts/Guest.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import {Head, Link, useForm} from '@inertiajs/inertia-vue3'

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <BreezeGuestLayout>
        <Head title="ورود به سیستم"/>

        <BreezeValidationErrors class="mb-4"/>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <BreezeLabel for="email" value="ایمیل"/>
                <BreezeInput id="email" v-model="form.email" autocomplete="username" autofocus class="mt-1 block w-full"
                             required
                             type="email"/>
            </div>

            <div class="mt-4">
                <BreezeLabel for="password" value="رمز عبور"/>
                <BreezeInput id="password" v-model="form.password" autocomplete="current-password"
                             class="mt-1 block w-full" required
                             type="password"/>
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <BreezeCheckbox v-model:checked="form.remember" name="remember"/>
                    <span class="ml-2 text-sm text-gray-600">مرا به یاد داشته باش!</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link v-if="canResetPassword" :href="route('password.request')"
                      class="underline text-sm text-gray-600 hover:text-gray-900">
                    فراموشی رمز عبور؟
                </Link>

                <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="mr-4">
                    ورود
                </BreezeButton>
            </div>
        </form>
    </BreezeGuestLayout>
</template>
