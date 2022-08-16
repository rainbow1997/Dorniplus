<script>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import './persian-datepicker.js'; // in another time,use modules.env not this statically manner.
import './persian-datepicker.min.css';
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';
import DatePicker from 'vue3-persian-datetime-picker'

export default {
    components: {
        Head,
        Link,
        useForm,
        BreezeButton,
        BreezeGuestLayout,
        BreezeInput,
        BreezeLabel,
        BreezeValidationErrors,
        DatePicker

    },
    data() {
        return {
            cities: {},
            form: this.$inertia.form({
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
                province_id: '',
                city_id: '',
                terms: false,
                captcha_num: null
            })

        }
    },
    props: {
        regions: {}
    },
    methods: {
        provinceChange(event) {

            console.log('hi -> province is :');
            let t = this.regions.filter(function (province) {
                console.log(province.cities);
                if (province.id == event.target.value)
                    return province;
            });
            this.cities = t[0].cities;

        },
        genderChange(event) {
            if (event.target.value != 'male')
                this.form.military_status = null;
        },

        submit() {
            this.$inertia.post('/register', this.form);
        }
    },
    mounted() {


    },
};


</script>


<template>
    <BreezeGuestLayout>
        <Head title="ثبت نام"/>

        <BreezeValidationErrors class="mb-4"/>

        <form class="rtl text-right" @submit.prevent="submit">

            <div class="mt-4">
                <BreezeLabel for="fname" value="نام*"/>
                <BreezeInput id="fname" v-model="form.fname" autocomplete="fname" autofocus class="mt-1 block w-full"
                             required
                             type="text"/>
            </div>

            <div class="mt-4">
                <BreezeLabel for="lname" value="نام خانوادگی*"/>
                <BreezeInput id="lname" v-model="form.lname" autocomplete="lname" autofocus class="mt-1 block w-full"
                             required
                             type="text"/>
            </div>
            <div class="mt-4">
                <BreezeLabel for="national_code" value="کدملی*"/>
                <BreezeInput id="national_code" v-model="form.national_code" autocomplete="national_code" autofocus
                             class="mt-1 block w-full" required type="number"/>
            </div>
            <div class="mt-4">
                <BreezeLabel for="phone" value="شماره همراه*"/>
                <BreezeInput id="phone" v-model="form.phone" autocomplete="phone" autofocus class="mt-1 block w-full"
                             required
                             type="tel"/>
            </div>
            <div class="mt-4">
                <BreezeLabel for="birth" value="تاریخ تولد"/>
                <date-picker initial-value="1970/01/01" class="mt-1 block w-full  bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                             v-model="form.birth" format="YYYY/MM/DD" display-format="jYYYY/jMM/jDD"  autofocus />


            </div>
            <div class="mt-4">
                <BreezeLabel for="gender" value="جنسیت*"/>
                <div class="flex flex-row content-around ">
                    <div class="px-3">
                        <BreezeLabel for="genderMale" value="مذکر"/>
                        <BreezeInput id="genderMale" v-model="form.gender" autocomplete="gender" autofocus class="mt-1 "
                                     name="gender" required type="radio" value="male"
                                     @click="genderChange($event)"/>
                    </div>
                    <div class="">
                        <BreezeLabel for="genderFemale" value="مونث"/>
                        <BreezeInput id="genderFemale" v-model="form.gender" autocomplete="gender" autofocus
                                     class="mt-1"
                                     name="gender" required type="radio" value="female"
                                     @click="genderChange($event)"/>
                    </div>
                </div>
            </div>
            <div v-show="form.gender == 'male'" class="mt-4 flex flex-row content-around flex-wrap">
                <BreezeLabel class=" flex-1 mt-4" value="وضعیت نظام وظیفه*"/>
                <div class="breacontent-around pt-5">
                    <BreezeInput id="military_status" v-model="form.military_status" autocomplete="military_status"
                                 autofocus
                                 class="" name="military_status" type="radio"
                                 value="permanent_exemption"/>
                    معاف دائم
                    <BreezeInput id="military_status2" v-model="form.military_status" autocomplete="military_status"
                                 autofocus
                                 class="" name="military_status" type="radio"
                                 value="temporary_exemption"/>
                    معاف موقت
                    <BreezeInput id="military_status3" v-model="form.military_status" autocomplete="military_status"
                                 autofocus
                                 class="" name="military_status" type="radio" value="done"/>
                    پایان خدمت
                </div>
            </div>
            <div class="mt-4">
                <BreezeLabel for="email" value="ایمیل*"/>
                <BreezeInput id="email" v-model="form.email" autocomplete="username" class="mt-1 block w-full" required
                             type="email"/>
            </div>
            <div class="mt-4">

                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="avatar">آپلود
                    عکس</label>
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
                <BreezeLabel for="username" value="نام کاربری*"/>
                <BreezeInput id="username" v-model="form.username" autocomplete="username" autofocus
                             class="mt-1 block w-full"
                             required type="text"/>
            </div>
            <div class="mt-4">
                <BreezeLabel for="password" value="رمز عبور*"/>
                <BreezeInput id="password" v-model="form.password" autocomplete="new-password" class="mt-1 block w-full"
                             required
                             type="password"/>
            </div>
            <div class="mt-4">
                <BreezeLabel for="password_confirmation" value="تکرار رمز عبور*"/>
                <BreezeInput id="password_confirmation" v-model="form.password_confirmation" autocomplete="new-password"
                             class="mt-1 block w-full" required type="password"/>
            </div>
            <div class="mt-4">
                <BreezeLabel for="province" value="استان "/>

                <select v-model="form.province_id" name="province_id" @change="provinceChange($event)">
                    <option v-for="item in regions" :value="item.id">{{ item.title }}</option>
                </select>
                <select v-show="form.province_id!=null" v-model="form.city_id" name="city_id">
                    <option v-for="item in cities" :value="item.id">{{ item.title }}</option>
                </select>

            </div>
            <div class="mt-4">
                <BreezeLabel for="captcha" value="کد امنیتی*"/>

                <img id="captcha" class="" src="/captcha2">


            </div>
            <div class="mt-4">
                <BreezeLabel value="کد بالا را با دقت وارد کنید"></BreezeLabel>
                <BreezeInput id="captcha_code" v-model="form.captcha_num" autofocus class="block mt-1 w-full"
                             name="captcha_num" required type="number"/>

            </div>
            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    پیش از این ثبت نام کرده اید؟ برای ورود کلیک کنید.
                </Link>

                <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class=" pl-2 mr-4">
                    ثبت نام
                </BreezeButton>
            </div>
        </form>

    </BreezeGuestLayout>
</template>
