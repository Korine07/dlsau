@extends('services.layout')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
 
            <div class="col-12 col-md-9 mt-5">
                <div class="card">
                    <div class="card-header">
                        <h2>Services</h2>
                    </div>
                    <div class="card-body">
                        <a href="{{ url('/services/create') }}" class="btn btn-success btn-sm" title="Add New Service">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>
                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($services as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ number_format($item->price, 2) }}</td>
 
                                        <td>
                                            <a href="{{ url('/services/' . $item->id) }}" title="View Service"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/services/' . $item->id . '/edit') }}" title="Edit Service"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
 
                                            <form method="POST" action="{{ url('/services' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Service" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
 
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection