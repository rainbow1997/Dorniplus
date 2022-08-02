<script>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import './persian-datepicker.js';// in another time,use modules.env not this statically manner.
import './persian-datepicker.min.css';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

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
            fname: '',
            lname: '',
            national_code: '',
            phone:'',
            birth:'',
            gender:'',
            military_status:'',
            email: '',
            avatar:'',
            username:'',
            password: '',
            password_confirmation: '',
            province_id:'',
            city_id:'',
            terms: false,
            captcha_num:null
})

}},
props: {
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
      this.$inertia.post('/register', this.form)
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
        <Head title="ثبت نام" />

        <BreezeValidationErrors class="mb-4" />

        <form @submit.prevent="submit" class="rtl text-right">

            <div class="mt-4">
                <BreezeLabel for="fname" value="نام*" />
                <BreezeInput id="fname" type="text" class="mt-1 block w-full" v-model="form.fname" required autofocus autocomplete="fname" />
            </div>

             <div class="mt-4">
                <BreezeLabel for="lname" value="نام خانوادگی*" />
                <BreezeInput id="lname" type="text" class="mt-1 block w-full" v-model="form.lname" required autofocus autocomplete="lname" />
            </div>
            <div class="mt-4">
                <BreezeLabel for="national_code" value="کدملی*" />
                <BreezeInput id="national_code" type="number" class="mt-1 block w-full" v-model="form.national_code" required autofocus autocomplete="national_code" />
            </div>
            <div class="mt-4">
                <BreezeLabel for="phone" value="شماره همراه*" />
                <BreezeInput id="phone" type="tel" class="mt-1 block w-full" v-model="form.phone" required autofocus autocomplete="phone" />
            </div>
            <div class="mt-4">
                <BreezeLabel for="birth" value="تاریخ تولد" />
                <input type="text" id="birth" class="mt-1 block w-full datepicker" ref="settingBirth"  v-model="form.birth" required autofocus autocomplete="birth">
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
            <div v-show="form.gender == 'male'" class="mt-4 flex flex-row content-around flex-wrap">
                <BreezeLabel  value="وضعیت نظام وظیفه*" class=" flex-1 mt-4" />
                <div class="breacontent-around pt-5">
                    <BreezeInput id="military_status" name="military_status" type="radio" class="" v-model="form.military_status"  autofocus autocomplete="military_status" value="permanent_exemption" />معاف دائم
                    <BreezeInput id="military_status2" name="military_status" type="radio" class="" v-model="form.military_status"  autofocus autocomplete="military_status" value="temporary_exemption" />معاف موقت
                    <BreezeInput id="military_status3" name="military_status" type="radio" class="" v-model="form.military_status"  autofocus autocomplete="military_status" value="done" />پایان خدمت
                </div>
            </div>
             <div class="mt-4">
                <BreezeLabel for="email" value="ایمیل*" />
                <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="username" />
            </div>
            <div class="mt-4">
                <BreezeLabel for="avatar" value="عکس" />
                <input type="file" @input="form.avatar = $event.target.files[0]" />
                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                   {{ form.progress.percentage }}%
                </progress>
            </div>
             <div class="mt-4">
                <BreezeLabel for="username" value="نام کاربری*" />
                <BreezeInput id="username" type="text" class="mt-1 block w-full" v-model="form.username" required autofocus autocomplete="username" />
            </div>
            <div class="mt-4">
                <BreezeLabel for="password" value="رمز عبور*" />
                <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
            </div>
             <div class="mt-4">
                <BreezeLabel for="password_confirmation" value="تکرار رمز عبور*" />
                <BreezeInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
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
            <div class="mt-4">
                <BreezeLabel for="captcha" value="کد امنیتی*" />

                <img id="captcha" class="" src="/captcha2">


             </div>
            <div  class="mt-4">
                 <BreezeLabel value="کد بالا را با دقت وارد کنید"></BreezeLabel>
                 <BreezeInput id="captcha_code" v-model="form.captcha_num" class="block mt-1 w-full" type="number" name="captcha_num" required autofocus />

             </div>
            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    پیش از این ثبت نام کرده اید؟ برای ورود کلیک کنید.
                </Link>

                <BreezeButton class=" pl-2 mr-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    ثبت نام
                </BreezeButton>
            </div>
        </form>

    </BreezeGuestLayout>
</template>
