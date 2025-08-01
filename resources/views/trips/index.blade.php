@extends('layouts.app')

@section('content')
<div>
    <h2>الرحلات المتاحة</h2>
    <div>
        @foreach($trips as $trip)
        <div>
            <h3>{{ $trip->title }}</h3>
            <p>{{ $trip->destination }}</p>
            <p>{{ $trip->price }} ر.س</p>
            <a href="{{ route('trips.show', $trip) }}">عرض التفاصيل</a>
        </div>
        @endforeach
    </div>
</div>
@endsection