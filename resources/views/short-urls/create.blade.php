@extends('layouts.new-app')

@section('title', 'Generate Short URL')

@section('content')
    <h2>Generate Short URL</h2>

    <form method="POST" action="{{ route('short-urls.store') }}">
        @csrf
        <div class="field">
            <label for="original_url">Long URL</label>
            <input type="url" id="original_url" name="original_url" value="{{ old('original_url') }}"
                   placeholder="https://example.com/some/long/path" required style="width: 480px;">
        </div>
        <button type="submit">Generate</button>
    </form>
@endsection