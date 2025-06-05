@extends('layouts.admin')

@section('content')
<h2 class="text-xl font-bold mb-4">{{ isset($category) ? 'Edit' : 'Add' }} Category</h2>

<form method="POST" action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
    @csrf
    @if(isset($category)) @method('PUT') @endif

    <div class="mb-4">
        <label class="block font-semibold">Name</label>
        <input name="name" class="w-full border p-2" value="{{ old('name', $category->name ?? '') }}" required>
    </div>

    <div class="mb-4">
        <label class="block font-semibold">Description</label>
        <textarea name="description" class="w-full border p-2">{{ old('description', $category->description ?? '') }}</textarea>
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">{{ isset($category) ? 'Update' : 'Save' }}</button>
</form>
@endsection
