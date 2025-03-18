@extends('sreport.layoutt')

@section('content')
<div class="container">
    <h1 style="text-align: center;">De La Salle Araneta University</h1>
    <p style="text-align: center;">Salvador Araneta Campus, 303 Victoneta Ave, Potrero, Malabon, 1475 Metro Manila</p>
    <hr>

    <h2 style="text-align: center;">Service List</h2>
    <p style="text-align: center;">Showing services from <strong>{{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }}</strong> 
       to <strong>{{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</strong></p>

    @if($services->isEmpty())
        <p style="text-align: center;">No services found for this date range.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Service Name</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $key => $service)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $service->name }}</td>
                    <td>₱{{ number_format($service->price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <br>
    <a href="{{ url('/services-list') }}" style="display: block; text-align: center;">Go Back</a>
</div>
@endsection
