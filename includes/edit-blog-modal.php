<!DOCTYPE html>
<html>
<body>

<div id="editBlogModal" class="modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editBlogForm">
                <div class="modal-header">
                    <h3>Edit Blog</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Blog ID</label>
                        <div id="editBlogId" class="form-control-plaintext">
                            <!-- This will be populated with the blog_id value -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Creator Email</label>
                        <div id="editCreatorEmail" class="form-control-plaintext">
                            <!-- This will be populated with the creator_email value -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="title" name="title" id="editTitle" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="description" name="description" id="editDescription" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Event Date</label>
                        <input type="date" name="eventDate" id="editEventDate" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Creation Date</label>
                        <input type="date" name="creationDate" id="editCreationDate" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Modification Date</label>
                        <input type="date" name="modificationDate" id="editModificationDate" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="privacyFilter">Privacy Filter:</label>
                        <select type="privacyFilter" name="privacyFilter" id="editPrivacyFilter" class="form-control" required>
                            <option value="public">Public</option>
                            <option value="private">Private</option>
                        </select><br>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-dismiss="modal">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>