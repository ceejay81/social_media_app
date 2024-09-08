<!-- resources/views/settings/edit.blade.php -->

@extends('layouts.app') <!-- Extending a base layout -->

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/settings.css') }}">
@endsection
@section('content')
<div class="container">
    <h1>Edit Settings</h1>

    <!-- Display validation errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form to edit settings -->
    <form action="{{ route('settings.update', $setting->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Indicates that the form will perform a PUT request -->

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $setting->name) }}" required>
        </div>

        <div class="form-group">
            <label for="value">Value</label>
            <input type="text" name="value" id="value" class="form-control" value="{{ old('value', $setting->value) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $setting->description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Settings</button>
    </form>

    <a href="{{ route('settings.index') }}" class="btn btn-secondary mt-3">Back to Settings</a>
</div>
@endsection
