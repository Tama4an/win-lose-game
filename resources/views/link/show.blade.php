@extends('layouts.app')

@section('title', 'Link Page')

@section('content')
    <h1>Special Link Page</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <p>Your unique link is valid until: {{ $link->expires_at }}</p>

    <div>
        <label for="unique-link">Unique Link:</label>
        <input type="text" id="unique-link" value="{{ url('/link/' . $link->unique_link) }}" readonly>
        <span class="copy-button" onclick="copyToClipboard()">Copy</span>
    </div>

    <form action="{{ url('/link/' . $link->unique_link . '/generate') }}" method="POST">
        @csrf
        <button type="submit">Generate New Link</button>
    </form>

    <form action="{{ url('/link/' . $link->unique_link . '/deactivate') }}" method="POST">
        @csrf
        <button type="submit">Deactivate Link</button>
    </form>

    <form action="{{ url('/link/' . $link->unique_link . '/lucky') }}" method="POST">
        @csrf
        <button type="submit">I'm Feeling Lucky</button>
    </form>

    <a href="{{ url('/link/' . $link->unique_link . '/history') }}">History</a>

    <script>
        function copyToClipboard() {
            var copyText = document.getElementById("unique-link");
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices
            document.execCommand("copy");
            alert("Copied the link: " + copyText.value);
        }
    </script>
@endsection
