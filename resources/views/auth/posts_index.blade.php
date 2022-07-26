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
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>مدیریت مطالب</h2>
        </div>
       
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('users.create') }}"> ساخت مطلب جدید</a>
        </div>
    </div>
</div>


@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif

<table class="table-fixed">
 <tr>
   <th>شناسه</th>
   <th>عنوان</th>
   <th>موضوع</th>
   <th>نویسنده</th>
   <th>زمان تقریبی مطالعه</th>
   <th>زمان ایجاد</th>
   <th>زمان آخرین بروزرسانی</th>
   <th width="280px">عملیات</th>
 </tr>
 @foreach ($posts as $key => $post)
  <tr>
    <td>{{ $post->id }}</td>
    <td>{{ $post->title }}</td>
    <td>{{ $post->category->title }}</td>
    <td>{{ $post->writerPerson->fname }} {{ $post->writerPerson->fname}} </td>
    <td>{{ @verta($post->created_at) }}</td>
    <td>{{ @verta($post->updated_at) }}</td>
    <td>            <a class="btn btn-info" href="{{ route('posts.destroy',$post->id) }}">حذف</a>
</td>
   
  </tr>
 @endforeach
</table>



</div>
</div>
</div>
</div>
</x-app-layout>
