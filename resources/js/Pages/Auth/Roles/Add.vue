<template>
    <Head title="ویرایش مجوز"/>

    <masterpage>
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            افزودن نقش(Role)
        </h2>


        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <BreezeValidationErrors class="mb-4"/>

                        <form @submit.prevent="submit">
                            <div>
                                <label for="name">عنوان</label>
                                <input
                                    v-model="form.name"
                                    class="
                                        w-full
                                        px-4
                                        py-2
                                        mt-2
                                        border
                                        rounded-md
                                        focus:outline-none
                                        focus:ring-1
                                        focus:ring-blue-600
                                    "
                                    name="name"
                                    type="text"
                                />
                            </div>

                            <div>
                                <div class="my-4 wrapper"></div>
                                <h3 class="mb-3 font-bold">مجوز های کاربری</h3>


                            <div class="flex flex-row flex-wrap p-2 gap-3">
                                    <div v-for="permission in permissions" :key="permission.id">


                                            <div class="flex mr-4 items-center gap-2 border border-gray-200 rounded dark:border-gray-700">
                                                <input :id="'bordered-checkbox-' + permission.id" type="checkbox" v-model="form.permissions" :value="permission.id"
                                                       name="permissions[]" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300
                                                       rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800
                                                       focus:ring-2 dark:bg-gray-700 dark:border-gray-600">

                                                <label :for="'bordered-checkbox-' + permission.id" class=" w-full h-full py-4 ml-2 mr-2 pl-3 text-sm font-medium
                                                 text-gray-900 dark:text-gray-300 mr-">{{permission.name}}</label>
                                            </div>

                                    </div>
                            </div>
                            </div>
                            <!-- submit -->
                            <div class="flex items-center mt-4">
                                <button
                                    class="
                                        px-6
                                        py-2
                                        mx-5
                                        text-white
                                        bg-gray-900
                                        rounded
                                    "
                                >
                                    ثبت
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </masterpage>
</template>

<script setup>
import {Head, useForm} from "@inertiajs/vue3"
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'

import {ref, reactive, computed} from 'vue'
import { router } from '@inertiajs/vue3'
import Masterpage from "@/Layouts/AdminPanel/Layout/Masterpage.vue";
import {useStore} from "vuex";
const store = useStore();

const lang =  store.state.language;
const langPrefix = lang.langName;
const props = defineProps({
    permissions:{}
});
console.log(props.permissions);
const form = useForm({
    name: '',
    permissions:[]
});
const submit = () => {
    form.post(route(langPrefix + ".roles.store"), {
        data: form
    })
}
</script>
