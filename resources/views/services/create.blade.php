@extends('services.layout')
@section('content')

<div class="card">
    <div class="card-header">Services Page</div>
    <div class="card-body">
      
        <form action="{{ url('services') }}" method="post">
            {!! csrf_field() !!}
            <label>Name</label></br>
            <input type="text" name="name" id="name" class="form-control"></br>
            
            <label>Price</label></br>
            <input type="text" name="price" id="price" class="form-control" value="0.00" oninput="formatPrice(this)" step="0.01"></br>
            
            <input type="submit" value="Save" class="btn btn-success"></br>
        </form>
    </div>
</div>

<!-- Add JavaScript for price formatting -->
<script>
    function formatPrice(input) {
        let value = input.value.replace(/[^0-9.]/g, ''); // Remove non-numeric characters except dot
        value = parseFloat(value).toFixed(2);  // Format to 2 decimal places
        input.value = isNaN(value) ? '0.00' : value; // If invalid, set to 0.00
    }
</script>

@stop
