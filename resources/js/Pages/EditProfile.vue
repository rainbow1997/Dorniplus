<script>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeCheckbox from '@/Components/Checkbox.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import './Auth/persian-datepicker.js';// in another time,use modules.env not this statically manner.
import './Auth/persian-datepicker.min.css';
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';
import {Inertia} from '@inertiajs/inertia'
import { reactive} from 'vue'

import * as moment from 'jalali-moment';
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


    },

    props: {
        user: {},
        regions: {},
        cities: {}
    },

    setup(props) {
        //let datepickerValue;
        const needs = reactive({
            ourProvince:{},
            datepickerValue: {}
        });

        const form = useForm('EditProfile',{
            _method: 'put',
            fname: props.user.fname,
            lname: props.user.lname,
            national_code: props.user.national_code,
            phone: props.user.phone,
            birth: props.user.birth,
            gender: props.user.gender,
            military_status: props.user.military_status,
            avatar: props.user.avatar,
            province_id: props.user.province_id,
            city_id: props.user.city_id,
        });
        const datepicker = () => {
            $(document).ready(function () {

                const pd = $("#birth").pDatepicker({
                    "inline": false,
                    "format": "L",
                    "viewMode": "year",
                    "initialValue": false,
                    "minDate": null,
                    "maxDate": 1660459870590,
                    "autoClose": true,
                    "position": "auto",
                    "altFormat": "l",
                    "altField": "#altfieldExample",
                    "onlyTimePicker": false,
                    "onlySelectOnDate": true,
                    "calendarType": "persian",
                    "inputDelay": 800,
                    "observer": true,
                    "calendar": {
                        "persian": {
                            "locale": "fa",
                            "showHint": true,
                            "leapYearMode": "algorithmic"
                        },
                        "gregorian": {
                            "locale": "en",
                            "showHint": false
                        }
                    },
                    "navigator": {
                        "enabled": true,
                        "scroll": {
                            "enabled": true
                        },
                        "text": {
                            "btnNextText": "<",
                            "btnPrevText": ">"
                        }
                    },
                    "toolbox": {
                        "enabled": true,
                        "calendarSwitch": {
                            "enabled": false,
                            "format": "MMMM"
                        },
                        "todayButton": {
                            "enabled": false,
                            "text": {
                                "fa": "امروز",
                                "en": "Today"
                            }
                        },
                        "submitButton": {
                            "enabled": true,
                            "text": {
                                "fa": "تایید",
                                "en": "Submit"
                            }
                        },
                        "text": {
                            "btnToday": "امروز"
                        }
                    },
                    "timePicker": {
                        "enabled": false,
                        "step": 1,
                        "hour": {
                            "enabled": false,
                            "step": null
                        },
                        "minute": {
                            "enabled": false,
                            "step": null
                        },
                        "second": {
                            "enabled": false,
                            "step": null
                        },
                        "meridian": {
                            "enabled": false
                        }
                    },
                    "dayPicker": {
                        "enabled": true,
                        "titleFormat": "YYYY MMMM"
                    },
                    "monthPicker": {
                        "enabled": true,
                        "titleFormat": "YYYY"
                    },
                    "yearPicker": {
                        "enabled": true,
                        "titleFormat": "YYYY"
                    },
                    "responsive": true
                });
                console.log(pd);
                needs.datepickerValue = pd;


            });
        };

        datepicker();



        const provinceSetter = () => {
            // alert("in ejra shod setprovince");
            let tempProvinces = props.regions.filter(function (province) {
                if (province.id == props.user.province_id)
                    return province;
            });
            needs.ourProvince = tempProvinces[0];
            form.province_id = needs.ourProvince.id;
            let tempCities = needs.ourProvince.cities.filter(function(city){
               if(city.id == props.user.city_id)
                   return city;
            });
           let ourCity =  tempCities[0];

        }

        provinceSetter();
        const provinceChange = (event) => {
            console.log('hi -> province is :');
            let t = props.regions.filter(function (province) {
                console.log(province.cities);

                if (province.id == event.target.value)
                    return province;
            });
            needs.ourProvince = t[0];

            // alert('taghirkard');

        };
        let genderChange = (event) => {
            if (event.target.value != 'male')
                form.military_status = null;
        };
        const setBirth = () => {

            console.log(needs.datepickerValue.model.api.model.input.elem.value);
            form.birth = needs.datepickerValue.model.api.model.input.elem.value;

            // form.birth = $refs.settingBirth.value;//direct connection to DOM elements in Vuejs

        };
        let submit = () => {

            setBirth();

            form.post(`/storeProfile/${props.user.id}`, {
                onSuccess: () => form.reset('password', 'avatar'),
                preserveState: true
            });
        };
        return {form, provinceChange, genderChange, submit,needs}
    },
};


</script>


<template>
    <BreezeGuestLayout>
        <Head title="ویرایش پروفایل"/>

        <BreezeValidationErrors class="mb-4"/>

        <form @submit.prevent="submit" class="rtl text-right">
            <div class="mt-2">
                <BreezeLabel for="fname" value="نام*"/>
                <BreezeInput id="fname" type="text" class="mt-1 block w-full" v-model="form.fname" required autofocus
                             autocomplete="fname"/>
            </div>

            <div class="mt-2">
                <BreezeLabel for="lname" value="نام خانوادگی*"/>
                <BreezeInput id="lname" type="text" class="mt-1 block w-full" v-model="form.lname" required autofocus
                             autocomplete="lname"/>
            </div>
            <div class="mt-2">
                <BreezeLabel for="national_code" value="کدملی*"/>
                <BreezeInput id="national_code" type="number" class="mt-1 block w-full" v-model="form.national_code"
                             required autofocus autocomplete="national_code"/>
            </div>
            <div class="mt-2">
                <BreezeLabel for="phone" value="شماره همراه*"/>
                <BreezeInput id="phone" type="tel" class="mt-1 block w-full" v-model="form.phone" required autofocus
                             autocomplete="phone"/>
            </div>
            <div class="mt-2">
                <BreezeLabel for="birth" value="تاریخ تولد"/>
                <input type="text" id="birth"
                       class="mt-1 block w-full datepicker bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       v-model="form.birth" required autofocus autocomplete="birth">
            </div>
            <div class="mt-2">
                <BreezeLabel for="gender" value="جنسیت*"/>
                <div class="flex flex-row content-around ">
                    <div class="px-3">
                        <BreezeLabel for="genderMale" value="مذکر"/>
                        <BreezeInput id="genderMale" name="gender" type="radio" class="mt-1 " v-model="form.gender"
                                     :checked="form.gender == 'male' " required autofocus autocomplete="gender"
                                     value="male" @change="genderChange($event)"/>
                    </div>
                    <div class="">
                        <BreezeLabel for="genderFemale" value="مونث"/>
                        <BreezeInput id="genderFemale" name="gender" type="radio" class="mt-1" v-model="form.gender"
                                     :checked="form.gender == 'female' " required autofocus autocomplete="gender"
                                     value="female" @change="genderChange($event)"/>
                    </div>
                </div>
            </div>
            <div v-show="form.gender == 'male'" class="flex flex-row space-x-2 text-xs mt-2 ">
                <BreezeLabel value="وضعیت نظام وظیفه" class=" flex-1"/>
                <span>معافیت دائم</span>

                <BreezeInput id="military_status" name="military_status" type="radio" class=""
                             v-model="form.military_status" :checked="form.military_status == 'permanent_exemption' "
                             autofocus autocomplete="military_status" value="permanent_exemption"/>
                <span>
                    معاف موقت
                </span>
                <BreezeInput id="military_status2" name="military_status" type="radio" class=""
                             v-model="form.military_status" :checked="form.military_status == 'temporary_exemption' "
                             autofocus autocomplete="military_status" value="temporary_exemption"/>
                <span>
                پایان خدمت
                    </span>
                <BreezeInput id="military_status3" name="military_status" type="radio" class=""
                             v-model="form.military_status" :checked="form.military_status == 'done' " autofocus
                             autocomplete="military_status" value="done"/>

            </div>

            <div class="mt-2">

                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="avatar">آپلود
                    عکس</label>
                <input type="file" @input="form.avatar = $event.target.files[0]"
                       class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                       aria-describedby="avatar_help" id="avatar">
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="avatar_help">PNG, JPG, JPEG or GIF (MAX
                    :200KB).</p>

                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                    {{ form.progress.percentage }}%
                </progress>
            </div>
            <div v-if="form.avatar == user.avatar" class="flex flex-row mt-2">
                <img :src="'storage/'+form.avatar" :alt="user.username" class="max-w-full h-auto rounded-lg">
            </div>
            <div class="flex flex-col mt-4 justify-center">
                <BreezeLabel for="province" value="استان"/>

                <select class="block  mb-6 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" v-model="form.province_id" name="province_id" @change="provinceChange($event)">
                    <option  v-for="item in regions" :value="item.id">{{ item.title }}</option>
                </select>
                <BreezeLabel for="province" value="شهرستان"/>
                <select class=" block mb-6 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" v-show="form.province_id!=null" v-model="form.city_id" name="city_id">
                    <option v-for="item in needs.ourProvince.cities" :value="item.id" :selected="item.id == form.city_id">{{ item.title }} </option>
                </select>

            </div>

            <div class="flex items-center justify-end mt-2">
                <Link :href="route('dashboard')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    بازگشت به داشبورد
                </Link>

                <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    ثبت
                </BreezeButton>
            </div>
        </form>

    </BreezeGuestLayout>
</template>
