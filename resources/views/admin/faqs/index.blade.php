@extends('admin.layouts.app')

@section('content')

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">

                <div class="d-flex flex-wrap justify-content-between gap-3">
                    @hasanyrole('admin|super-admin')
                    <div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createFaqsModal">
                            <i class="bx bx-plus me-1"></i> Create FAQ
                        </button>
                    </div>
                    @endhasanyrole
                </div>

            </div>

            <div>
                <div class="table-responsive table-centered">
                    <table class="table text-nowrap mb-0" id="faqTable">
                        <thead class="bg-light bg-opacity-50">
                            <tr>
                                <th class="border-0 py-2">Question</th>
                                <th class="border-0 py-2">Answer</th>
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

@include('admin.components.modal-create-faq')
@include('admin.components.modal-edit-faq')
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
    
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });
    
        let table = $('#faqTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.faqs.index') }}",
            columns: [
                { data: 'question', name: 'question' },
                { data: 'answer', name: 'answer' },
                { 
                    data: 'id', 
                    orderable: false, 
                    searchable: false,
                    render: function(id, type, row) {
                        return `
                            <button class="btn btn-warning btn-sm editBtn"
                                data-id="${id}"
                                data-question="${row.question}"
                                data-answer="${row.answer}"> Edit
                            </button>
    
                            <button class="btn btn-danger btn-sm deleteBtn"
                                data-id="${id}">Delete
                            </button>`;
                    }
                }
            ]
        });
    
        // Create FAQ
        $('#createForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.faqs.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(res) {
                    if (res.status === 200) {
                        $('#createFaqsModal').modal('hide');   // hide modal
                        $('#createForm')[0].reset();           // reset form
                        table.ajax.reload(null, false);        // reload datatable
                        toastr.success(res.message);           // toast
                    }
                },
                error: function() {
                    toastr.error("Something went wrong!");
                }
            });
        });

        // Open Edit Modal
        $(document).on("click", ".editBtn", function() {
            $("#edit_id").val($(this).data("id"));
            $("#edit_question").val($(this).data("question"));
            $("#edit_answer").val($(this).data("answer"));
    
            $("#editFaqModal").modal('show');
        });
    
        // Update FAQ
        $('#editFaqForm').submit(function(e) {
            e.preventDefault();
    
            let id = $('#edit_id').val();
    
            $.ajax({
                url: "/admin/faqs/" + id,
                type: "POST",
                data: $(this).serialize(),
                success: function(res) {
                    $("#editFaqModal").modal('hide');
                    table.ajax.reload();
                    toastr.success("FAQ Updated");
                }
            });
        });
    
        // Delete FAQ
        $(document).on("click", ".deleteBtn", function() {
    
            if(!confirm("Delete this FAQ?")) return;
    
            let id = $(this).data("id");
    
            $.ajax({
                url: "/admin/faqs/" + id,
                type: "POST",
                data: {
                    _method: "DELETE",
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    table.ajax.reload();
                    toastr.success("FAQ Deleted");
                }
            });
        });
    
    });
</script>
    

@endsection
