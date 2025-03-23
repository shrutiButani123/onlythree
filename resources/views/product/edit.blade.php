@extends('layout.app')

@section('content')
<div class="card my-4">
  <h5 class="card-header">Featured</h5>
  <div class="card-body">
    <h5 class="card-title text-center">Edit Product</h5>

    @if(session('error'))
        <div class="text-danger text-sm">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="text-success text-sm">{{ session('success') }}</div>
    @endif

    <form action="{{ route('product.update', $product->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Ensure proper method for updating --}}
        
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Product Name" value="{{ old('name', $product->name) }}">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="price">Price</label>
            <input type="text" class="form-control" name="price" id="price" placeholder="10" value="{{ old('price', $product->price) }}">
            @error('price')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            @if($product->image)
                <img src="{{ asset($product->image) }}" width="100" class="mb-2">
            @endif
            <label for="image">Product Image</label>
            <input type="file" class="form-control-file" name="image" id="image">
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <select class="form-control" name="category" id="category">
                <option value="">Select a Category</option>
                @foreach($categories as $category)  
                    <option value="{{ $category->id }}" {{ old('category', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="subcategory">Sub Category</label>
            <select class="form-control" name="subcategory" id="subcategory">
                <option value="">Select a Sub Category</option>
                @foreach($product->category->subcategory as $subcategory)  
                    <option value="{{ $subcategory->id }}" {{ old('subcategory', $product->subcategory_id) == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                @endforeach
            </select>
            @error('subcategory')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" rows="3" placeholder="Product description">{{ old('description', $product->description) }}</textarea>
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