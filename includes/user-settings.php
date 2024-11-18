<body>
    <div class="profile-section">
        <div class="make-row">
            <div class="profile-contents">
                <div class="section-contents">
                    <h5> Profile Photo: </h5>
                    <div class="settings-profile-photo">
                        <img src="<?=$userImg?>" alt="userImage">
                    </div>
                </div>
                <button class="settings-button" id="edit-profile-photo" data-bs-toggle="modal" data-bs-target="#edit-profile-photo-modal">Edit Profile Photo</button>
            </div>
            <div class="make-column">
                <div class="profile-contents">
                    <div class="section-contents">
                        <h5> My First Name: </h5>
                        <h6> <?php echo $_SESSION['current_user_first_name']; ?> <h6>
                    </div>
                    <button class="settings-button" id="edit-first-name" data-bs-toggle="modal" data-bs-target="#edit-first-name-modal">Edit First Name</button>
                </div>
                <div class="profile-contents">
                    <div class="section-contents">
                        <h5> My Last Name: </h5>
                        <h6> <?php echo $_SESSION['current_user_last_name']; ?> <h6>
                    </div>
                    <button class="settings-button" id="edit-last-name" data-bs-toggle="modal" data-bs-target="#edit-last-name-modal">Edit Last Name</button>
                </div>
            </div>
        </div>
        <div class="profile-password">
            <h5> Password: </h5>
            <button class="settings-button" id="edit-password" data-bs-toggle="modal" data-bs-target="#edit-password-modal">Change Password</button>
        </div>
    </div>

    <script>
        // Get elements
        const editProfilePhotoButton = document.getElementById('edit-profile-photo');
        const editFirstNameButton = document.getElementById('edit-first-name');
        const editLastNameButton = document.getElementById('edit-last-name');
        const editPasswordButton = document.getElementById('edit-password');

        editProfilePhotoButton.addEventListener('click', () => {
            editProfilePhotoModal.style.display = 'block';
        });
        
        editFirstNameButton.addEventListener('click', () => {
            editFirstNameModal.style.display = 'block';
        });
        
        editLastNameButton.addEventListener('click', () => {
            editLastNameModal.style.display = 'block';
        });

        editPasswordButton.addEventListener('click', () => {
            editPasswordModal.style.display = 'block';
        });

    </script>
</body>

