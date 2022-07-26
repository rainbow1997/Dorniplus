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
            <h2>            مدیریت گزارشات (لاگ)
</h2>
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
   <th>نام لاگ</th>
   <th>توضیحات</th>
   <th>مدل هدف</th>
   <th>رویداد</th>
   <th>انجام دهنده</th>
   <th>زمان</th>
 </tr>
 @foreach ($activities as $key => $activity)
  <tr>
    <td>{{ $activity->id}}</td>
    <td>{{ $activity->log_name }}</td>
    <td>{{ $activity->description }}</td>
    <td>{{ $activity->subject_type }}</td>
    <td>{{ @$activity->event }}</td>

    <td>{{ @$activity->user->fname }} - {{ @$user->user->lname }}</td>
    <td>{{ verta($activity->created_at) }} </td>
  
  </tr>
 @endforeach
</table>



</div>
</div>
</div>
</div>
</x-app-layout>
