<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            مدیریت مطالب
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-max mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
<div class="flex">
    <div class=" margin-tb">
        <div class="pull-left">
            <h2>مدیریت مطالب</h2>
        </div>
       
        <div class="pull-right">
        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">

            <a class="btn btn-success" href="{{ route('posts.create') }}"> ساخت مطلب جدید</a>
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
    <table class="table-fixed w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">

 <tr>
   <th scope="col" class="py-3 px-6">شناسه</th>
   <th scope="col" class="py-3 px-6">عنوان</th>
   <th scope="col" class="py-3 px-6">موضوع</th>
   <th scope="col" class="py-3 px-6">نویسنده</th>
   <th scope="col" class="py-3 px-6">زمان تقریبی مطالعه</th>
   <th scope="col" class="py-3 px-6">زمان ایجاد</th>
   <th scope="col" class="py-3 px-6">زمان آخرین بروزرسانی</th>
   <th scope="col" class="py-3 px-6"width="280px">عملیات</th>
 </tr>
 @foreach ($posts as $key => $post)
  <tr>
    <td class="py-4 px-6">{{ $post->id }}</td>
    <td class="py-4 px-6">{{ $post->title }}</td>
    <td class="py-4 px-6">{{ $post->category->title }}</td>
    <td class="py-4 px-6">{{ $post->writerPerson->fname }} {{ $post->writerPerson->lname}} </td>
    <td class="py-4 px-6"> {{$post->estimated_time }}</td>
    <td class="py-4 px-6">{{ @verta($post->created_at) }}</td>
    <td class="py-4 px-6">{{ @verta($post->updated_at) }}</td>
    <td class="py-4 px-6">  

                {!! Form::open(['method' => 'DELETE','route' => ['posts.destroy', $post->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('حذف', ['class' => 'text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900']) !!}
                {!! Form::close() !!}
           
</td>
   
  </tr>
 @endforeach
</table>



</div>
</div>
</div>
</div>
</x-app-layout>
