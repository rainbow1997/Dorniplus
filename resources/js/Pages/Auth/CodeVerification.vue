<script setup>
import BreezeButton from '@/Components/Button.vue'
import BreezeGuestLayout from '@/Layouts/Guest.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import {Head, useForm} from '@inertiajs/vue3'
import {useStore} from 'vuex'

const store = useStore();
const lang = store.state.language;

const langPrefix = lang.langName;
lang.direction = store.state.language.langInfo.direction;

const form = useForm({
    token: '',
});

const submit = () => {
    form.post(route(langPrefix + '.checking_verification'));
};
</script>

<template>
    <BreezeGuestLayout>
        <Head :title="lang.core.code_verification"/>

        <div :class="`${lang.core.direction == 'rtl'?'text-right':'text-left'} mb-4 text-sm text-gray-600`">
            {{ lang.core.enter_code_verification }}
        </div>

        <BreezeValidationErrors class="mb-4"/>

        <form :class="lang.core.direction == 'rtl'?'text-right':'text-left'" @submit.prevent="submit">
            <div>
                <BreezeLabel :value="lang.core.token" for="token"/>
                <BreezeInput id="token" v-model="form.token" autocomplete="off" autofocus class="mt-1 block w-full"
                             required
                             type="number"/>
            </div>

            <div class="flex items-center justify-content-center mt-4">
                <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">

                    {{ lang.core.submit }}
                </BreezeButton>
            </div>
        </form>
    </BreezeGuestLayout>
</template>
