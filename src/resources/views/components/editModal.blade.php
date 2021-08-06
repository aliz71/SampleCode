<div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBookModalLabel">Edit book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" id="edit-book-id">
                    <div class="mb-3">
                        <label for="edit-book-title" class="col-form-label">Title:</label>
                        <input type="text" class="form-control" id="edit-book-title">
                    </div>
                    <div class="mb-3">
                        <label for="edit-book-author" class="col-form-label">Author:</label>
                        <input type="text" class="form-control" id="edit-book-author">
                    </div>
                    <div class="my-2">
                        <div class="edit-error-message"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-success" onclick="updateBook()">Edit</button>
            </div>
        </div>
    </div>
</div>
