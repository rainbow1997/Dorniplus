<template>
    <BreezeGuestLayout>
        <Head title="ثبت نام"/>

        <BreezeValidationErrors class="mb-4"/>

        <form :class="lang.direction == 'rtl'?'text-right':'text-left'" @submit.prevent="submit">

            <div class="mt-4">
                <BreezeLabel :value="lang.fname +'*'" for="fname"/>
                <BreezeInput id="fname" v-model="form.fname" autocomplete="fname" autofocus class="mt-1 block w-full"
                             required
                             type="text"/>
            </div>

            <div class="mt-4">
                <BreezeLabel :value="lang.lname + '*'" for="lname"/>
                <BreezeInput id="lname" v-model="form.lname" autocomplete="lname" autofocus class="mt-1 block w-full"
                             required
                             type="text"/>
            </div>
            <div class="mt-4">
                <BreezeLabel :value="lang.national_code + '*'" for="national_code"/>
                <BreezeInput id="national_code" v-model="form.national_code" autocomplete="national_code" autofocus
                             class="mt-1 block w-full" required type="number"/>
            </div>
            <div class="mt-4">
                <BreezeLabel :value="lang.phone + '*'" for="phone"/>
                <BreezeInput id="phone" v-model="form.phone" autocomplete="phone" autofocus class="mt-1 block w-full"
                             required
                             type="tel"/>
            </div>
            <div class="mt-4">
                <BreezeLabel :value="lang.birth" for="birth"/>
                <date-picker v-model="form.birth"
                             autofocus
                             class="mt-1 block w-full  bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                             display-format="jYYYY/jMM/jDD" format="YYYY/MM/DD" initial-value="1970/01/01"/>


            </div>
            <div class="mt-4">
                <BreezeLabel :value="lang.gender" for="gender"/>
                <div class="flex flex-row content-around ">
                    <div class="px-3">
                        <BreezeLabel :value="lang.male" for="genderMale"/>
                        <BreezeInput id="genderMale" v-model="form.gender" autocomplete="gender" autofocus class="mt-1 "
                                     name="gender" required type="radio" value="male"
                                     @click="genderChange($event)"/>
                    </div>
                    <div class="">
                        <BreezeLabel :value="lang.female" for="genderFemale"/>
                        <BreezeInput id="genderFemale" v-model="form.gender" autocomplete="gender" autofocus
                                     class="mt-1"
                                     name="gender" required type="radio" value="female"
                                     @click="genderChange($event)"/>
                    </div>
                </div>
            </div>
            <div v-show="form.gender == 'male'" class="my-4 flex flex-row content-around flex-wrap">
                <div class="flex gap-x-2 text-nowrap">
                    <BreezeLabel :value="lang.military_status" class=" flex-1 w-100"/>

                    <BreezeInput id="military_status" v-model="form.military_status" autocomplete="military_status"
                                 autofocus
                                 class="" name="military_status" type="radio"
                                 value="permanent_exemption"/>
                    {{ lang.permanent_exemption }}
                    <BreezeInput id="military_status2" v-model="form.military_status" autocomplete="military_status"
                                 autofocus
                                 class="" name="military_status" type="radio"
                                 value="temporary_exemption"/>
                    {{ lang.temporary_exemption }}
                    <BreezeInput id="military_status3" v-model="form.military_status" autocomplete="military_status"
                                 autofocus
                                 class="" name="military_status" type="radio" value="done"/>
                    {{ lang.done }}
                </div>
            </div>
            <div class="mt-4">
                <BreezeLabel :value="lang.email_address" for="email"/>
                <BreezeInput id="email" v-model="form.email" autocomplete="username" class="mt-1 block w-full" required
                             type="email"/>
            </div>
            <div class="mt-4">

                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                       for="avatar">{{ lang.upload_avatar }}</label>
                <input id="avatar" aria-describedby="avatar_help"
                       class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                       type="file" @input="form.avatar = $event.target.files[0]">
                <p id="avatar_help" class="mt-1 text-sm text-gray-500 dark:text-gray-300">PNG, JPG, JPEG or GIF (MAX
                    :200KB).</p>

                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                    {{ form.progress.percentage }}%
                </progress>
            </div>
            <div class="mt-4">
                <BreezeLabel :value="lang.username + '*'" for="username"/>
                <BreezeInput id="username" v-model="form.username" autocomplete="username" autofocus
                             class="mt-1 block w-full"
                             required type="text"/>
            </div>
            <div class="mt-4">
                <BreezeLabel :value="lang.password + '*'" for="password"/>
                <BreezeInput id="password" v-model="form.password" autocomplete="new-password" class="mt-1 block w-full"
                             required
                             type="password"/>
            </div>
            <div class="mt-4">
                <BreezeLabel :value="lang.password_confirmation" for="password_confirmation"/>
                <BreezeInput id="password_confirmation" v-model="form.password_confirmation" autocomplete="new-password"
                             class="mt-1 block w-full" required type="password"/>
            </div>
            <div class="mt-4">
                <BreezeLabel :value="lang.province" for="province"/>

                <select v-model="form.province_id" name="province_id" @change="provinceChange($event)">
                    <option v-for="item in props.regions" :value="item.id">{{ item.title }}</option>
                </select>
                <select v-if="form.province_id!=null" v-model="form.city_id" name="city_id">
                    <option v-for="item in ourData.cities" :value="item.id">{{ item.title }}</option>
                </select>

            </div>
            <div class="mt-4">
                <BreezeLabel :value="lang.security_code + '*'" for="captcha"/>

                <img id="captcha" class="" :src="route(langPrefix + '.captchaImg')">


            </div>
            <div class="mt-4">
                <BreezeLabel :value="lang.input_correctly"></BreezeLabel>
                <BreezeInput id="captcha_code" v-model="form.captcha_num" autofocus class="block mt-1 w-full"
                             name="captcha_num" required type="number"/>

            </div>
            <div class="flex items-center justify-end mt-4">
                <Link :href="route(langPrefix + '.login')" class="underline text-sm text-gray-600 hover:text-gray-900 mx-4">
                    {{ lang.register_before_click }}
                </Link>

                <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class=" pl-2 mr-4">
                    {{ lang.register }}
                </BreezeButton>
            </div>
        </form>

    </BreezeGuestLayout>
</template>
<script setup>
import BreezeButton from '@/Components/Button.vue'
import BreezeGuestLayout from '@/Layouts/Guest.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import { router } from '@inertiajs/vue3'

import {Head, Link, useForm} from '@inertiajs/vue3'
import DatePicker from 'vue3-persian-datetime-picker'
import {useStore} from 'vuex'

const store = useStore();
const lang = store.state.language.core;
const langPrefix = store.state.language.langName;

lang.direction = store.state.language.langInfo.direction;
const props = defineProps({
    regions: {}
});
const ourData = useForm({
    cities: {}
});
const form = useForm({

    fname: '',
    lname: '',
    national_code: '',
    phone: '',
    birth: '',
    gender: '',
    military_status: '',
    email: '',
    avatar: '',
    username: '',
    password: '',
    password_confirmation: '',
    province_id: null,
    city_id: null,
    terms: false,
    captcha_num: null
});
const provinceChange = (event) => {

    let t = props.regions.filter(function (province) {
        if (province.id == event.target.value)
            return province;
    });
    ourData.cities = {...t[0].cities};

};
const genderChange = (event) => {
    if (event.target.value != 'male')
        form.military_status = null;
}

const submit = () => {
    Inertia.post(route(langPrefix + '.register'), form);
}

</script>

