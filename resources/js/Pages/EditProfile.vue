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
            birth: this.user.birth,
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
     submit() {
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
            <div>
                <BreezeLabel for="birth" value="تاریخ تولد" />
                <BreezeInput id="birth" type="tel" class="mt-1 block w-full datepicker" v-model="form.birth" required autofocus autocomplete="birth" />
            </div>
            <div class="mt-1">
                <BreezeLabel for="gender" value="*جنسیت" />
                <div class="flex flex-row-reverse content-around ">
                <div class="px-3">
                <BreezeLabel for ="genderMale" value="مذکر" />
                <BreezeInput id="genderMale" name="gender" type="radio" class="mt-1 " v-model="form.gender" required autofocus autocomplete="gender" value="male" @change="genderChange($event)" v-on:checked="gender == 'male'"/>
                </div>
                <div>
                <BreezeLabel for ="genderFemale" value="مونث" />
                <BreezeInput id="genderFemale" name="gender" type="radio" class="mt-1" v-model="form.gender" required autofocus autocomplete="gender" value="female" @change="genderChange($event)" v-on:checked="gender == 'female' "/>
                </div>
                </div>
            </div>
            <div v-show="form.gender == 'male'" class="flex flex-row-reverse content-around flex-wrap">
                <BreezeLabel  value="وضعیت نظام وظیفه" class=" flex-1" />
                <BreezeInput id="military_status" name="military_status" type="checkbox" class="" v-model="form.military_status"  autofocus autocomplete="military_status" value="permanent_exemption" />معاف دائم
                <BreezeInput id="military_status2" name="military_status" type="radio" class="" v-model="form.military_status"  autofocus autocomplete="military_status" value="temporary_exemption" />معاف موقت
                <BreezeInput id="military_status3" name="military_status" type="radio" class="" v-model="form.military_status"  autofocus autocomplete="military_status" value="done" />پایان خدمت
            </div>
            
            <div>
                <BreezeLabel for="avatar" value="عکس" />
                <input type="file" @input="form.avatar = $event.target.files[0]" />
                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                   {{ form.progress.percentage }}%
                </progress>
            </div>
            
           <div class="mt-4">
                <BreezeLabel for="province" value="استان " />
                <select v-show="form.province_id!=null" v-model="form.city_id" name="city_id">
                    <option v-for="item in cities" :value="item.id">{{item.title}}</option>
                </select>
                <select v-model="form.province_id" name="province_id" @change="provinceChange($event)">
                    <option v-for="item in regions" :value="item.id">{{item.title}}</option>
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
