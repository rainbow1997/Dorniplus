<template>
    <masterpage>
    <Head title="ویرایش موضوع"/>

            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                ویرایش موضوع {{ form.title }}
            </h2>


        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form method="post" @submit.prevent="submit">
                            <div>
                                <label for="title">عنوان</label>
                                <input
                                    v-model="form.title"
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
                                    required type="text"
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
import {Inertia} from '@inertiajs/inertia'
import {Head} from "@inertiajs/inertia-vue3"
import {useForm} from "@inertiajs/inertia-vue3"
import Masterpage from "@/Layouts/AdminPanel/Layout/Masterpage";

const props = defineProps({
    category: {}

});
const form = useForm({
    method: 'put',
    title: props.category.title,
});
const submit = () => {
    Inertia.put(route("categories.update", props.category.id), form);
};
</script>
