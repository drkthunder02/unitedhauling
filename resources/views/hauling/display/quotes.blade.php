@extends('layouts.b4')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Hauling Rates</h2>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <th>Load Size</th>
                    <th>Min Load Size</th>
                    <th>Max Load Size</th>
                    <th>Price Per Jump</th>
                    <th>Collateral</th>
                </thead>
                <tbody>
                    @foreach($loads as $load)
                        <tr>
                            <td>{{ ucfirst($load->load_size) }}</td>
                            <td>{{ number_format($load->min_load_size, 2, ".", ",") }}</td>
                            <td>{{ number_format($load->max_load_size, 2, ".", ",") }}</td>
                            <td>{{ number_format($load->price_per_jump, 2, ".", ",") }}</td>
                            <td>{{ number_format($load->collateral * 100.00, 2, ".", ",")}}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
            <div class="container">
                <h3>Max Collateral should be no more than 3b ISK</h3>
                <h3>Formula: (Jumps * Price Per Jump) + (Collateral * Collateral Percent)
            </div>
        </div>
    </div>
</div>
@endsection