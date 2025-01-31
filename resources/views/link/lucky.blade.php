@extends('layouts.app')

@section('title', 'Lucky Result')

@section('content')
    <h1>Lucky Result</h1>
    <p>Random Number: {{ $randomNumber }}</p>
    <p>Result: {{ $result }}</p>
    <p>Win Amount: {{ $winAmount }}</p>
    <a href="{{ url('/link/' . $link->unique_link) }}">Back</a>
@endsection
