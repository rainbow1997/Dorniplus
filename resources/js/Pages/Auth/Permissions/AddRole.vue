<template>
    <Head title="انضمام مجوز به نقش کاربری"/>

        <BreezeAuthenticatedLayout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    انضمام مجوز به نقش های کاربری
                </h2>
            </template>

            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 h-screen">
                    <div class=" bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <BreezeValidationErrors class="mb-4"/>
                            <form @submit.prevent="submit">
                            <div class="flex flex-row gap-3 p-6 items-center">
                                <label class="typo__label" id="myLabel" for="mySelect">نقش کاربری هدف</label>
                           <multiselect class="max-w-3xl" id="mySelect" v-model="form.values" :options="roles" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="انتخاب کنید..." label="name" track-by="id" :preselect-first="true">

                               <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span></template>

                           </multiselect>
                                <breeze-button>ثبت </breeze-button>

                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </BreezeAuthenticatedLayout>
</template>

<script setup>
import BreezeButton from '@/Components/Button.vue';

import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeLabel from "@/Components/Label";
import {Head} from "@inertiajs/inertia-vue3";
import { useForm } from '@inertiajs/inertia-vue3'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';

import {ref, reactive, computed} from 'vue'
import {Inertia} from '@inertiajs/inertia'
import Multiselect from 'vue-multiselect'
import "vue-multiselect/dist/vue-multiselect.css"

const props = defineProps({
    permission:{},
    roles:[]
});
const form = useForm({
    values: null
});

const getIdFromValues = (value,index,array) =>
{
    return value['id'];
}
const submit = () =>
{

   let copyOfFormValues = form.values.map(getIdFromValues);
    Inertia.put(route("setRoleToPermission",props.permission.id),{
        method : 'put',
        data:copyOfFormValues
    })
}
</script>
