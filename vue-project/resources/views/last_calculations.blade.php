@extends('app')  

@section('content')
    <div>
        <h1>Last 10 Calculations</h1>

        <ul>
            @foreach ($lastCalculations as $calculation)
                <li>{{ $calculation->result }}</li>
            @endforeach
        </ul>
    </div>
@endsection
