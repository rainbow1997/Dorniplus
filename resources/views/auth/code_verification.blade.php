<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            احراز هویت
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-max mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col text-right justify-center">
                        <x-auth-validation-errors class="mb-4" :errors="$errors"/>
                        @dump($errors)
                        <form action="{{route(getLocaleName().'.checking_verification')}}" method="post">
                            @csrf
                            <div class="flex flex-col m-3">
                                <label for="token"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    کد احراز
                                    هویت خود را وارد نمائید.
                                </label>

                                <input type="text" name="token"
                                       class=" mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                <input type="submit"
                                       class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow"
                                       value="ثبت"/>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
