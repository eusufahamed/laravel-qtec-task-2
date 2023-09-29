@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mt-3">
                            @foreach ($urls as $url)
                                <p class="mb-1">Original URL: {{ $url->original_url }}</p>
                                <p class="mb-1">Shortened URL: <a href="{{ $url->shortened_url }}" target="_blank">{{ $url->shortened_url }}</a></p>
                                <p id="clickCount{{ $url->id }}" class="mb-1">URL Visit: {{ $url->click_count }}</p>
                                <button id="checkClickCount{{ $url->id }}" class="btn btn-primary">Refresh</button>
                                <hr>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                $('[id^=checkClickCount]').on('click', async function () {
                    const urlId = $(this).attr('id').replace('checkClickCount', '');

                    // Make an AJAX request to get the latest click count
                    try {
                        const response = await $.ajax({
                            url: '{{ route("url.clickCount") }}',
                            data: { urlId: urlId },
                            method: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: 'json',
                        });

                        // Display the click count paragraph
                        $('#clickCount' + urlId).text('URL Visit: ' + response.clickCount).show();
                    } catch (error) {
                        console.error('Error fetching click count:', error);
                    }
                });
            });
        </script>
    @endpush
@endsection
