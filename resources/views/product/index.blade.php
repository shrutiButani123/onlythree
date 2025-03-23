@extends('layout.app')

@section('content')
<div class="card my-4">
  <h5 class="card-header">Products</h5>
  <div class="card-body">

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show text-sm" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="py-4">
        <form id="search-form">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" id="date_range" class="form-control" placeholder="Select Date Range">
                </div>
                <div class="col-md-4">
                    <button type="button" id="search-button" class="btn btn-primary">Search</button>
                    <button type="button" id="reset-button" class="btn btn-secondary">Reset</button>
                </div>
            </div>
        </form>
    </div>
    <div class="mb-4">
        <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm">Create Product</a>
        <a href="#" class="btn btn-primary btn-sm d-inline" id="export" >Export</a>
    </div>
    <table class="table table-hover table-striped" id="product_table">
        <thead>
            <tr>
                <th>#</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">Category</th>
                <th scope="col">Sub Category</th>
                <th scope="col">Created Date</th>                
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
        {{-- @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>  
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->subcategory->name }}</td>
                    <td class="d-flex">
                        <a href="{{ route('product.show', $product->id ) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-success">Edit</a>
                    <form action="{{ route('product.destroy', $product->id) }}" method="post">
                        @csrf
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger">Delete</a>
                    </form></td>                    
                </tr>
            @endforeach--}}
        </tbody>
    </table>
  </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $('#date_range').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('#date_range').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
            });

            $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

            var table = $('#product_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('products') }}",
                    data: function(d) {
                        d.date_range = $('#date_range').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    // { data: 'id', name: 'id' },
                    { data: 'product_name', name: 'product_name' },
                    { data: 'price', name: 'price' },
                    { data: 'category', name: 'category' },
                    { data: 'subcategory', name: 'subcategory' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
            });

            $('#search-button').click(function() {
                table.draw();
            });

            $('#reset-button').click(function() {
                $('#date_range').val('');
                table.draw();
            });
            
            $('#export').on('click', function () {
                var selectedDateRange = $('#date_range').val();
                var url = "{{ route('product.export', 'date') }}";

                if (selectedDateRange !== "") {
                    url = url.replace('date', selectedDateRange);
                }
                window.location.href = url;
            });
        });
    </script>
@endsection