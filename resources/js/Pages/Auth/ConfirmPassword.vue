<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import {Head, useForm} from '@inertiajs/inertia-vue3';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    })
};
</script>

<template>
    <BreezeGuestLayout>
        <Head title="Confirm Password"/>

        <div class="mb-4 text-sm text-gray-600">
            این بخش از قسمت های حساس مجموعه است، لطفا رمز عبور خود را دوباره وارد نمائید
        </div>

        <BreezeValidationErrors class="mb-4"/>

        <form @submit.prevent="submit">
            <div>
                <BreezeLabel for="password" value="رمز عبور"/>
                <BreezeInput id="password" v-model="form.password" autocomplete="current-password" autofocus
                             class="mt-1 block w-full"
                             required type="password"/>
            </div>

            <div class="flex justify-end mt-4">
                <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="ml-4">
                    تائید
                </BreezeButton>
            </div>
        </form>
    </BreezeGuestLayout>
</template>
