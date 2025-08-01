@extends('layouts.app')

@section('content')
<div>
    <h2>{{ $trip->title }}</h2>
    <p>{{ $trip->description }}</p>
    <p>{{ $trip->destination }}</p>
    <p>{{ $trip->price }} ر.س</p>
    <a href="{{ route('requests.create', $trip) }}">طلب الرحلة</a>
</div>
@endsection