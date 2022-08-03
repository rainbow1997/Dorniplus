<script>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeCheckbox from '@/Components/Checkbox.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import './Auth/persian-datepicker.js';// in another time,use modules.env not this statically manner.
import './Auth/persian-datepicker.min.css';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import * as moment from 'jalali-moment';


export default {
    components:{
    Head,
    Link,
    useForm,
    BreezeButton,
    BreezeGuestLayout,
    BreezeInput,
    BreezeLabel,
    BreezeValidationErrors,

},
data(){
    return{
        cities:{},
        form : this.$inertia.form({
            method:'put',
            fname: this.user.fname,
            lname: this.user.lname,
            national_code: this.user.national_code,
            phone: this.user.phone,
            birth: moment(this.user.birth, 'YYYY/MM/DD').locale('fa').format('YYYY/MM/DD'),
            gender:this.user.gender,
            military_status:this.user.military_status,
            avatar: this.user.avatar,
            province_id:this.user.province_id,
            city_id:this.user.city_id,
            terms: false,
})

}},
props: {
    user :{},//afterwards, delete it and use Inertia attr
    regions:{}
},
watch:{
    form:{
        gender(newGen,oldGen)
        {
            console.log('ali ali');
            alert('hi');
              if(newGender != 'male')
                this.military_status = null;
        }
    }
},
methods: {
     provinceChange(event){
                console.log('hi -> province is :');
                let t = this.regions.filter(function(province){
                    console.log(province.cities);
                    if(province.id == event.target.value)
                        return province;
                });
                this.cities = t[0].cities;

            },
    genderChange(event){
        if(event.target.value != 'male')
            this.form.military_status = null;
    },
    setBirth(){
        this.form.birth = this.$refs.settingBirth.value;//direct connection to DOM elements in Vuejs

    },
     submit() {
         this.setBirth();

         this.$inertia.put('/storeProfile/'+this.user.id, this.form)
    }
},
mounted() {
    $(document).ready(function() {
        $(".datepicker").pDatepicker({
            initialValue: false,
            format: 'YYYY/MM/DD'
        });
  });

},
};





</script>


<template>
    <BreezeGuestLayout>
        <Head title="ویرایش پروفایل" />

        <BreezeValidationErrors class="mb-4" />

        <form @submit.prevent="submit" class="rtl text-right">
            <div>
                <BreezeLabel for="fname" value="*نام" />
                <BreezeInput id="fname" type="text" class="mt-1 block w-full" v-model="form.fname" required autofocus autocomplete="fname" />
            </div>

             <div>
                <BreezeLabel for="lname" value="*نام خانوادگی" />
                <BreezeInput id="lname" type="text" class="mt-1 block w-full" v-model="form.lname" required autofocus autocomplete="lname" />
            </div>
            <div>
                <BreezeLabel for="national_code" value="*کدملی" />
                <BreezeInput id="national_code" type="number" class="mt-1 block w-full" v-model="form.national_code" required autofocus autocomplete="national_code" />
            </div>
            <div>
                <BreezeLabel for="phone" value="*شماره همراه" />
                <BreezeInput id="phone" type="tel" class="mt-1 block w-full" v-model="form.phone" required autofocus autocomplete="phone" />
            </div>
            <div class="mt-4">
                <BreezeLabel for="birth" value="تاریخ تولد" />
                <input type="text" id="birth" class="mt-1 block w-full datepicker bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" ref="settingBirth"  v-model="form.birth" required autofocus autocomplete="birth">
            </div>
            <div class="mt-4">
                <BreezeLabel for="gender" value="جنسیت*" />
                <div class="flex flex-row content-around ">
                    <div class="px-3">
                        <BreezeLabel for ="genderMale" value="مذکر" />
                        <BreezeInput id="genderMale" name="gender" type="radio" class="mt-1 " v-model="form.gender" required autofocus autocomplete="gender" value="male" @change="genderChange($event)"/>
                    </div>
                    <div class="">
                        <BreezeLabel for ="genderFemale" value="مونث" />
                        <BreezeInput id="genderFemale" name="gender" type="radio" class="mt-1" v-model="form.gender" required autofocus autocomplete="gender" value="female" @change="genderChange($event)"/>
                    </div>
                </div>
            </div>
            <div v-show="form.gender == 'male'" class="flex flex-row-reverse content-around flex-wrap">
                <BreezeLabel  value="وضعیت نظام وظیفه" class=" flex-1" />
                <BreezeInput id="military_status" name="military_status" type="checkbox" class="" v-model="form.military_status"  autofocus autocomplete="military_status" value="permanent_exemption" />معاف دائم
                <BreezeInput id="military_status2" name="military_status" type="radio" class="" v-model="form.military_status"  autofocus autocomplete="military_status" value="temporary_exemption" />معاف موقت
                <BreezeInput id="military_status3" name="military_status" type="radio" class="" v-model="form.military_status"  autofocus autocomplete="military_status" value="done" />پایان خدمت
            </div>

            <div class="mt-4">

                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="avatar">آپلود عکس</label>
                <input type="file" @input="form.avatar = $event.target.files[0]" class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="avatar_help" id="avatar">
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="avatar_help">PNG, JPG, JPEG or GIF (MAX :200KB).</p>

                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                    {{ form.progress.percentage }}%
                </progress>
            </div>
           <div class="mt-4">
                <BreezeLabel for="province" value="استان " />

                <select v-model="form.province_id" name="province_id" @change="provinceChange($event)">
                    <option v-for="item in regions" :value="item.id">{{item.title}}</option>
                </select>
               <select v-show="form.province_id!=null" v-model="form.city_id" name="city_id">
                   <option v-for="item in cities" :value="item.id">{{item.title}}</option>
               </select>

            </div>

            <div class="flex items-center justify-end mt-4">
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
