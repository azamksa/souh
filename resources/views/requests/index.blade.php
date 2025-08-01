@extends('layouts.app')

@section('content')
<div>
    <h2>طلباتي</h2>
    <table>
        <thead>
            <tr>
                <th>الرحلة</th>
                <th>تاريخ الطلب</th>
                <th>الحالة</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $request)
            <tr>
                <td>{{ $request->trip->title }}</td>
                <td>{{ $request->created_at }}</td>
                <td>{{ $request->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection