<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           احراز هویت
        </h2>
    </x-slot>

کد احراز هویت خود را وارد نمائید.
<x-auth-validation-errors class="mb-4" :errors="$errors" />

<form action="{{route('checking_verification')}}" method="post">
    @csrf
<input type="text" name="token" >
<input type="submit" class="btn btn-warning text-white" value="ثبت">

</form>
</x-app-layout>
