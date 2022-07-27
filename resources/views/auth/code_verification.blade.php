<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           احراز هویت
        </h2>
    </x-slot>
<div class="flex flex-col text-right justify-center">
کد احراز هویت خود را وارد نمائید.
<x-auth-validation-errors class="mb-4" :errors="$errors" />

<form action="{{route('checking_verification')}}" method="post">
    @csrf
<input type="text" name="token" >
<input type="submit" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow" value="ثبت" />
</form>
</x-app-layout>
</div>