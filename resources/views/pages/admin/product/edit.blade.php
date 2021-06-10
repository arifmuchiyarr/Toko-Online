@extends('layouts/admin')
@section('title')
    Product Edit
@endsection
@section('content')
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title pt-4">Product</h2>
            <p class="dashboard-subtitle">
                Edit Product
            </p>
        </div>
        <div class="dashboard-content">
            <div class="row">
                <div class="col-md-12">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('product.update',$item->id)}}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Product Name</label>
                                            <input type="text" name="name" required class="form-control" value="{{$item->name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Product Owner</label>
                                            <select name="users_id" class="form-control">
                                                <option value="{{$item->users_id}}" selected>{{$item->user->name}}</option>
                                                @foreach ($users as $user)
                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Category</label>
                                            <select name="categories_id" class="form-control">
                                                <option value="{{$item->categories_id}}" selected>{{$item->category->name}}</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Price</label>
                                            <input type="number" name="price" required class="form-control" value="{{$item->price}}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Description</label>
                                            <textarea name="description" id="editor" cols="30" rows="10" class="form-control">{!! $item->description !!}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-right">
                                        <button type="submit" class="btn btn-success px-5">Save Now</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace("editor");
    </script>
@endpush
