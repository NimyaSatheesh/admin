@extends('admin.layouts.app')

@section('content')

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">

                <div class="d-flex flex-wrap justify-content-between gap-3">
                    @hasanyrole('admin|super-admin')
                    <div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBlogModal">
                            <i class="bx bx-plus me-1"></i> Create Blog
                        </button>
                    </div>
                    @endhasanyrole
                </div>

            </div>

            <div>
                <div class="table-responsive table-centered">
                    <table class="table text-nowrap mb-0" id="blogTable">
                        <thead class="bg-light bg-opacity-50">
                            <tr>
                                <th class="border-0 py-2">Tittle</th>
                                <th class="border-0 py-2">Description</th>
                                <th class="border-0 py-2">Image</th>
                                <th class="border-0 py-2">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <!-- DataTable loads data here -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.components.modal-create-blog') 
@include('admin.components.modal-edit-blog') 
@endsection


@section('scripts')

<script>
    $(document).ready(function() {
    
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });
        let table = $('#blogTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.blog.index') }}",
            columns: [
                { data: 'title' },
                { data: 'description' },
                { data: 'image', orderable:false, searchable:false },
                { 
                    data: 'id',
                    orderable:false,
                    searchable:false,
                    render: function(id, type, row){
                        return `
                            <button class="btn btn-warning btn-sm editBtn"
                                data-id="${id}" 
                                data-title="${row.title}"
                                data-description="${row.description}"
                                data-image="${row.image}
                                Edit
                            </button>

                            <button class="btn btn-danger btn-sm deleteBtn" data-id="${id}">
                                Delete
                            </button>
                        `;
                    }
                }
            ]
        });
        
        // CREATE BLOG
        $('#createBlogForm').on('submit', function(e){
            e.preventDefault();
        
            let formData = new FormData(this);
        
            $.ajax({
                url: "{{ route('admin.blog.store') }}",
                type: "POST",
                data: formData,
                cache:false,
                contentType:false,
                processData:false,
                success: function(res){
                    $('#createBlogModal').modal('hide');
                    $('#createBlogForm')[0].reset();
                    table.ajax.reload();
                    toastr.success(res.message);
                }
            });     
        });

        // OPEN EDIT MODAL
        $(document).on('click', '.editBtn', function() {
            let id = $(this).data('id');
            let title = $(this).data('title');
            let description = $(this).data('description');
            let image = $(this).data('image');

            $('#edit_id').val(id);
            $('#edit_title').val(title);
            $('#edit_description').val(description);

            if(image){
                $('#edit_image_preview').attr('src', '/uploads/blogs/' + image).show();
            }else{
                $('#edit_image_preview').hide();
            }

            $('#editBlogModal').modal('show');
        });

        // UPDATE BLOG AJAX
        $('#updateBlogForm').submit(function(e){
            e.preventDefault();

            let id = $('#edit_id').val();
            let formData = new FormData(this);
            formData.append('_method', 'PUT');

            $.ajax({
                url: "/admin/blog/" + id,
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(res){
                    $('#editBlogModal').modal('hide');
                    $('#updateBlogForm')[0].reset();
                    table.ajax.reload(null, false);
                    toastr.success("Blog Updated Successfully");
                },
                error: function(err){
                    console.log(err.responseText);
                    toastr.error("Update Failed");
                }
            });
        });
        
        // DELETE BLOG
        $(document).on('click', '.deleteBtn', function(){
            let id = $(this).data('id');
        
            if(confirm("Delete this blog?")){
                $.ajax({
                    url: "/admin/blog/" + id,
                    type: "DELETE",
                    data: {_token: "{{ csrf_token() }}"},
                    success: function(res){
                        table.ajax.reload();
                        toastr.success(res.message);
                    }
                });
            }
        });
    });
</script>
@endsection    