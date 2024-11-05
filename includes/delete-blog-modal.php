<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Modal</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div id="deleteBlogModal" class="modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteBlogForm">
                <div class="modal-header">
                    <h3>Delete Blog</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Blog ID</label>
                        <div id="deleteBlogId" class="form-control-plaintext">
                            <!-- This will be populated with the blog_id value -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Creator Email</label>
                        <div id="deleteCreatorEmail" class="form-control-plaintext">
                            <!-- This will be populated with the creator_email value -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <div id="deleteTitle" class="form-control-plaintext">
                            <!-- This will be populated with the title value -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <div id="deleteDescription" class="form-control-plaintext">
                            <!-- This will be populated with the description value -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Would you like to delete this blog?</label>
                        <select type="deleteBlog" name="deleteBlog" id="deleteBlog" class="form-control" required>
                            <option value="no">No</option>
                            <option value="yes">Yes</option>
                        </select><br>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="saveDeleteBlogChanges()">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function saveDeleteBlogChanges() {
    const formData = {
        blogId: document.getElementById('deleteBlogId').innerText,
        creatorEmail: document.getElementById('deleteCreatorEmail').innerText,
        title: document.getElementById('deleteTitle').innerText,
        description: document.getElementById('deleteDescription').innerText,
        deleteBlog: document.getElementById('deleteBlog').value,
    };

    // Exit if both deleteUser is "no"
    if (formData.deleteBlog === 'no') {
        $('#deleteBlogModal').modal('hide');
        return;
    }

    // AJAX request
    fetch('actions/delete-blog.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Blog deleted successfully!');
            location.reload();
        } else {
            alert('Error deleting blog: ' + data.message);
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