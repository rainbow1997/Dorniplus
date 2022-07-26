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


<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <input type="text" name="fnameSearch" class="form-control" placeholder="Enter Title For Search" value="{{ old('fnameSearch') }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <button class="btn btn-success">جست و جو</button>
        </div>
    </div>
</div>
</form>

<table class="table-fixed">
 <tr>
   <th>شناسه</th>
   <th>نام</th>
   <th>نام خانوادگی</th>
   <th>ایمیل</th>
   <th>استان</th>
   <th>شهرستان</th>
   <th>نقش ها</th>
   <th width="280px">عملیات</th>
 </tr>
 @foreach ($data as $key => $user)
  <tr>
    <td>{{ ++$i }}</td>
    <td>{{ $user->fname }}</td>
    <td>{{ $user->lname }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ @$user->province->title }}</td>
    <td>{{ @$user->city->title }}</td>
    <td>
      @if(!empty($user->getRoleNames()))
        @foreach($user->getRoleNames() as $v)
           <label class="badge badge-success">{{ $v }}</label>
        @endforeach
      @endif
    </td>
    <td>
       <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">مشاهده</a>
       <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">ویرایش</a>
        {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
            {!! Form::submit('حذف', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </td>
  </tr>
 @endforeach
</table>


{!! $data->render() !!}

</div>
</div>
</div>
</div>
</x-app-layout>
