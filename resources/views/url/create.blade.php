@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('url.store') }}" class="mt-3">
                            @csrf

                            <div class="mb-3">
                                <label for="original_url" class="form-label">Original URL:</label>
                                <input type="text" class="form-control" name="original_url" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Shorten</button>
                        </form>

                        @if (session('message'))
                            <div class="mt-3 alert alert-info">
                                {{ session('message') }}
                            </div>
                        @endif

                        @if (session('shortened'))
                            <div class="mt-3">
                                <p class="mb-1">Original URL: {{ session('original') }}</p>
                                <p class="mb-1">Shortened URL: <a href="{{ session('shortened') }}" target="_blank">{{ session('shortened') }}</a></p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
