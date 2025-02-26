@extends('layouts.main')
@section('title',__('task title'))
@section('content')
<div class="flex justify-center flex-col">
<div id="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"><ul></ul></div>
<div id="message" class=" bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3">
</div>
<div class="w-full max-w-xs my-4 self-center">
    <form id="task_form" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="POST" action="{{route('tasks.store')}}">
        @csrf
        <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
          Task
        </label>
        <input name="task" id="task" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="Task name">
      </div>
      <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
          {{__('category title')}}
        </label>
        @foreach ($categories as $category)
        <div class="flex items-center mb-4">
            <input name="categories[]" id="default-checkbox" type="checkbox" value="{{$category->id}}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label for="default-checkbox" class="ms-2 text-sm font-medium text-black-900 dark:text-black-300">{{$category->name}}</label>
        </div>
        @endforeach
      </div>
      <div class="flex items-center justify-between">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
          {{__('task create btn')}}
        </button>
      </div>
    </form>
  </div>

  <table id="taskstable" class=" text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 m-4">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3 text-center">
                #
            </th>
            <th scope="col" class="px-6 py-3 text-center">
                {{__("task form name")}}
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
            @if (count($tasks) > 0)
                @foreach($tasks as $task)
                <tr id="{{'task-'.$task->id}}" class=" text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                    <td class="px-6 py-4">
                        {{$task->id}}
                    </td>
                    <td class="px-6 py-4">
                        {{$task->task}}
                    </td>
                    <td>
                        @foreach ($task->categories as $category)
                            <span class="bg-blue-100 hover:bg-blue-200 text-blue-800 text-xs font-semibold me-2 px-2.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-blue-400 border border-blue-400 inline-flex items-center justify-center">{{$category->name}}</span>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a data-id="{{$task->id}}" class="delete" id="delete" href="#"><span class="text-base text-red-500">X</span></a>
                    </td>
                </tr>
                @endforeach
            @else
            <td class="px-6 py-4 text-center" colspan="4">
                {{__("task empty table")}}
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
        $("#task_form").on( "submit", function(e) {
            e.preventDefault();
            $.ajax({
                url:"{{route('tasks.store')}}",
                data: $("#task_form").serialize(),
                type: 'POST',
            })
            .done(function(result) {
                $('#taskstable tbody').append(result.newrow);
                $("#message").show()
                $("#message").html(result.message)
                $("#task_form")[0].reset()
            })
            .fail(function(result) {
                $("#error").show()
                $.each(result.responseJSON.errors.task, function(key,value) {
                    $('#error ul').append('<li>'+value+'</li>');
                }); 
                $.each(result.responseJSON.errors.categories, function(key,value) {
                    $('#error ul').append('<li>'+value+'</li>');
                }); 
                $("#task_form")[0].reset()
            });
        })

        $("#taskstable").on('click','.delete',function (e) {

            e.preventDefault();
            let id = $(this).data('id')
            let url ="{{route('tasks.destroy', ':id')}}"
            $.ajax({
                url:url.replace(':id',id),
                data: {
                    _token: '{{ csrf_token() }}',
                },
                type: 'DELETE',
            })
            .done(function(result) {
                $('#task-' + id).remove();
                $("#message").css('display','block')
                $("#message").html(result.message)
                $("#task_form")[0].reset()
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.log(result);
                $("#error").css('display','block')
                $("#error").html(jqXHR.message)
                $("#task_form")[0].reset()
            });
        })
    })
    </script>
@endsection