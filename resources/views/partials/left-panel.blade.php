@php
    $isForYouPage = Route::currentRouteName() === 'foryou';
@endphp


<aside class="fixed top-20 left-5 w-[15%] bg-[color:#4E0F35] p-6 rounded-lg shadow-lg">
    <nav>
        <ul class="bg-[color:#C18A8A] rounded">
            <li>
                <button class="text-lg font-bold w-full text-left px-4 py-2 rounded hover:bg-gray-300 {{ $isForYouPage ? 'text-[color:#FF006E] bg-[color:#4E0F35]' : 'bg-[color:#C18A8A] ' }}">
                    @if ($isForYouPage)
                        <a href="{{ route('home') }}">4U</a>
                    @else
                        <a href="{{ route('foryou') }}">4U</a>
                    @endif
                </button>
            </li>
            <li>
                <button class="text-lg font-bold w-full text-left px-4 py-2 rounded hover:bg-gray-300">
                    New
                </button>
            </li>
            <li>
                <button class="text-lg font-bold w-full text-left px-4 py-2 rounded hover:bg-gray-300">
                    Urgent
                </button>
            </li>
            <li>
                <button class="text-lg font-bold w-full text-left px-4 py-2 rounded hover:bg-gray-300">
                    Popular
                </button>
            </li>
        </ul>
    </nav>
    <div class="mt-8">
        @if (Auth::check() && !$user_tags->isEmpty())
            <h4 class="font-bold mb-4 text-[color:#C18A8A]">Subscribed Tags</h4>
                @foreach ($user_tags as $tag)
                        <li>
                            <a class="text-[color:#C18A8A]">
                                {{ $tag->name }}
                            </a>
                        </li>
                @endforeach
        @elseif (Auth::check())
            <h4 class="font-bold mb-4 text-[color:#C18A8A]">No Tags Subscribed</h4>
        @else
            <a href="{{route('login')}}" class="font-bold mb-4 text-[color:#C18A8A]">Login to Subscribe to Tags</a>
        @endif
    </div>
</aside>