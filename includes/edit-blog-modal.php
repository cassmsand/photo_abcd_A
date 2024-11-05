<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Modal</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div id="editBlogModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editBlogForm">
                <div class="modal-header">
                    <h3>Edit Blog</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                        <input type="text" name="title" id="editTitle" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" name="description" id="editDescription" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Event Date</label>
                        <input type="datetime-local" name="eventDate" id="editEventDate" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Creation Date</label>
                        <input type="datetime-local" name="creationDate" id="editCreationDate" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Modification Date</label>
                        <input type="datetime-local" name="modificationDate" id="editModificationDate" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="privacyFilter">Privacy Filter:</label>
                        <select name="privacyFilter" id="editPrivacyFilter" class="form-control" required>
                            <option value="public">Public</option>
                            <option value="private">Private</option>
                        </select><br>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="saveBlogChanges()">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function saveBlogChanges() {
    const formData = {
        blogId: document.getElementById('editBlogId').innerText,
        creatorEmail: document.getElementById('editCreatorEmail').innerText,
        title: document.getElementById('editTitle').value,
        description: document.getElementById('editDescription').value,
        eventDate: document.getElementById('editEventDate').value,
        creationDate: document.getElementById('editCreationDate').value,
        modificationDate: document.getElementById('editModificationDate').value,
        privacyFilter: document.getElementById('editPrivacyFilter').value
    };

    // AJAX request
    fetch('actions/update-blog.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Blog updated successfully!');
            location.reload();
        } else {
            alert('Error updating blog: ' + data.message);
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>
</html>
