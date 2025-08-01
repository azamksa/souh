@extends('layouts.admin')

@section('admin-content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-xl">إدارة الرحلات</h2>
    <a href="{{ route('admin.trips.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">إضافة رحلة جديدة</a>
</div>

<table class="min-w-full">
    <thead>
        <tr>
            <th>العنوان</th>
            <th>الوجهة</th>
            <th>السعر</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        @foreach($trips as $trip)
        <tr>
            <td>{{ $trip->title }}</td>
            <td>{{ $trip->destination }}</td>
            <td>{{ $trip->price }} ر.س</td>
            <td>
                <a href="{{ route('admin.trips.edit', $trip) }}">تعديل</a>
                <form action="{{ route('admin.trips.destroy', $trip) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">حذف</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection