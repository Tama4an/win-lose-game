@extends('layouts.app')

@section('title', 'History')

@section('content')
    <h1>History</h1>
    <ul>
        @foreach($history as $entry)
            <li>
                Random Number: {{ $entry->random_number }},
                Result: {{ $entry->result }},
                Win Amount: {{ $entry->win_amount }}
            </li>
        @endforeach
    </ul>
    <a href="{{ url('/link/' . $link->unique_link) }}">Back</a>
@endsection
