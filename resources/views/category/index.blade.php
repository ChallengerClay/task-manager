@extends('layouts.main')
@section('title',__('category title'))
@section('content')
<div class="flex justify-center flex-col">
<div class="container mx-auto self-center">
    <div id="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
        <ul>

        </ul>
    </div>
    <div id="message" class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3">
    </div>
</div>
<form class=" max-w-sm my-4 self-center" id="category_form" action="{{route('categories.store')}}" method="POST">
    @csrf
    <div class="md:flex md:items-center mb-6">
      <div class="md:w-1/3">
        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
          {{__('category form name')}}
        </label>
      </div>
      <div class="md:w-2/3">
        <input class="categoryname bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="name" name="name" type="text" placeholder="PHP, Javascript,CSS...">
      </div>
    </div>
    <div class="md:flex md:items-center">
      <div class="md:w-1/3"></div>
      <div class="md:w-2/3">
        <button class="createcategory shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
          {{__('category create btn')}}
        </button>
      </div>
    </div>
  </form>
  <table id="categorytable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3 text-center">
                #
            </th>
            <th scope="col" class="px-6 py-3 text-center">
                {{__("category form name")}}
            </th>
            <th scope="col" class="px-6 py-3 text-center">
                {{__("actions")}}
            </th>
        </tr>
    </thead>
    <tbody>
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 text-center">
            @if (count($categories) > 0)
                @foreach($categories as $category)
                <tr id="{{'category-'.$category->id}}" class=" text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                    <td class="px-6 py-4">
                        {{$category->id}}
                    </td>
                    <td class="px-6 py-4">
                        {{$category->name}}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a data-id="{{$category->id}}" class="delete" id="delete" href="#"><span class="text-base text-red-500">X</span></a>
                    </td>
                </tr>
                @endforeach
            @else
            <td class="px-6 py-4 text-center" colspan="3">
                {{__("category empty table")}}
            </td>
            @endif
        </tr>
    </tbody>
</table>
</div>
@endsection
@section('script')
    <script type="module">
        $(document).ready(function (){
            $("#message").hide();
            $("#error").hide();
            $("#category_form").on( "submit", function(e) {
                e.preventDefault();
                $.ajax({
                    url:"{{route('categories.store')}}",
                    data: $("#category_form").serialize(),
                    type: 'POST',
                })
                .done(function(result) {
                    $('#categorytable tbody').append(result.newrow);
                    $("#message").show()
                    $("#message").html(result.message)
                    $("#category_form")[0].reset()
                })
                .fail(function(result) {
                    $("#error").show()
                    $.each(result.responseJSON.errors, function(key,value) {
                        $('#error ul').append('<li>'+value+'</li>');
                    }); 
                    $("#category_form")[0].reset()
                });
            });

            $("#categorytable").on('click','.delete',function (e) {
                e.preventDefault();
                let id = $(this).data('id')
                let url ="{{route('categories.destroy', ':id')}}"
                $.ajax({
                    url:url.replace(':id',id),
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    type: 'DELETE',
                })
                .done(function(result) {
                    $('#task-' + id).remove();
                    $("#message").show()
                    $("#message").html(result.message)
                    $("#category_form")[0].reset()
                })
                .fail(function( result) {
                    $("#error").show()
                    $.each(result.responseJSON.errors, function(key,value) {
                        $('#error ul').append('<li>'+value+'</li>');
                    }); 
                    $("#category_form")[0].reset()
                });
            });
        })
    </script>
@endsection