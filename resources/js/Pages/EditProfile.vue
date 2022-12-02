<script>
import BreezeButton from '@/Components/Button.vue'
import BreezeGuestLayout from '@/Layouts/Guest.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import {Head, Link, useForm} from '@inertiajs/inertia-vue3'
import {reactive} from 'vue'
import DatePicker from 'vue3-persian-datetime-picker'
import Masterpage from "@/Layouts/AdminPanel/Layout/Masterpage.vue";

export default {
    components: {
        Masterpage,
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

    props: {
        user: {},
        regions: {},
        cities: {}
    },

    setup(props) {
        //let datepickerValue;
        const needs = reactive({
            ourProvince: {},
            url: ''
        });

        const form = useForm('EditProfile', {
            _method: 'put',
            fname: props.user.fname,
            lname: props.user.lname,
            national_code: props.user.national_code,
            phone: props.user.phone,
            birth: props.user.birth,
            gender: props.user.gender,
            military_status: props.user.military_status,
            avatar: null,
            province_id: props.user.province_id,
            city_id: props.user.city_id,
        });

        const provinceSetter = () => {
            // alert("in ejra shod setprovince");
            let tempProvinces = props.regions.filter(function (province) {
                if (province.id == props.user.province_id)
                    return province;
            });
            needs.ourProvince = tempProvinces[0];
            form.province_id = needs.ourProvince.id;
            let tempCities = needs.ourProvince.cities.filter(function (city) {
                if (city.id == props.user.city_id)
                    return city;
            });
            let ourCity = tempCities[0];

        }
        if (form.province_id != null)
            provinceSetter();
        const provinceChange = (event) => {
            console.log('hi -> province is :');
            let t = props.regions.filter(function (province) {
                console.log(province.cities);

                if (province.id == event.target.value)
                    return province;
            });
            needs.ourProvince = t[0];

        };
        const genderChange = (event) => {
            if (event.target.value != 'male')
                form.military_status = null;
        };
        const previewImage = (e) => {
            const file = e.target.files[0];
            needs.url = URL.createObjectURL(file);
        };
        const submit = () => {

            form.post(route('storeProfile',props.user.id), {
                onSuccess: () => form.reset('password', 'avatar'),
                preserveState: true
            });
        };
        return {form, provinceChange, genderChange, previewImage, submit, needs}
    },
};


</script>


<template>

        <Head title="ویرایش پروفایل"/>
<masterpage class="h-full">
        <BreezeValidationErrors class="mb-4"/>

        <form class="rtl text-right" @submit.prevent="submit">
            <div class="mt-2">
                <BreezeLabel for="fname" value="نام*"/>
                <BreezeInput id="fname" v-model="form.fname" autocomplete="fname" autofocus class="mt-1 block w-full"
                             required
                             type="text"/>
            </div>

            <div class="mt-2">
                <BreezeLabel for="lname" value="نام خانوادگی*"/>
                <BreezeInput id="lname" v-model="form.lname" autocomplete="lname" autofocus class="mt-1 block w-full"
                             required
                             type="text"/>
            </div>
            <div class="mt-2">
                <BreezeLabel for="national_code" value="کدملی*"/>
                <BreezeInput id="national_code" v-model="form.national_code" autocomplete="national_code" autofocus
                             class="mt-1 block w-full" required type="number"/>
            </div>
            <div class="mt-2">
                <BreezeLabel for="phone" value="شماره همراه*"/>
                <BreezeInput id="phone" v-model="form.phone" autocomplete="phone" autofocus class="mt-1 block w-full"
                             required
                             type="tel"/>
            </div>
            <div class="mt-2">
                <BreezeLabel for="birth" value="تاریخ تولد"/>

                <date-picker
                    v-model="form.birth"
                    autofocus
                    class="rounded-none rounded-l-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block min-w-0  text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    display-format="jYYYY/jMM/jDD" editable
                    format="jYYYY/jMM/jDD" placeholder="تاریخ تولد"/>


            </div>
            <div class="mt-2">
                <BreezeLabel for="gender" value="جنسیت*"/>
                <div class="flex flex-row content-around ">
                    <div class="px-3">
                        <BreezeLabel for="genderMale" value="مذکر"/>
                        <BreezeInput id="genderMale" v-model="form.gender" :checked="form.gender == 'male' "
                                     autocomplete="gender" autofocus
                                     class="mt-1 " name="gender" required type="radio"
                                     value="male" @change="genderChange($event)"/>
                    </div>
                    <div class="">
                        <BreezeLabel for="genderFemale" value="مونث"/>
                        <BreezeInput id="genderFemale" v-model="form.gender" :checked="form.gender == 'female' "
                                     autocomplete="gender" autofocus
                                     class="mt-1" name="gender" required type="radio"
                                     value="female" @change="genderChange($event)"/>
                    </div>
                </div>
            </div>
            <div v-show="form.gender == 'male'" class="flex flex-row space-x-2 text-xs mt-2 ">
                <BreezeLabel class=" flex-1" value="وضعیت نظام وظیفه"/>
                <span>معافیت دائم</span>

                <BreezeInput id="military_status" v-model="form.military_status"
                             :checked="form.military_status == 'permanent_exemption' " autocomplete="military_status"
                             autofocus class=""
                             name="military_status" type="radio" value="permanent_exemption"/>
                <span>
                    معاف موقت
                </span>
                <BreezeInput id="military_status2" v-model="form.military_status"
                             :checked="form.military_status == 'temporary_exemption' " autocomplete="military_status"
                             autofocus class=""
                             name="military_status" type="radio" value="temporary_exemption"/>
                <span>
                پایان خدمت
                    </span>
                <BreezeInput id="military_status3" v-model="form.military_status"
                             :checked="form.military_status == 'done' " autocomplete="military_status"
                             autofocus class="" name="military_status"
                             type="radio" value="done"/>

            </div>

            <div class="mt-2">

                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="avatar">آپلود
                    عکس</label>
                <input id="avatar" aria-describedby="avatar_help"
                       class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                       type="file" @change="previewImage" @input="form.avatar = $event.target.files[0]">
                <p id="avatar_help" class="mt-1 text-sm text-gray-500 dark:text-gray-300">PNG, JPG, JPEG or GIF (MAX
                    :200KB).</p>

                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                    {{ form.progress.percentage }}%
                </progress>
            </div>
            <img v-if="needs.url" :src="needs.url" class="max-w-full h-auto rounded-lg">

            <div v-if="form.avatar == null && user.avatar != null" class="flex flex-row mt-2">
                <img :alt="user.username" :src="'storage/'+user.avatar" class="max-w-full h-auto rounded-lg">
            </div>
            <div class="flex flex-col mt-4 justify-center">
                <BreezeLabel for="province" value="استان"/>

                <select
                    v-model="form.province_id"
                    class="block  mb-6 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="province_id" @change="provinceChange($event)">
                    <option v-for="item in regions" :value="item.id">{{ item.title }}</option>
                </select>
                <BreezeLabel for="province" value="شهرستان"/>
                <select
                    v-show="form.province_id!=null"
                    v-model="form.city_id"
                    class=" block mb-6 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="city_id">
                    <option v-for="item in needs.ourProvince.cities" :selected="item.id == form.city_id"
                            :value="item.id">{{ item.title }}
                    </option>
                </select>

            </div>

            <div class="flex items-center justify-end mt-2 gap-x-4">
                <Link :href="route('dashboard')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    بازگشت به داشبورد
                </Link>

                <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="ml-4">
                    ثبت
                </BreezeButton>
            </div>
        </form>

</masterpage>
</template>
