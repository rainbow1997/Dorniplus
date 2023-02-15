<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            گزارش گیری از کاربران
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-max mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-left">
                                <h2>گزارش گیری از کاربران</h2>
                            </div>

                            <div class="pull-right">
                                <button type="button"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">

                                    <a class="btn btn-success" href="{{ route(getLocaleName().'.posts.index') }}">
                                        بازگشت</a>
                                </button>
                            </div>
                        </div>
                    </div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif


                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">

                    </div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
