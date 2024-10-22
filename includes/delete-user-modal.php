<!DOCTYPE html>
<html>
<body>

<div id="deleteUserModal" class="modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteUserForm">
                <div class="modal-header">
                    <h3>Delete User</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Email</label>
                        <div id="deleteEmail" class="form-control-plaintext">
                            <!-- This will be populated with the email value -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Would you like to delete this user?</label>
                        <select type="deleteUser" name="deleteUser" id="deleteUser" class="form-control" required>
                            <option value="no">No</option>
                            <option value="yes">Yes</option>
                        </select><br>
                    </div>
                    <div class="form-group">
                        <label>Would you like to delete all of their associated blogs?</label>
                        <select type="deleteUserBlogs" name="deleteUserBlogs" id="deleteUserBlogs" class="form-control" required>
                            <option value="no">No</option>
                            <option value="yes">Yes</option>
                        </select><br>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="saveDeleteUserChanges()">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function saveDeleteUserChanges() {
    const formData = {
        email: document.getElementById('deleteEmail').innerText,
        deleteUser: document.getElementById('deleteUser').value,
        deleteUserBlogs: document.getElementById('deleteUserBlogs').value
    };

    // Exit if both deleteUser is "no"
    if (formData.deleteUser === 'no') {
        $('#deleteUserModal').modal('hide');
        return;
    }

    // AJAX request
    fetch('actions/delete-user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('User deleted successfully!');
            location.reload();
        } else {
            alert('Error deleting user: ' + data.message);
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
</script>

</body>
</html>