<template>
    <Head title="افزودن پست"/>

    <masterpage>
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            افزودن پست
        </h2>


        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <BreezeValidationErrors class="mb-4"/>

                        <form enctype="multipart/form-data" method="post" @submit.prevent="submit">
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
                                    required
                                    type="text"
                                />
                            </div>

                            <div class="mt-2">

                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                       for="avatar">آپلود
                                    عکس</label>
                                <input id="avatar" aria-describedby="avatar_help"
                                       class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                       required type="file" @input="form.post_image = $event.target.files[0]">
                                <p id="avatar_help" class="mt-1 text-sm text-gray-500 dark:text-gray-300">PNG, JPG, JPEG
                                    or GIF (MAX
                                    :200KB).</p>

                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                </progress>
                            </div>
                            <div>
                                خلاصه متن :
                                <editor v-model="form.summary" :init="{language:'fa', plugins: 'wordcount'}"
                                        api-key="API_KEY"/>
                            </div>
                            <div>
                                متن اصلی:
                                <editor v-model="form.text" :init="{language:'fa', plugins: 'wordcount'}"
                                        api-key="API_KEY"/>
                            </div>
                            <div>
                                <select v-model="form.category_id">
                                    <option v-for="category in categories" :value="category.id">{{ category.title }}
                                    </option>
                                </select>
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

import {Head} from "@inertiajs/inertia-vue3"
import {useForm} from "@inertiajs/inertia-vue3"
import Editor from '@tinymce/tinymce-vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import Masterpage from "@/Layouts/AdminPanel/Layout/Masterpage.vue";

export default {
    components: {
        Masterpage,
        BreezeValidationErrors,
        Head,
        editor: Editor
    },
    props: {
        categories: []
    },
    setup(props) {
        const form = useForm({
            title: null,
            post_image: null,
            summary: null,
            text: null,
            category_id: null,
        });

        return {form};
    },
    methods: {
        submit() {
            this.form.post(route("posts.store"), {forceFormData: true});
        },
    },
};
</script>
