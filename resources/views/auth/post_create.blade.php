<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            مطلب جدید
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
            <a class="btn btn-success" href="{{ route('posts.index') }}"> بازگشت</a>
        </div>
    </div>
</div>


@if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>خطا!</strong> با ورودی های شما مشکلی پیش آمده است..<br><br>
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
       @endforeach
    </ul>
  </div>
@endif



{!! Form::open(array('route' => 'posts.store','method'=>'POST','enctype="multipart/form-data"')) !!}
    <div class="mt-4">
        <x-label value="عنوان مطلب"></x-label>
    <x-input id="title" class="block mt-1 w-full" type="text" name="title" required autofocus />

    </div>
    <div class="mt-4">
        <x-label for="post_image" value="عکس" />

        <x-input id="post_image" class="block mt-1 w-full" type="file" name="post_image" :value="old('post_image')" autofocus />
    </div>
    <div class="mt-4">
        <x-label value="متن خود را وارد کنید"></x-label>
        <x-forms.tinymce-editor nameAttr="text"/>

    </div>
    <div class="mt-4">
        <x-label value="موضوع متن خود را وارد کنید"></x-label>
        {!! Form::select('category_id', $categories,[], array('class' => 'form-control','')) !!}

    </div>
    <x-button class=" mt-4 ml-4">
            ثبت پست
        </x-button>

{!! Form::close() !!}


</div>
</div>
</div>
</div>
</x-app-layout>
