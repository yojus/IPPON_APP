<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-flash-message :message="session('notice')" />

            <div class="flex space-x-2 mb-4 text-sm font-medium">
                <div class="flex space-x-4">
                    <form class="form-inline" action="{{ route('posts.index') }}">
                        <input type="text" name="key"
                            value="@if (isset($key)) {{ $key }} @endif"
                            class="px-6 h-12 font-semibold tracking-wider border border-slate-200 text-slate-900"
                            placeholder="キーワードを入力">
                        <input type="text" name="keys"
                            value="@if (isset($keys)) {{ $keys }} @endif"
                            class="px-6 h-12 font-semibold tracking-wider border border-slate-200 text-slate-900"
                            placeholder="カテゴリーを入力">
                        <button type="submit"
                            class="px-6 h-12 uppercase font-semibold tracking-wider border-2 border-black bg-teal-400 text-black">Search</button>
                    </form>
                </div>
            </div>

            {{-- <div class="container max-w-7xl mx-auto px-4 md:px-12 pb-3 mt-3"> --}}
                <div class="max-w-7xl px-4 md:px-12 pb-3 mt-3 bg-teal-200 bg-gradient-to-l" background-color: rgb(153 246 228);>
                    <div class="flex flex-wrap -mx-1 lg:-mx-4 mb-4">
                        @foreach ($posts as $post)
                            <article class="w-full px-4 md:w-1/2 text-xl text-gray-800 leading-normal">
                                <a href="{{ route('posts.show', $post) }}">
                                    <h2
                                        class="px-6 h-12 font-semibold tracking-wider border border-slate-200 text-slate-900">
                                        {{ $post->title }}</h2>
                                    <img class="w-full mb-2" src="{{ $post->image_url }}" alt="">
                                    @if ($post->category_id == 5)
                                        <p>{{ $post->category->point }} {{ '⭐️' }}</p>
                                    @elseif ($post->category_id == 4)
                                        <p>{{ $post->category->point }} {{ '⭐️⭐️' }}</p>
                                    @elseif ($post->category_id == 3)
                                        <p>{{ $post->category->point }} {{ '⭐️⭐️⭐️' }}</p>
                                    @elseif ($post->category_id == 2)
                                        <p>{{ $post->category->point }} {{ '⭐️⭐️⭐️⭐️' }}</p>
                                    @elseif ($post->category_id == 1)
                                        <p>{{ $post->category->point }} {{ '⭐️⭐️⭐️⭐️⭐️' }}</p>
                                    @endif
                                    <p class="text-sm mb-2 md:text-base font-normal text-gray-600">
                                        <div class="text-right text-sm mb-2 md:text-base font-normal text-gray-600">
                                            <b>{{ $post->user->name }}'s IPPON</b>
                                        </div>
                                    </p>
                                </a>
                            </article>
                        @endforeach

                    </div>
                    {{ $posts->links() }}
                </div>
            </div>
</x-app-layout>
