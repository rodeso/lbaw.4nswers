@php
    $isForYouPage = Route::currentRouteName() === 'foryou';
@endphp

@php
    $isPopular = Route::currentRouteName() === 'popular';
@endphp

@php
    $isUrgent = Route::currentRouteName() === 'urgent';
@endphp

@php
    $isNew = Route::currentRouteName() === 'new';
@endphp

<aside class="fixed top-20 left-5 w-[15%] bg-[color:#4E0F35] p-6 rounded-lg shadow-lg">
    <nav>
    <ul class="bg-[color:#C18A8A] rounded">
        <li>
            <a 
                href="{{ $isForYouPage ? route('home') : route('foryou') }}"
                class="block text-lg font-bold w-full text-left px-4 py-2 hover:bg-gray-300 {{ $isForYouPage ? 'text-[color:#FF006E] bg-[color:#4E0F35]' : 'bg-[color:#C18A8A]' }}"
            >
                4U
            </a>
        </li>
        <li>
            <a 
                href="{{ $isNew ? route('home') : route('new') }}"
                class="block text-lg font-bold w-full text-left px-4 py-2 hover:bg-gray-300 {{ $isNew ? 'text-[color:#FF006E] bg-[color:#4E0F35]' : 'bg-[color:#C18A8A]' }}"
            >
                New
            </a>
        </li>
        <li>
            <a 
                href="{{ $isUrgent ? route('home') : route('urgent') }}"
                class="block text-lg font-bold w-full text-left px-4 py-2 hover:bg-gray-300 {{ $isUrgent ? 'text-[color:#FF006E] bg-[color:#4E0F35]' : 'bg-[color:#C18A8A]' }}"
            >
                Urgent
            </a>
        </li>
        <li>
            <a 
                href="{{ $isPopular ? route('home') : route('popular') }}"
                class="block text-lg font-bold w-full text-left px-4 py-2 hover:bg-gray-300 {{ $isPopular ? 'text-[color:#FF006E] bg-[color:#4E0F35]' : 'bg-[color:#C18A8A]' }}"
            >
                Popular
            </a>
        </li>
    </ul>

    </nav>
    <div class="relative mt-4">
        <div class="absolute top-0 left-0 h-full w-1 bg-[color:#C18A8A] rounded"></div>
        @if (Auth::check() && !$user_tags->isEmpty())
            <h4 class="font-bold mb-4 text-[color:#C18A8A] pl-4">Subscribed Tags</h4>
                @foreach ($user_tags as $tag)
                    <li class="list-none">
                        <a href="{{ route('tag', ['id' => $tag->id]) }}" class="font-bold mb-4 text-[color:#C18A8A] pl-4">
                            {{ $tag->name }}
                        </a>
                    </li>
                @endforeach
        @elseif (Auth::check())
            <h4 class="font-bold mb-4 text-[color:#C18A8A] pl-4">No Tags Subscribed</h4>
        @else
        <a href="{{ route('login') }}" class="font-bold mb-4 text-[color:#C18A8A] block pl-4">
            <span>Login to Follow Tags</span>
        </a>

        @endif
    </div>
</aside>