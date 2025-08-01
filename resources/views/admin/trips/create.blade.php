@extends('layouts.admin')

@section('admin-content')
<div>
    <h2 class="text-xl">إضافة رحلة جديدة</h2>
    <form action="{{ route('admin.trips.store') }}" method="POST">
        @csrf
        <div>
            <label for="title">العنوان</label>
            <input type="text" name="title" required>
        </div>
        <div>
            <label for="destination">الوجهة</label>
            <input type="text" name="destination" required>
        </div>
        <div>
            <label for="price">السعر</label>
            <input type="number" name="price" required>
        </div>
        <div>
            <label for="image_url">رابط الصورة</label>
            <input type="url" name="image_url" required>
        </div>
        <button type="submit">إضافة</button>
    </form>
</div>
@endsection