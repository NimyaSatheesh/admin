<div class="modal fade" id="editFaqModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="editFaqForm">
            @csrf
            @method('PUT')

            <input type="hidden" id="edit_id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <label>Question</label>
                    <input type="text" id="edit_question" name="question" class="form-control">

                    <label class="mt-2">Answer</label>
                    <textarea id="edit_answer" name="answer" class="form-control"></textarea>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
            </div>

        </form>
    </div>
</div>
