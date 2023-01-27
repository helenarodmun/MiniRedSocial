@extends('layouts.app')
@section('content')
    <div id="community" class="container">
        <div class="row">
            <div class="col-md-8">
                <div id="app">
                    @include('flash-message')
                    @yield('content')
                </div>
                <h1 class="m-5">Community</h1>
                <hr>
                @if (count($links) <= 0)
                
                    <h5 class="m-2">No contributions yet</h5>
                @else
                @foreach ($links as $link)
                <li>                    
                    <span id="labelChannel" class="label label-default" style="background: {{ $link->channel->color }}">
                        {{ $link->channel->title }}
                        </span>
                    <a href="{{$link->link}}" target="_blank">
                        {{$link->title}}
                    </a>
                    <small>Contributed by: {{$link->creator->name}} {{$link->updated_at->diffForHumans()}}</small>
                </li>
                @endforeach
                @endif
            </div>
            <div id="cardForm"class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Contribute a link</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/community">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="title">Title:</label>

                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" placeholder="What is the title of your article?"
                                    value="{{ old('title') }}">
                                @error('title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="link">Link:</label>
                                <input type="text" class="form-control @error('link') is-invalid @enderror"
                                    id="link" name="link" placeholder="What is the URL?" value={{ old('link') }}>
                                @error('title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group card-footer">
                                <button class="btn btn-primary">Contribute Link</button>
                            </div>
                            <div class="form-group">
                                <label for="Channel">Channel:</label>
                                <select class="form-control @error('channel_id') is-invalid @enderror" name="channel_id">
                                    <option selected disabled>Pick a Channel...</option>
                                    @foreach ($channels as $channel)
                                        <option value="{{ $channel->id }}"
                                            {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                                            {{ $channel->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('channel_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        {{ $links->links() }}

    </div>


@stop
