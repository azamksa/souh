@extends('layouts.app')

@section('content')
<div>
    <h2>طلب رحلة جديدة</h2>
    <form action="{{ route('requests.store') }}" method="POST">
        @csrf
        <input type="hidden" name="trip_id" value="{{ $trip->id }}">
        <div>
            <label for="notes">ملاحظات</label>
            <textarea name="notes"></textarea>
        </div>
        <button type="submit">إرسال الطلب</button>
    </form>
</div>
@endsection