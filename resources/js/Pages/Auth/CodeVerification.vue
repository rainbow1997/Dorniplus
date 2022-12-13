<script setup>
import BreezeButton from '@/Components/Button.vue'
import BreezeGuestLayout from '@/Layouts/Guest.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import {Head, useForm} from '@inertiajs/inertia-vue3'
import {useStore} from 'vuex'

const store = useStore();
const lang = store.state.language.core;

lang.direction = store.state.language.langInfo.direction;

const form = useForm({
    token: '',
});

const submit = () => {
    form.post(route('checking_verification'));
};
</script>

<template>
    <BreezeGuestLayout>
        <Head :title="lang.code_verification"/>

        <div :class="`${lang.direction == 'rtl'?'text-right':'text-left'} mb-4 text-sm text-gray-600`">
            {{ lang.enter_code_verification }}
        </div>

        <BreezeValidationErrors class="mb-4"/>

        <form :class="lang.direction == 'rtl'?'text-right':'text-left'" @submit.prevent="submit">
            <div>
                <BreezeLabel :value="lang.token" for="token"/>
                <BreezeInput id="token" v-model="form.token" autocomplete="off" autofocus class="mt-1 block w-full"
                             required
                             type="number"/>
            </div>

            <div class="flex items-center justify-content-center mt-4">
                <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">

                    {{ lang.submit }}
                </BreezeButton>
            </div>
        </form>
    </BreezeGuestLayout>
</template>
