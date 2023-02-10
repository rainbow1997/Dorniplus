<script setup>
import BreezeButton from '@/Components/Button.vue'
import BreezeGuestLayout from '@/Layouts/Guest.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import {Head, useForm} from '@inertiajs/inertia-vue3'
import {Inertia} from '@inertiajs/inertia'
import {useStore} from "vuex";
import {computed} from 'vue'

const store = useStore();

const lang = computed(() => store.state.language);
const langPrefix = lang.langName;

const props = defineProps({
    user: {}
})
const form = useForm({
    password: '',
    password_confirmation: '',
    user_id: null
});
const submit = () => {
    form.user_id = props.user.id;
    Inertia.post(route(langPrefix +'changePassword.save'), form);
}
</script>

<template>
    <BreezeGuestLayout>
        <Head title="تغییر رمز عبور"/>

        <div class="mb-4 text-sm text-gray-600">
            برای تغییر رمز عبور، رمز عبور مجدد خود را وارد کنید.
        </div>

        <BreezeValidationErrors class="mb-4"/>

        <form @submit.prevent="submit">
            <div>
                <BreezeLabel for="password" value="رمز عبور*"/>
                <BreezeInput id="password" v-model="form.password" autocomplete="current-password" autofocus
                             class="mt-1 block w-full"
                             required type="password"/>
            </div>
            <div class="mt-4">
                <BreezeLabel for="password_confirmation" value="*تکرار رمز عبور"/>
                <BreezeInput id="password_confirmation" v-model="form.password_confirmation" autocomplete="new-password"
                             class="mt-1 block w-full" required type="password"/>
            </div>
            <div class="flex justify-end mt-4">
                <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="ml-4">
                    تایید
                </BreezeButton>
            </div>
        </form>
    </BreezeGuestLayout>
</template>
