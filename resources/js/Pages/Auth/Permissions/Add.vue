<template>
    <Head title="ویرایش مجوز"/>

    <masterpage>
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            ویرایش مجوز(Permission)
            {{ form.name }}
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


                            <!-- submit -->
                            <div class="flex items-center mt-4">
                                <button
                                    class="
                                        px-6
                                        py-2
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
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'

import {Head} from "@inertiajs/inertia-vue3"
import {useForm} from '@inertiajs/inertia-vue3'

import {Inertia} from '@inertiajs/inertia'
import Masterpage from "@/Layouts/AdminPanel/Layout/Masterpage.vue";

const form = useForm({
    name: ''
});
const submit = () => {
    Inertia.post(route("permissions.store"), {

        data: form
    })
}
</script>
