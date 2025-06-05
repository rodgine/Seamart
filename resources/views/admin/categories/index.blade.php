@extends('layouts.admin')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="card p-4 border border-light">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title fw-semibold mb-0">CATEGORY MANAGEMENT</h5>
                    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                        <i class="ti ti-plus"></i> Add Category
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped align-middle mb-0">
                        <thead class="">
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->description }}</td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-success edit-btn" data-id="{{ $category->id }}"
                                            data-name="{{ $category->name }}"
                                            data-description="{{ $category->description }}"
                                            data-url="{{ route('admin.categories.update', $category->id) }}"
                                            data-bs-toggle="modal" data-bs-target="#editCategoryModal">
                                            <i class="ti ti-edit"></i> Edit
                                        </button>

                                        <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $category->id }}"
                                            data-url="{{ route('admin.categories.destroy', $category) }}">
                                            <i class="ti ti-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">No categories found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.categories.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createCategoryModalLabel">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="editCategoryForm" method="POST" class="modal-content">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit-category-id">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" id="edit-category-name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" id="edit-category-description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('.delete-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const url = this.dataset.url;

                        Swal.fire({
                            title: 'Are you sure?',
                            text: "This action cannot be undone!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const form = document.createElement('form');
                                form.action = url;
                                form.method = 'POST';
                                form.innerHTML = `
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                        `;
                                document.body.appendChild(form);
                                form.submit();
                            }
                        });
                    });
                });

                document.querySelectorAll('.edit-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const {
                            id,
                            name,
                            description,
                            url
                        } = this.dataset;

                        document.getElementById('edit-category-id').value = id;
                        document.getElementById('edit-category-name').value = name;
                        document.getElementById('edit-category-description').value = description;

                        document.getElementById('editCategoryForm').action = url;
                    });
                });
            });
        </script>
    @endpush
@endsection
