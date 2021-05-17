<div class="py-4">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">

        @if($header ?? false)
            <h2 class="font-semibold text-l text-green-400 leading-tight pb-3">
                {{ $header }}
            </h2>
        @endif

        <div class="grid grid-cols-4 gap-4">
            {{ $fields }}
        </div>

        <a href="/{{ $resource }}/{{ $model->id }}/edit" class="mt-5 bg-gray-100 hover:bg-green-400 hover:text-white transition text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
            <x-icons.svg-edit class="h-4 w-4 mr-2"></x-icons.svg-edit>
            <span>Edit</span>
        </a>

    </div>
</div>