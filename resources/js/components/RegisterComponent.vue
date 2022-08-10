<template>

    <div>
        <div class="row d-flex mt-4 justify-content-center">
            <label for="gender" value="*جنسیت"/>
            <input id="gender_male" v-model="gender" name="gender" type="radio" value="male">مذکر
            <input id="gender_female" v-model="gender" name="gender" type="radio" value="female">مونث
        </div>
        <div v-show="gender == 'male'" class="mt-4">
            <label for="military_status" value="وضعیت نظام وظیفه"/>
            <input id="military_status_1" v-model="military_status" name="military_status" type="radio"
                   value="permanent_exemption">معاف دائم
            <input id="military_status_2" v-model="military_status" name="military_status" type="radio"
                   value="temporary_exemption">معاف موقت
            <input id="military_status_3" v-model="military_status" name="military_status" type="radio" value="done">انجام
            شده
        </div>
        <div class="mt-4">
            <label> استان محل سکونت </label>
            <select v-model="selectedProvince" name="province_id" @change="provinceChange($event)">
                <option v-for="item in provinces" :value="item.id">{{ item.title }}</option>
            </select>
            <select v-show="selectedProvince" v-model="selectedCity" name="city_id">
                <option v-for="item in cities" :value="item.id">{{ item.title }}</option>
            </select>
        </div>

    </div>
</template>

<script>
export default {
    props: ['login_route', 'register_route', 'regions'],
    data() {
        return {
            errors: null,
            gender: null,
            military_status: null,
            ourRegions: {},
            provinces: {},
            cities: {},
            selectedProvince: {
                "title": "انتخاب کنید"
            },
            nProvince: {},
            selectedCity: {},


        }
    },
    methods: {
        provinceChange(event) {
            console.log('hi -> province is :');
            let t = this.provinces.filter(function (province) {
                console.log(province.cities);
                if (province.id == event.target.value)
                    return province;
            });
            this.cities = t[0].cities;

        }
    },
    watch: {
        gender(newGender, oldGender) {
            if (newGender != 'male')
                this.military_status = null;
        },

    },
    mounted() {

        this.provinces = JSON.parse(this.regions);
        console.log(this.regions);
        console.log('Component mounted.')
    }
}
</script>
