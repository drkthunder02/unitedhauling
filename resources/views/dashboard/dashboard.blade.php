@extends('layouts.b4')
@section('content')
<br>
<div class="container">
    <table class="table table-striped table-bordered">
        <thead>
            <th>Pickup System</th>
            <th>Destination System</th>
            <th>Type</th>
            <th>Volume</th>
            <th>Date Expired</th>
            <th>Collateral</th>
            <th>Reward</th>
            <th>Availability</th>
        </thead>
        <tbody>
            @foreach($contracts as $contract)
            <tr>
                <td>{{ $contract['pickup'] }}</td>
                <td>{{ $contract['destination'] }}</td>
                <td>{{ $contract['type'] }}</td>
                <td>{{ $contract['volume'] }}</td>
                <td>{{ $contract['expired'] }}</td>
                <td>{{ $contract['collateral'] }}</td>
                <td>{{ $contract['reward'] }}</td>
                <td>{{ $contract['availability'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection