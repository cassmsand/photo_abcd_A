<div class="modal fade" id="new-book-modal">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content" id="abook-modal-content">
            <form id="login-form">
                <div class="modal-header">
                    <h3 id='abook-modal-title'>Create New Book</h3>
                </div>

                <div class="modal-body" id='new-book-modal-body'>

                    <div class="form-group">
                        <label>Book Title</label>
                        <input type="text" name="title" class="form-control" id="newbook-title" required="">
                    </div>

                </div>

                <div class="modal-footer">

                    <div class="row" id="button-container">

                        <div class="col">
                            <button type="button" class="btn btn-primary" id='newbook-confirm-button'
                                data-dismiss="modal">Confirm</button>
                        </div>

                        <div class="col">
                            <button type="button" class="btn btn-danger" id='newbook-cancel-button'
                                data-dismiss="modal">Cancel</button>
                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>
</div>