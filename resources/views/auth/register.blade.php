<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>
        
<!-- Validation Errors -->
<x-auth-validation-errors class="mb-4" :errors="$errors" />

<form method="POST" action="{{ route('register')}}" class="rtl text-right" style="font-family:'Shabnam'">
    @csrf

    <!-- Name -->
    <div>
        <x-label for="fname" value="نام" />

        <x-input id="fname" class="block mt-1 w-full" type="text" name="fname" :value="old('fname')" required autofocus />
    </div>
    <div class="mt-4">
        <x-label for="lname" value="نام خانوادگی" />

        <x-input id="lname" class="block mt-1 w-full" type="text" name="lname" :value="old('lname')" required autofocus />
    </div>
    <div class="mt-4">
        <x-label for="username" value="نام کاربری" />

        <x-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus />
    </div>
    <!-- Email Address -->
    <div class="mt-4">
        <x-label for="email" value="ایمیل" />

        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
    </div>

    <!-- Password -->
    <div class="mt-4">
        <x-label for="password" value="رمز عبور" />

        <x-input id="password" class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required autocomplete="new-password" />
    </div>

    <!-- Confirm Password -->
    <div class="mt-4">
        <x-label for="password_confirmation" value="رمز عبور مجدد" />

        <x-input id="password_confirmation" class="block mt-1 w-full"
                        type="password"
                        name="password_confirmation" required />
    </div>
    <div id="app" class="mt-4">
    <register-component></register-component>
    </div>
    <div class="mt-4">
        <x-label for="national_code" value="کد ملی" />

        <x-input id="national_code" class="block mt-1 w-full" type="number" name="national_code" :value="old('national_code')" required autofocus />
    </div>
    <div class="mt-4">
        <x-label for="phone" value="تلفن همراه" />

        <x-input id="phone" class="block mt-1 w-full" type="number" name="phone" :value="old('phone')" required autofocus />
    </div>
    <div class="mt-4">
        <x-label for="avatar" value="عکس" />

        <x-input id="avatar" class="block mt-1 w-full" type="file" name="avatar" :value="old('avatar')" required autofocus />
    </div>
    <div class="mt-4">
        <x-label for="gender" value="جنسیت" />
        <x-input id="gender_male" name="gender" type="radio" value="مذکر"/>مذکر
        <x-input id="gender_female" name="gender" type="radio" value="مونث"/>مونث 
    </div>
    <div class="mt-4">
        <x-label for="military_status" value="وضعیت نظام وظیفه" />
        <x-input id="military_status_1" name="military_status" type="radio" value="معاف"/>معاف
        <x-input id="military_status_2" name="military_status" type="radio" value="مشمول"/>مشمول 
    </div>

    <div class="flex items-center justify-end mt-4">
        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login')}}">
            آیا پیش از این ثبت نام کرده اید؟
        </a>

        <x-button class="ml-4">
            ثبت نام
        </x-button>
    </div>
</form>

    </x-auth-card>
</x-guest-layout>
