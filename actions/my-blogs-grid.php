<?php
$host = $_SERVER['HTTP_HOST'];
$is_localhost = ($host == 'localhost' || $host == '127.0.0.1');

// If the server is localhost, include 'photo_abcd_A' in the base URL
$base_url = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $host . ($is_localhost ? '/photo_abcd_A/' : '/');
$blankIcon = $base_url . 'images/blankicon.jpg';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="css/my-blogs-grid.css" rel="stylesheet" type="text/css">
</head>

<body>
    <section>
        <div class="container" id="main-content">

            <!-- Search Form -->
            <div id="searchContainer">
                <input type="text" id="searchInput" placeholder="Search by title...">
                <label for="startDate">Sort by creation date:</label>
                <input type="date" id="startDate" placeholder="Start Date" style="margin-left: 5px;">
                <input type="date" id="endDate" placeholder="End Date">
                <button id="searchButton">Search</button>
            </div>

            <div id="sortContainer">
                <label for="sortOrder">Display:</label>
                <select id="sortOrder">
                    <option value="asc">Alphabetically (A-Z)</option>
                    <option value="desc">Alphabetically (Z-A)</option>
                </select>
            </div>

            <!-- Posts Container for Grid -->
            <div id="postsContainer" class="grid-container"></div>

            <!-- Edit Modal -->
            <!-- Edit Modal -->
            <!-- Edit Modal -->
            <div id="editModal" class="modal" style="display: none;"> <!-- Initially hidden -->
                <div class="modal-content">
                    <span id="closeModal" style="cursor: pointer;">&times;</span>
                    <h2>Edit Blog Post</h2>
                    
                    <input type="hidden" id="blogId"> <!-- Hidden input for blog ID -->
                    
                    <label for="title">Title:</label>
                    <input type="text" id="editTitle" required placeholder="Enter blog title"><br>

                    <label for="description">Description:</label>
                    <textarea id="editDescription" required placeholder="Enter blog description"></textarea><br>

                    <label for="privacyFilter">Privacy Filter:</label>
                    <select id="privacyFilter">
                        <option value="public">Public</option>
                        <option value="private">Private</option>
                    </select><br>

                    <input type="hidden" id="creatorEmail"> <!-- Hidden input for creator email -->
                    <input type="hidden" id="eventDate"> <!-- Hidden input for event date -->
                    <input type="hidden" id="creationDate"> <!-- Hidden input for creation date -->

                    <button id="saveButton">Save</button>
                </div>
            </div>

            <script>
                const baseUrl = '<?php echo $base_url; ?>';

                const fetchBlogs = (actionType, title = '', startDate = '', endDate = '', sortOrder = 'asc') => {
                    fetch(`actions/${actionType}.php?title=${title}&start_date=${startDate}&end_date=${endDate}&sort_order=${sortOrder}`)
                        .then(response => response.json())
                        .then(blogPosts => {
                            const postsContainer = document.getElementById('postsContainer');
                            postsContainer.innerHTML = ''; // Clear previous posts

                            if (blogPosts.message) {
                                const noResultsMessage = document.createElement('p');
                                noResultsMessage.textContent = blogPosts.message; // "No matching blogs found"
                                noResultsMessage.className = 'no-results-message';
                                postsContainer.appendChild(noResultsMessage);
                                return;
                            }

                            blogPosts.forEach(post => {
                                const blogContainer = document.createElement('div');
                                blogContainer.className = 'blog-container';

                                const blogUserContainer = document.createElement('div');
                                blogUserContainer.className = 'blog-user-container';

                                const userImage = document.createElement('img');
                                userImage.src = baseUrl + 'images/blankicon.jpg';
                                userImage.alt = 'User Image';
                                userImage.className = 'blog-user-image';

                                const username = document.createElement('p');
                                username.className = 'blog-username';
                                username.textContent = post.creator_email;

                                const creationDate = document.createElement('p');
                                creationDate.className = 'blog-creation-date';
                                const creationDateObject = new Date(post.creation_date);
                                creationDate.textContent = creationDateObject.toLocaleDateString() + ' ' + creationDateObject.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                                const blogTitle = document.createElement('h2');
                                blogTitle.className = 'blog-title';
                                blogTitle.textContent = post.title;

                                const img = document.createElement('img');
                                img.src = baseUrl + `images/${post.blog_id}/${post.blog_id}.jpg`;
                                img.alt = 'Blog Image';
                                img.className = 'blog-photo';

                                const blogDescription = document.createElement('p');
                                blogDescription.className = 'blog-description';
                                blogDescription.textContent = post.description;

                                // Create dropdown for edit/delete options
                                const optionsDropdown = document.createElement('div');
                                optionsDropdown.className = 'dropdown';

                                const optionsButton = document.createElement('button');
                                optionsButton.className = 'options-button';
                                optionsButton.innerHTML = '▼'; // Down caret

                                const dropdownContent = document.createElement('div');
                                dropdownContent.className = 'dropdown-content';
                                
                                const editLink = document.createElement('a');
                                editLink.href = '#';
                                editLink.textContent = 'Edit';
                                editLink.onclick = (e) => {
                                    e.preventDefault();
                                    openEditModal(post); // Open the modal with the current post data
                                };

                                const deleteLink = document.createElement('a');
                                deleteLink.href = '#'; // Link to delete functionality
                                deleteLink.textContent = 'Delete';
                                deleteLink.onclick = (e) => {
                                    e.preventDefault();
                                    // Confirmation dialog
                                    if (confirm('Are you sure you want to delete this blog post?')) {
                                        deleteBlog(post.blog_id, post.creator_email, post.title, post.description);
                                    }
                                };

                                dropdownContent.appendChild(editLink);
                                dropdownContent.appendChild(deleteLink);
                                optionsDropdown.appendChild(optionsButton);
                                optionsDropdown.appendChild(dropdownContent);

                                // Append elements to blogContainer
                                blogUserContainer.appendChild(userImage);
                                blogUserContainer.appendChild(username);
                                blogUserContainer.appendChild(creationDate);
                                blogContainer.appendChild(blogUserContainer);
                                blogContainer.appendChild(blogTitle);
                                blogContainer.appendChild(img);
                                blogContainer.appendChild(blogDescription);
                                // blogContainer.appendChild(eventDate); // Removed event date
                                blogContainer.appendChild(optionsDropdown); // Add dropdown to blogContainer
                                postsContainer.appendChild(blogContainer);
                            });
                        })
                        .catch(error => console.error('Error fetching blog posts:', error));
                };


                fetchBlogs('get-my-blogs');
                

                document.getElementById('searchButton').addEventListener('click', () => {
                    const title = document.getElementById('searchInput').value;
                    const startDate = document.getElementById('startDate').value;
                    const endDate = document.getElementById('endDate').value;
                    const sortOrder = document.getElementById('sortOrder').value;
                    fetchBlogs('get-my-blogs', title, startDate, endDate, sortOrder);
                });

                document.getElementById('searchInput').addEventListener('keydown', (event) => {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        const title = document.getElementById('searchInput').value;
                        const startDate = document.getElementById('startDate').value;
                        const endDate = document.getElementById('endDate').value;
                        const sortOrder = document.getElementById('sortOrder').value;
                        fetchBlogs('get-my-blogs', title, startDate, endDate, sortOrder);
                    }
                });

                document.getElementById('sortOrder').addEventListener('change', () => {
                    const title = document.getElementById('searchInput').value;
                    const startDate = document.getElementById('startDate').value;
                    const endDate = document.getElementById('endDate').value;
                    const sortOrder = document.getElementById('sortOrder').value;
                    fetchBlogs('get-my-blogs', title, startDate, endDate, sortOrder);
                });

                document.addEventListener('DOMContentLoaded', () => {
                    // Toggle the dropdown menu visibility when the button is clicked
                    document.addEventListener('click', function (event) {
                        // Get all dropdowns
                        const dropdowns = document.querySelectorAll('.dropdown-content');
                        
                        // Close all dropdowns if the click is outside
                        dropdowns.forEach(dropdown => {
                            if (!dropdown.parentElement.contains(event.target)) {
                                dropdown.style.display = 'none';
                            }
                        });

                        // If the clicked element is the dropdown button, toggle its dropdown
                        const optionsButton = event.target.closest('.options-button');
                        if (optionsButton) {
                            const dropdownContent = optionsButton.nextElementSibling;
                            dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
                        }
                    });
                });

                const openEditModal = (post) => {
                    document.getElementById('editModal').style.display = 'block';

                    console.log("Opening modal for post:", post); // Debug log

                    // Populate the fields with the existing data from the post object
                    document.getElementById('blogId').value = post.blog_id; // Should be defined
                    document.getElementById("editTitle").value = post.title; // Auto-fill title with current title
                    document.getElementById("editDescription").value = post.description; // Auto-fill description with current description
                    document.getElementById('privacyFilter').value = post.privacy_filter; // Set privacy filter value

                    document.getElementById('creatorEmail').value = post.creator_email; // Populate creator email
                    document.getElementById('eventDate').value = post.event_date; // Populate event date
                    document.getElementById('creationDate').value = post.creation_date; // Populate creation date
                    
                };



                document.getElementById('closeModal').onclick = () => {
                        document.getElementById('editModal').style.display = 'none';
                    };

                
                document.getElementById('saveButton').onclick = () => {
                    event.preventDefault();

                    const blogId = document.getElementById('blogId').value;
                    const title = document.getElementById('editTitle').value;
                    const description = document.getElementById('editDescription').value;
                    const privacyFilter = document.getElementById('privacyFilter').value;
                    const creatorEmail = document.getElementById('creatorEmail').value;
                    const eventDate = document.getElementById('eventDate').value;
                    const creationDate = document.getElementById('creationDate').value;
                    
                    /*
                    console.log('Saving the following data:');
                    console.log('Blog ID:', blogId);
                    console.log('Title:', title);
                    console.log('Description:', description);
                    console.log('Privacy Filter:', privacyFilter);
                    console.log('Creator Email:', creatorEmail);
                    console.log('Event Date:', eventDate);
                    console.log('Creation Date:', creationDate);
                    */
                    // Ensure we are capturing the current values from the modal
                    if (title.trim() === '' || description.trim() === '') {
                        alert('Title and Description cannot be empty!');
                        return; // Exit if validation fails
                    }

                    // Save changes via AJAX
                    fetch(`actions/update-blog.php`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ blogId, title, description, privacyFilter, creatorEmail, eventDate, creationDate }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log("Response from server:", data); // Debug log
                        if (data.success) {
                            alert('Blog post updated successfully!');
                            // Reload the posts to reflect changes
                            fetchBlogs('get-my-blogs');
                            document.getElementById('editModal').style.display = 'none'; // Close modal
                        } else {
                            alert('Failed to update blog post: ' + data.message);
                        }
                    })
                    .catch(error => console.error('Error updating blog post:', error));
                };

                
                const deleteBlog = (blogId, creatorEmail, title, description) => {
                    fetch(`actions/delete-blog.php`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            blogId,
                            creatorEmail,
                            title,
                            description,
                            deleteBlog: 'yes', // Flag to indicate deletion
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log("Response from server:", data); // Debug log
                        if (data.success) {
                            alert('Blog post deleted successfully!');
                            // Reload the posts to reflect changes
                            fetchBlogs('get-my-blogs');
                        } else {
                            alert('Failed to delete blog post: ' + data.message);
                        }
                    })
                    .catch(error => console.error('Error deleting blog post:', error));
                };


            </script>
        </div>
    </section>
</body>
</html>


