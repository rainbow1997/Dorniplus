<template>
    <Head title="مدیریت نقش ها"/>

    <masterpage>

        <div class="">
            <div class=" w-full  mx-auto mt-5 sm:px-6 lg:px-8 h-full py-6">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <h2 class="p-3 text-xl font-semibold leading-tight text-gray-800">
                        نقش های کاربری - Permissions
                    </h2>


                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="mb-4">
                            <Link
                                :href="route(langPrefix + '.roles.create')"
                                class="
                                    px-6
                                    py-2
                                    mb-2
                                   text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700
                                "
                            >
                                افزودن نقش
                            </Link>
                            <p class="mt-5">
                                جهت مشاهده مجوز های منتسب به هر نقش بر روی نام آن نقش کلیک کنید.
                            </p>
                        </div>
                        <table>
                            <thead class="font-bold bg-gray-300 border-b-2">
                            <td class="px-4 py-2">شناسه</td>
                            <td class="px-4 py-2">عنوان</td>

                            <td class="px-4 py-2">عملیات</td>
                            </thead>
                            <tbody>
                            <tr v-for="role in roles.data" :key="role.id">
                                <td class="px-4 py-2">{{ role.id }}</td>
                                <td class="px-4 py-2">{{ role.name }}</td>
                                <td class="px-4 py-2 font-extrabold flex flex-row space-around">
                                    <BreezeButton
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                        @click="chooseRole(role)">
                                        انتخاب
                                    </BreezeButton> <!-- remember that , link try to remount and it makes conflicts-->

                                    <Link
                                        :href="route(langPrefix + '.roles.edit', role.id)"
                                        class="text-white bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:focus:ring-yellow-900"
                                    >
                                        ویرایش
                                    </Link>
                                    <Link
                                        class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                                        @click="destroy(role.id)"
                                    >حذف
                                    </Link
                                    >


                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <pagination :links="roles.links"/>
                        <div v-if="needs.canShow">
                            <h3 class="mb-3">مجوز های کاربری</h3>

                            <Link
                                :href="route(langPrefix + '.addPermissionToRole',needs.selectedRole.id)"
                                class="
                                    px-6
                                    py-2
                                    text-white bg-gray-800 hover:bg-gray-900 focus:outline-none
                                    focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 mr-2 mb-2
                                    dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700
                                "
                            >
                                افزودن مجوز به این نقش
                            </Link>
                            <table class="table-fixed mt-5">
                                <thead class="font-bold bg-gray-300 border-b-2">
                                <td class="px-4 py-2">شناسه</td>
                                <td class="px-4 py-2">عنوان</td>

                                <td class="px-4 py-2">عملیات</td>
                                </thead>
                                <tbody>
                                <tr v-for="permission in needs.selectedRole.permissions" :key="permission.id">
                                    <td class="px-4 py-2">{{ permission.id }}</td>
                                    <td class="px-4 py-2">{{ permission.name }}</td>
                                    <td class="px-4 py-2 font-extrabold">

                                        <Link
                                            class="text-red-700"
                                            @click="destroyRoleFromPermission(role.id)"
                                        >حذف
                                        </Link
                                        >

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </masterpage>
</template>

<script setup>
import BreezeButton from '@/Components/Button.vue'
import {Head} from "@inertiajs/vue3"
import {Link} from "@inertiajs/vue3"
import {useForm} from '@inertiajs/vue3'
const store = useStore();

const lang =  store.state.language;
const langPrefix = lang.langName;
import { router } from '@inertiajs/vue3'
import Masterpage from "@/Layouts/AdminPanel/Layout/Masterpage.vue";
import {useStore} from "vuex";

defineProps({
    roles: {}
});
let needs = useForm({
    selectedPermission: {
        type: Object,
        default: null
    },
    canShow: false
});

const destroy = (id) => {
    Inertia.delete(route(langPrefix + ".roles.destroy", id));
};

const destroyRoleFromPermission = (id) => {

    Inertia.delete(route(langPrefix + ".destroyRoleFromPermission", {
        role: needs.selectedRole.id,
        permission: id
    }), {
        replace: true,

    });
    needs.selectedRole = null;

};
const chooseRole = (role) => {
    needs.selectedRole = role;
    needs.canShow = true;
}
// const chooseRole = (id) => {
//     //alert(id);
//
//     needs.canShow = true;
//     let t = this.roles.data.filter(function (role) {
//         if (role.id == id) {
//
//             return role;
//         }
//
//     });
//     needs.selectedRole = Object.assign({}, t[0]);
//     needs.canShow = true;
//     //alert(this.canShow);
// };

</script>
