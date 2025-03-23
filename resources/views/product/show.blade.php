@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h3>Product Details</h3>
    <table class="table">
        <tr>
            <th>Name</th>
            <td>{{ $product->name }}</td>
        </tr>
        <tr>
            <th>Category</th>
            <td>{{ $product->category->name }}</td>
        </tr>
        <tr>
            <th>Subcategory</th>
            <td>{{ $product->subcategory->name }}</td>
        </tr>
        <tr>
            <th>Image</th>
            <td>
                @if($product->image)
                    <img src="{{ asset($product->image) }}" width="150">
                @else
                    No Image
                @endif
            </td>
        </tr>
        <tr>
            <th>Price</th>
            <td>${{ number_format($product->price, 2) }}</td>
        </tr>
        <tr>
            <th>Description</th>
            <td>{{ $product->description }}</td>
        </tr>
    </table>
    <a href="/" class="btn btn-secondary">Back</a>
</div>
@endsection
