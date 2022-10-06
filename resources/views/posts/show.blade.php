<x-app-layout>
    <div class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-8 px-8 py-4 bg-white shadow-md">

        <x-flash-message :message="session('notice')" />
        <x-validation-errors :errors="$errors" />

        <article class="mb-2">
            <h2 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-1 text-3xl md:text-4xl">{{ $post->title }}
            </h2>
            <img src="{{ $post->image_url }}" alt="" class="mb-4">
            @if ($post->category_id == 5)
                <p class="w-full px-4 md:w-1/2 text-xl text-gray-800 leading-normal">自己評価:{{ '⭐️' }}</p>
            @elseif ($post->category_id == 4)
                <p class="w-full px-4 md:w-1/2 text-xl text-gray-800 leading-normal">自己評価:{{ '⭐️⭐️' }}</p>
            @elseif ($post->category_id == 3)
                <p class="w-full px-4 md:w-1/2 text-xl text-gray-800 leading-normal">自己評価:{{ '⭐️⭐️⭐️' }}</p>
            @elseif ($post->category_id == 2)
                <p class="w-full px-4 md:w-1/2 text-xl text-gray-800 leading-normal">自己評価:{{ '⭐️⭐️⭐️⭐️' }}</p>
            @elseif ($post->category_id == 1)
                <p class="w-full px-4 md:w-1/2 text-xl text-gray-800 leading-normal">自己評価:{{ '⭐️⭐️⭐️⭐️⭐️' }}</p>
            @endif
            <p class="text-sm mb-2 md:text-base font-normal text-gray-600">
            <div class="text-right text-sm mb-2 md:text-base font-normal text-gray-600">
                <b>{{ $post->user->name }}'s IPPON</b>
            </div>
            </p>
        </article>
        <div class="flex flex-row text-center my-4">
            @can('update', $post)
                <a href="{{ route('posts.edit', $post) }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">編集</a>
            @endcan
            @can('delete', $post)
                <form action="{{ route('posts.destroy', $post) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="削除" onclick="if(!confirm('削除しますか？')){return false};"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20">
                </form>
            @endcan
        </div>
    </div>
</x-app-layout>
