@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Category Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Category</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Categories</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-secondary btn-add btn-sm" data-toggle="modal" data-target="#AddEditModal">Add Category</button>
                </div>
            </div>

            <div class="card-body">
                <table id="categoryDataTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Category Name</th>
                            <th>Subcategories</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                @foreach($category->children as $child)
                                {{ $child->name }}<br>
                                @endforeach
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm editCategory" data-id="{{ $category->id }}" data-name="{{ $category->name }}" data-parent-id="{{ $category->parent_id }}" data-toggle="modal" data-target="#AddEditModal">Edit</button>
                                <button class="btn btn-danger btn-sm deleteCategory" data-id="{{ $category->id }}">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal for Add/Edit Category -->
<div id="AddEditModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="categoryForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="categoryId" name="id">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Parent Category</label>
                        <select class="form-control" id="parentId" name="parent_id">
                            <option value="">None</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {

    // Set CSRF token for all AJAX requests
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            
    // Open Add Modal
    $('.btn-add').click(function () {
        $('#categoryId').val('');
        $('#name').val('');
        $('#parentId').val('');
        $('#modalTitle').text('Add Category');
    });

    // Edit Category
    $('.editCategory').click(function () {
        $('#categoryId').val($(this).data('id'));
        $('#name').val($(this).data('name'));
        $('#parentId').val($(this).data('parent-id'));
        $('#modalTitle').text('Edit Category');
    });

    // Save Category
    $('#categoryForm').submit(function (e) {
        e.preventDefault();
        const id = $('#categoryId').val();
        const url = id ? `/categories/${id}` : '/categories';
        const method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: {
                _token: '{{ csrf_token() }}',
                name: $('#name').val(),
                parent_id: $('#parentId').val()
            },
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                }).then(() => {
                    location.reload();
                });
            },
            error: function (xhr) {
                const error = xhr.responseJSON?.message || 'An error occurred';
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error,
                });
            }
        });
    });

    // Delete Category
    $('.deleteCategory').click(function () {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won’t be able to undo this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/categories/${id}`,
                    method: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message,
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while deleting the category.',
                        });
                    }
                });
            }
        });
    });
});
</script>
@endsection
