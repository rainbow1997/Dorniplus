<template>
    <Head title="انضمام مجوز به نقش کاربری"/>

    <masterpage>
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            انضمام مجوز به نقش های کاربری
        </h2>


        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 h-screen">
                <div class=" bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <BreezeValidationErrors class="mb-4"/>
                        <form @submit.prevent="submit">
                            <div class="flex flex-row gap-3 p-6 items-center">
                                <label id="myLabel" class="typo__label" for="mySelect">نقش کاربری هدف</label>
                                <multiselect id="mySelect" v-model="form.values" :clear-on-select="false"
                                             :close-on-select="false"
                                             :multiple="true" :options="roles" :preselect-first="true"
                                             :preserve-search="true" class="max-w-3xl" label="name"
                                             placeholder="انتخاب کنید..." track-by="id">

                                    <template slot="selection" slot-scope="{ values, search, isOpen }"><span
                                        v-if="values.length &amp;&amp; !isOpen" class="multiselect__single">{{
                                            values.length
                                        }} options selected</span></template>

                                </multiselect>
                                <breeze-button>ثبت</breeze-button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </masterpage>
</template>

<script setup>
import BreezeButton from '@/Components/Button.vue'

import {Head} from "@inertiajs/vue3"
import {useForm} from '@inertiajs/vue3'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'

import { router } from '@inertiajs/vue3';
import Multiselect from 'vue-multiselect'
import "vue-multiselect/dist/vue-multiselect.css"
import Masterpage from "@/Layouts/AdminPanel/Layout/Masterpage.vue";
import {useStore} from "vuex";
const store = useStore();

const lang =  store.state.language;
const langPrefix = lang.langName;
const props = defineProps({
    permission: {},
    roles: []
});
const form = useForm({
    values: null
});

const getIdFromValues = (value, index, array) => {
    return value['id'];
}
const submit = () => {

    let copyOfFormValues = form.values.map(getIdFromValues);
    Inertia.put(route(langPrefix + ".setRoleToPermission", props.permission.id), {
        method: 'put',
        data: copyOfFormValues
    })
}
</script>
