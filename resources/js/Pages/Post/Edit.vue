<template>
    <Head title="ویرایش پست"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
               ویرایش پست -
                {{form.title}}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <BreezeValidationErrors class="mb-4"/>

                        <form method="post" @submit.prevent="submit(post)" enctype="multipart/form-data">
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
                                    type="text"
                                    required
                                />
                            </div>

                            <div class="mt-2">

                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="post_image">آپلود
                                    عکس</label>
                                <input id="post_image" aria-describedby="post_image_help"
                                       class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                       type="file" @input="form.post_image = $event.target.files[0]" @change="previewImage" >
                                <p id="post_image_help" class="mt-1 text-sm text-gray-500 dark:text-gray-300">PNG, JPG, JPEG or GIF (MAX
                                    :200KB).</p>
                                <img v-if="url" :src="url" class="max-w-full h-auto rounded-lg">
                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                </progress>
                            </div>
                            <div v-if="form.post_image === null" class="flex flex-row mt-2">
                                <img :alt="post.title" :src="'/storage/'+post.post_image" class="max-w-full h-auto rounded-lg">
                            </div>
                            <div>
                                خلاصه متن : <editor v-model="form.summary" api-key="API_KEY" :init="{language:'fa', plugins: 'wordcount'}" />
                            </div>
                            <div>
                                متن اصلی:    <editor v-model="form.text" api-key="API_KEY"  :init="{language:'fa', plugins: 'wordcount'}" />
                            </div>
                            <div>
                                <select v-model="form.category_id">
                                    <option v-for="category in categories" :value="category.id">{{category.title}}</option>
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
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeLabel from "@/Components/Label";
import {Head} from "@inertiajs/inertia-vue3";
import {useForm} from "@inertiajs/inertia-vue3";
import Editor from '@tinymce/tinymce-vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
export default {
    components: {
        BreezeAuthenticatedLayout,
        BreezeValidationErrors,
        Head,
        editor:Editor
    },
    props: {
        categories:[],
        post:{}
    },
    setup(props) {
        let url;
        const form = useForm({
            _method:'put',
            title: props.post.title,
            post_image:null,
            summary:props.post.summary,
            text:props.post.text,
            category_id:props.post.category_id,

        });

        return {form,ourPost:props.post,url};
    },
    methods: {
        previewImage(e){
            const file = e.target.files[0];
            this.url = URL.createObjectURL(file);
        },
        submit() {
            this.form.post(route("posts.update",{
                id:this.ourPost.id
                //_method:'put' this is wrong,we should use it when creating with useForm
            },{
                forceFormData:true
            }));
        },
    },
};
</script>
