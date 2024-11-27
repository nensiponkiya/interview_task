@extends('layouts.app')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Product</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-secondary btn-add btn-sm" data-toggle="modal" data-target="#AddEditModal">Add</button>
                </div>
            </div>

            <div class="card-body">
                <table id="DataTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</section>


    <!-- Modal for adding and editing product -->
    <div class="modal" tabindex="-1" id="AddEditModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="productForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="productId">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="product_image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="product_image" name="product_image">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
    <script>
        $(document).ready(function() {

            // Set CSRF token for all AJAX requests
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('#DataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('products.index') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'price', name: 'price' },
                    { data: 'description', name: 'description' },
                    { data: 'product_image', name: 'product_image'},
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            // Add Product button click event
            $('#add-product-btn').click(function() {

                alert('hrll');
                $('#modalTitle').text('Add Product');
                $('#productForm')[0].reset();
                $('#productId').val('');
                $('#productModal').modal('show');
            });

            // Open Edit Product Modal
            $(document).on('click', '.edit-btn', function() {
                var id = $(this).data('id');
                $.get("{{ route('products.edit', ':id') }}".replace(':id', id), function(data) {
                    $('#modalTitle').text('Edit Product');
                    $('#productId').val(data.id);
                    $('#name').val(data.name);
                    $('#price').val(data.price);
                    $('#description').val(data.description);
                    $('#AddEditModal').modal('show');
                  });
    });

                    // Save Product (Add or Update)
            $('#productForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
           
                var id = $('#productId').val();
                var url = id ? "{{ route('products.update', ':id') }}".replace(':id', id) : "{{ route('products.store') }}";
                var type = 'POST';
                
                if(id){
                         formData.append('_method', 'PUT'); // Append the CSRF token manually

                }

                $.ajax({
                    url: url,
                    type: type,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire('Success', response.success, 'success');
                        $('#AddEditModal').modal('hide');
                        table.ajax.reload();
                    },
                    error: function(error) {
                        Swal.fire('Error', 'Something went wrong!', 'error');
                    }
                });
            });

            

            // Delete Product
    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'This product will be deleted!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('products.destroy', ':id') }}".replace(':id', id),
                    type: 'DELETE',
                    success: function(response) {
                        Swal.fire('Deleted!', response.success, 'success');
                        table.ajax.reload();
                    }
                });
            }
        });
    });
});
    </script>
@endsection
