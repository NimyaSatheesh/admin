<div class="modal fade" id="createFaqsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <form action="{{ route('admin.faqs.store') }}" id="createForm" method="POST">
            @csrf

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Create FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Question</label>
                        <input type="text" name="question" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Answer</label>
                        <textarea name="answer" class="form-control" rows="4" required></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>

            </div>

        </form>

    </div>
</div>
