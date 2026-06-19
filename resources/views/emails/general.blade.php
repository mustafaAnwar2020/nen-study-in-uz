@extends('emails.layout')

@section('content')

    <div style="padding: 20px; background-color: rgb(255, 255, 255);">
        <div style="color: rgb(0, 0, 0); text-align: right;">
            <h1 style="margin: 1rem 0">إشعار جديد</h1>
            <p style="padding-bottom: 16px">

                <br>
                <b>{{$data['message']}}</b>
                <br>

            </p>
            <p style="padding-bottom: 16px">فريق<br>Yalla-Car</p>
        </div>
    </div>
    <div style="padding-top: 20px; color: rgb(153, 153, 153); text-align: center;">
        <p style="padding-bottom: 16px">
            جميع الحقوق محفوظة Yalla-Car {{date('Y')}}
        </p>
    </div>

@endsection
