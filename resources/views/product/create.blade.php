@extends('layout.app')

@section('content')
<div class="card my-4">
  <h5 class="card-header">Featured</h5>
  <div class="card-body">
    <h5 class="card-title text-center">Create Product</h5>

    @if(session('error'))
        <div class="text-danger text-sm">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="text-success text-sm">{{ session('success') }}</div>
    @endif

    <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Product Name" value="{{ old('name') }}">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="price">Price</label>
            <input type="text" class="form-control @error('price') is-invalid @enderror" name="price" id="price" placeholder="10" value="{{ old('price') }}">
            @error('price')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="image">Product Image</label>
            <input type="file" class="form-control-file @error('image') is-invalid @enderror" name="image" id="image">
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <select class="form-control @error('category') is-invalid @enderror" name="category" id="category">
                <option value="">Select a Category</option>
                @foreach($categories as $category)  
                    <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="subcategory">Sub Category</label>
            <select class="form-control @error('subcategory') is-invalid @enderror" name="subcategory" id="subcategory">
                <option value="">Select a Sub Category</option>
            </select>
            @error('subcategory')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3" placeholder="Product description">{{ old('description') }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4 text-center">
            <button type="submit" class="btn btn-secondary btn-lg">Submit</button>
        </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            
            console.log('fff');
            
            $("#category").on("change",function(){
                var categoryId = $(this).val();

                if(categoryId) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('product.subcategory') }}",
                        data: { 
                            _token: "{{ csrf_token() }}",
                            categoryId: categoryId },
                        dataType: "json",
                        success: function(data){
                            $("#subcategory").empty();
                            $("#subcategory").append('<option value="">Select a Sub Category</option>');
                            $.each(data, function(key, value){
                                $("#subcategory").append('<option value="'+value.id+'">'+value.name+'</option>');
                            })
                        }
                    });
                } else {
                    $("#subcategory").empty();
                    $("#subcategory").append('<option value="">Select a Sub Category</option>');
                }
                              
            });  
        });
    </script>
@endsection