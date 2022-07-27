<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            مدیریت کاربری
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-max mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
<div class="flex">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>مدیریت کاربری</h2>
        </div>
        <button class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
            <a href="{{ route('reporting','pdf') }}"> 
                گزارش گیری PDF
            </a>

    </button>
    <button class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
    <a href="{{ route('reporting','excel') }}"> گزارش گیری Excel</a>
    </button>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('users.create') }}"> ساخت کاربر جدید</a>
        </div>
    </div>
</div>


@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif
<form method="GET" action="">


<div class="flex">
    <div class="col-md-6">
        <div class="form-group">
            <input type="text" name="fnameSearch" class="form-control" placeholder="Enter Title For Search" value="{{ old('fnameSearch') }}">
        </div>
    </div>
    <div class="">
        <di class="form-group ">
        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            جستجو
</button>
    </div>
</div>
</form>

<div class="overflow-x-auto relative shadow-md sm:rounded-lg">
    <table class="table-fixed w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">

 <tr>
   <th scope="col" class="py-3 px-6">شناسه</th>
   <th scope="col" class="py-3 px-6">نام</th>
   <th scope="col" class="py-3 px-6">نام خانوادگی</th>
   <th scope="col" class="py-3 px-6">ایمیل</th>
   <th scope="col" class="py-3 px-6">استان</th>
   <th scope="col" class="py-3 px-6">شهرستان</th>
   <th scope="col" class="py-3 px-6">نقش ها</th>
   <th scope="col" class="py-3 px-6" width="280px">عملیات</th>
 </tr>
</thead>
<tbody>
 @foreach ($data as $key => $user)
  <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
    <td class="py-4 px-6">{{ ++$i }}</td>
    <td class="py-4 px-6">{{ $user->fname }}</td>
    <td class="py-4 px-6">{{ $user->lname }}</td>
    <td class="py-4 ">{{ $user->email }}</td>
    <td class="py-4 mr-3">{{ @$user->province->title }}</td>
    <td class="py-4 px-6">{{ @$user->city->title }}</td>
    <td class="py-4 px-6">
      @if(!empty($user->getRoleNames()))
        @foreach($user->getRoleNames() as $v)
           <label class="badge badge-success">{{ $v }}</label>
        @endforeach
      @endif
    </td>
    <td class="py-4 px-6">
    <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">

       <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">مشاهده</a></button>
       <button type="button" class="text-white bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:focus:ring-yellow-900">

       <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">ویرایش</a></button>
        {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
            {!! Form::submit('حذف', ['class' => 'text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900']) !!}
        {!! Form::close() !!}
    </td>
  </tr>
 @endforeach
 </tbody>
</table>


{!! $data->render() !!}

</div>
</div>
</div>
</div>
</x-app-layout>
