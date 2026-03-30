@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Inventory Management</h1>
    
    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Products</div>
                <div class="card-body">
                    <h3>{{ $products->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Categories</div>
                <div class="card-body">
                    <h3>{{ $categories->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Suppliers</div>
                <div class="card-body">
                    <h3>{{ $suppliers->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Low Stock</div>
                <div class="card-body">
                    <h3>{{ $lowStock->count() }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            Products List
            <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm float-end">Add Product</a>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Supplier</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->supplier->name ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection