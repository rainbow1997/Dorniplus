<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            مدیریت نقش و دسترسی ها
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-max mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
<div class="flex">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>مدیریت نقش و دسترسی ها</h2>
        </div>
       
        <div class="pull-right">
        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">

            <a class="btn btn-success" href="{{ route('roles.create') }}"> ساخت نقش و دسترسی جدید</a>
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
    <table class=" w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
    <tr>
     <th scope="col" class="py-3 px-6">شناسه</th>
     <th scope="col" class="py-3 px-6">نام</th>
     <th scope="col" width="280px" class="py-3 px-6">عملیات</th>
     </tr>

</thead>
<tbody>
    @foreach ($roles as $key => $role)
    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">

        <td>{{ ++$i }}</td>
        <td>{{ $role->name }}</td>
        <td>
        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">مشاهده</a></button>

            @can('role-edit')
            <!-- remember to clear laravel permission cache to get permissions correctly. -->
            <button type="button" class="text-white bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:focus:ring-yellow-900">

                <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">ویرایش</a>
                </button>
            @endcan
            @can('role-delete')
                {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('حذف', ['class' => 'text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900']) !!}
                {!! Form::close() !!}
            @endcan
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
</div>


{!! $roles->render() !!}



</div>
</div>
</div>
</div>
</x-app-layout>
