@props(['columns', 'sort', 'order', 'route', 'items', 'search', 'perPage'])

{{-- filter --}}
<x-table.filter :search="$search" :perPage="$perPage" />

<hr class="my-5 border-gray-200 dark:border-gray-700">

{{-- table --}}
<div class="relative overflow-x-auto mb-5 max-h-[70vh]">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                @foreach ($columns as $column)
                    <th scope="col" class="px-6 py-3">
                        @if ($sort === $column['key'] && $order === 'asc')
                            <a href="{{ route($route . '.index', session('locale'), ['sort' => $column['key'], 'order' => 'desc']) }}"
                                class="whitespace-nowrap">
                                {{ $column['title'] }} <i class="fa-solid fa-sort-down"></i>
                            </a>
                        @elseif ($sort === $column['key'] && $order === 'desc')
                            <a href="{{ route($route . '.index', session('locale'), ['sort' => null, 'order' => null]) }}"
                                class="whitespace-nowrap">
                                {{ $column['title'] }} <i class="fa-solid fa-sort-up"></i>
                            </a>
                        @else
                            <a href="{{ route($route . '.index', session('locale'), ['sort' => $column['key'], 'order' => 'asc']) }}"
                                class="whitespace-nowrap">
                                {{ $column['title'] }} <i class="fa-solid fa-sort"></i>
                            </a>
                        @endif
                    </th>
                @endforeach

                <th scope="col" class="px-6 py-3">
                    {{ __('app.actions') }}
                </th>
            </tr>
        </thead>

        @if (count($items) > 0)
            <tbody>
                @foreach ($items as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        @foreach ($columns as $key => $column)
                            @switch($column['type'] ?? "")
                                @case('text')
                                    <td class="px-6 py-4 min-w-[250px]">
                                        {{ $item->{$column['key']} }}
                                    </td>
                                @break

                                @case('tinymce')
                                    <td class="px-6 py-4 min-w-[300px]">
                                        {!! $item->{$column['key']} !!}
                                    </td>
                                @break

                                @case('datetime')
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $item->{$column['key']} }}
                                    </td>
                                @break

                                @case('image')
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-image src="{{ $item->{$column['key']} }}" alt="{{ $item->{$column['key']} }}"
                                            class="w-10 h-10 rounded-lg object-contain" />
                                    </td>
                                @break

                                @case('published')
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($item->{$column['key']})
                                            <span
                                                class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300 uppercase">Published</span>
                                        @else
                                            <span
                                                class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300 uppercase">Not
                                                Published</span>
                                        @endif
                                    </td>
                                @break

                                @default
                                    <td class="px-6 py-4 min-w-[250px]">
                                        {{ $item->{$column['key']} }}
                                    </td>
                            @endswitch
                        @endforeach

                        <td class="px-6 py-4 ">

                            <div class="flex gap-2">
                                <a
                                    href="{{ route($route . '.show', ['locale' => session('locale'), 'slug' => $item->slug ?? null, 'id' => $item->id ?? null]) }}">
                                    <i class="fa-solid fa-eye"></i>
                                </a>

                                <a
                                    href="{{ route($route . '.edit', ['locale' => session('locale'), 'slug' => $item->slug ?? null, 'id' => $item->id ?? null]) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <form
                                    action="{{ route($route . '.destroy', ['locale' => session('locale'), 'slug' => $item->slug ?? null, 'id' => $item->id ?? null]) }}"
                                    id="form-delete-{{ $item->slug ?? $item->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button data-modal-target="popup-modal"
                                        data-to-delete="{{ $item->slug ?? $item->id }}" type="button"
                                        class="js-btn-delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        @else
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4 whitespace-nowrap text-center" colspan="{{ count($columns) + 1 }}">
                        {{ __('app.no_items_found') }}
                    </td>
                </tr>
            </tbody>
        @endif
    </table>
</div>

{{-- pagination --}}
<x-pagination :items="$items" />

<x-table.delete />
