<template>
    <Head title="افزودن استان"/>


    <masterpage>
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            افزودن استان
        </h2>


        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <BreezeValidationErrors class="mb-4"/>

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

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue"
import BreezeLabel from "@/Components/Label.vue"
import {Head} from "@inertiajs/vue3"
import {useForm} from "@inertiajs/vue3"
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import Masterpage from "@/Layouts/AdminPanel/Layout/Masterpage.vue";
import {useStore} from "vuex";

export default {
    components: {
        Masterpage,
        BreezeAuthenticatedLayout,
        Head,
        useStore
    },
    setup() {
        const form = useForm({
            title: null,
        });
        const store = useStore();

        const lang =  store.state.language;
        const langPrefix = lang.langName;
        return {form,lang,langPrefix};
    },
    methods: {
        submit() {
            this.form.post(route(this.langPrefix + ".regions.province.store"));
        },
    },
};
</script>
