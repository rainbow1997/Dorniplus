<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            مدیریت گزارشات (لاگ)
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-max mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-left">
                                <h2> مدیریت گزارشات (لاگ)
                                </h2>
                            </div>


                        </div>
                    </div>


                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6 bg-gray-50 dark:bg-gray-800">شناسه</th>
                                <th scope="col" class="py-3 px-6 bg-gray-50 dark:bg-gray-800">نام لاگ</th>
                                <th scope="col" class="py-3 px-6 bg-gray-50 dark:bg-gray-800">توضیحات</th>
                                <th scope="col" class="py-3 px-6 bg-gray-50 dark:bg-gray-800">مدل هدف</th>
                                <th scope="col" class="py-3 px-6 bg-gray-50 dark:bg-gray-800">رویداد</th>
                                <th scope="col" class="py-3 px-6 bg-gray-50 dark:bg-gray-800">انجام دهنده</th>
                                <th scope="col" class="py-3 px-6 bg-gray-50 dark:bg-gray-800">زمان</th>
                            </tr>
                            @foreach ($activities as $key => $activity)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td>{{ $activity->id}}</td>
                                    <td>{{ $activity->log_name }}</td>
                                    <td class="py-3 px-6 text-sm">{{ $activity->description }}</td>
                                    <td>{{ $activity->subject_type }}</td>
                                    <td>{{ @$activity->event }}</td>

                                    <td>{{ @$activity->user->fname }} - {{ @$user->user->lname }}</td>
                                    <td>{{ verta($activity->created_at) }} </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
