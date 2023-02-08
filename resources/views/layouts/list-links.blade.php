<div id="community" class="container">
    <div class="row">
        <div class="col-md-8">
            <div id="app">
                @include('flash-message')
                @yield('content')
            </div>
            <h1><a href="/community">Community</a>
                {{-- verifica si la variable "$slug" es distinta a null --}}
                @if (empty($slug))
                    <span> - ALL</span>
                @else
                    <span> - {{ $slug }}</span>
                @endif
            </h1>
            <hr>
            @if (count($links) <= 0)

                <h5 class="m-2">No contributions yet</h5>
            @else
                @foreach ($links as $link)
                    <li>
                        <span id="labelChannel" class="label label-default"
                            style="background: {{ $link->channel->color }}">
                            {{ $link->channel->title, $link->channel->slug }}
                        </span>
                        <a href="{{ $link->link }}" target="_blank">
                            {{ $link->title }}
                        </a>
                        <small>Contributed by: {{ $link->creator->name }}
                            {{ $link->updated_at->diffForHumans() }}</small>
                    </li>
                    <small>⭐Votes:</small>
                    <form method="POST" action="/votes/{{ $link->id }}">
                        {{ csrf_field() }}
                        <button type="button" class="btn {{ Auth::check() && Auth::user()->votedFor($link) ? 'btn-success' : 'btn-secondary' }}" {{ Auth::guest() ? 'disabled' : '' }}  >
                        {{$link->users()->count()}}
                        </button>
                        </form>
                @endforeach
            @endif
        </div>
