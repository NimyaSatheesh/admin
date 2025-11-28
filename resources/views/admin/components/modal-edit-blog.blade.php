<div class="modal fade" id="editBlogModal">
    <div class="modal-dialog">
        <form id="updateBlogForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" id="edit_id" name="id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit BLOG</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <label>Title</label>
                    <input type="text" id="edit_title" name="title" class="form-control">

                    <label>Description</label>
                    <textarea id="edit_description" name="description" class="form-control"></textarea>

                    <label>Image (optional)</label>
                    <input type="file" id="edit_image" name="image" class="form-control">

                    <img id="edit_image_preview" src="" width="100" class="mt-2" style="display:none;">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary updateBtn">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
