<?php
$host = $_SERVER['HTTP_HOST'];
$is_localhost = ($host == 'localhost' || $host == '127.0.0.1');

// If the server is localhost, include 'photo_abcd_A' in the base URL
$base_url = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $host . ($is_localhost ? '/photo_abcd_A' : '');
$base_url = rtrim($base_url, '/') . '/'; // Ensure single trailing slash
$blankIcon = $base_url . 'images/blankicon.jpg';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="css/blogs.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/blog-grid.css"> <!-- Include the CSS for photo-only view -->
    <title>Blog Page</title>
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
                <option value="date_asc">Event Date (Oldest to Newest)</option>
                <option value="date_des">Event Date (Newest to Oldest)</option>
            </select>
        </div>

        <!-- View Option Container -->
        <div id="viewOptionContainer">
            <label for="viewOptions">View:</label>
            <select id="viewOptions">
                <option value="traditional">Traditional</option>
                <option value="photoOnly">Photo Only</option>
            </select>
        </div>

        <!-- Posts Container -->
        <div id="postsContainer"></div>

        <!-- Modal for Photo Only View -->
        <div class="modal fade" id="card-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 id='card-modal-title'></h3>
                    </div>
                    <div class="modal-body">
                        <img src="" alt="" id='card-modal-img' class="img-fluid">
                        <p class="lead" id='card-modal-desc'></p>
                    </div>
                    <div class="modal-footer">
                        <p id='card-modal-email'></p>
                        <ul class="pagination" id='card-modal-img-nav'>
                            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                        <button type="button" class="btn btn-primary">Edit</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript Section -->
        <script>
            // Assign PHP variables to JavaScript variables
            var baseUrl = '<?php echo $base_url; ?>';
            var blankIcon = '<?php echo $blankIcon; ?>';
            let actionType1 = 'get-blogs'; // Declare actionType once

            // Ensure baseUrl ends with a single slash
            if (!baseUrl.endsWith('/')) {
                baseUrl += '/';
            }

            console.log('baseUrl:', baseUrl); // Debugging: Check baseUrl value

            // Event listener for view options change
            document.getElementById('viewOptions').addEventListener('change', function () {
                const viewOption = this.value;
                if (viewOption === 'photoOnly') {
                    loadPhotoOnlyView();
                } else {
                    loadTraditionalView();
                }
            });

            // Function to load traditional view
            function loadTraditionalView() {
                const title = document.getElementById('searchInput').value;
                const startDate = document.getElementById('startDate').value;
                const endDate = document.getElementById('endDate').value;
                const sortOrder = document.getElementById('sortOrder').value;
                const viewOptions = 'traditional';
                fetchBlogs(title, startDate, endDate, sortOrder, viewOptions);
            }

            // Function to load photo-only view
            function loadPhotoOnlyView() {
                const title = document.getElementById('searchInput').value;
                const startDate = document.getElementById('startDate').value;
                const endDate = document.getElementById('endDate').value;
                const sortOrder = document.getElementById('sortOrder').value;
                const viewOptions = 'photoOnly';
                fetchBlogs(title, startDate, endDate, sortOrder, viewOptions);
            }

            // Function to fetch blog posts with sorting and view options
            const fetchBlogs = (title = '', startDate = '', endDate = '', sortOrder = 'asc', viewOptions = 'traditional') => {
                fetch(`actions/${actionType1}.php?title=${encodeURIComponent(title)}&start_date=${startDate}&end_date=${endDate}&sort_order=${sortOrder}&view_options=${viewOptions}`)
                    .then(response => response.json())
                    .then(blogPosts => {
                        const postsContainer = document.getElementById('postsContainer');
                        postsContainer.innerHTML = ''; // Clear previous posts

                        if (blogPosts.message) {
                            // Display a no-results message
                            const noResultsMessage = document.createElement('p');
                            noResultsMessage.textContent = blogPosts.message;
                            noResultsMessage.className = 'no-results-message';
                            postsContainer.appendChild(noResultsMessage);
                            return;
                        }

                        if (viewOptions === 'photoOnly') {
                            displayPhotoOnlyView(blogPosts, postsContainer, sortOrder);
                        } else {
                            displayTraditionalView(blogPosts, postsContainer);
                        }

                    })
                    .catch(error => console.error('Error fetching blog posts:', error));
            };

            // Function to display traditional view
            function displayTraditionalView(blogPosts, postsContainer) {
                blogPosts.forEach(post => {
                    const blogContainer = document.createElement('div');
                    blogContainer.className = 'blog-container';

                    const blogUserContainer = document.createElement('div');
                    blogUserContainer.className = 'blog-user-container';

                    const userImage = document.createElement('img');
                    userImage.src = '<?php echo $blankIcon; ?>';
                    userImage.alt = 'User Image';
                    userImage.className = 'blog-user-image';

                    const username = document.createElement('p');
                    username.className = 'blog-username';
                    username.textContent = post.creator_email;

                    function formatCreationDate(dateString) {
                        const date = new Date(dateString);
                        const month = String(date.getMonth() + 1).padStart(2, '0');
                        const day = String(date.getDate()).padStart(2, '0');
                        const year = date.getFullYear();
                        return `${month}/${day}/${year}`;
                    }

                    function formatCreationTime(dateString) {
                        const date = new Date(dateString);
                        let hours = date.getHours();
                        const minutes = String(date.getMinutes()).padStart(2, '0');
                        const ampm = hours >= 12 ? 'PM' : 'AM';

                        // Convert to 12-hour format
                        hours = hours % 12;
                        hours = hours ? String(hours).padStart(2, '0') : '12';

                        return `${hours}:${minutes} ${ampm}`;
                    }

                    const creationDate = document.createElement('p');
                    creationDate.className = 'blog-creation-date';
                    creationDate.textContent = '◦ ' + formatCreationDate(post.creation_date) + ' ◦ ' + formatCreationTime(post.creation_date);

                    const blogTitle = document.createElement('h2');
                    blogTitle.className = 'blog-title';
                    blogTitle.textContent = post.title;

                    const imageContainer = document.createElement('div');
                    imageContainer.className = 'image-container';

                    const leftArrow = document.createElement('span');
                    leftArrow.className = 'left-arrow';
                    leftArrow.innerHTML = '&#9664;';
                    leftArrow.style.display = 'none';

                    const rightArrow = document.createElement('span');
                    rightArrow.className = 'right-arrow';
                    rightArrow.innerHTML = '&#9654;';
                    rightArrow.style.display = 'none';

                    const img = document.createElement('img');
                    img.src = '<?php echo $base_url; ?>images/' + post.blog_id + '/' + post.blog_id + '.jpg';
                    img.alt = 'Blog Image';
                    img.className = 'blog-photo';

                    fetch(`actions/count-files.php?blog_id=${post.blog_id}`)
                        .then(response => response.json())
                        .then(data => {
                            const fileCount = data.fileCount;
                            if (fileCount > 1) {
                                leftArrow.style.display = 'inline';
                                rightArrow.style.display = 'inline';
                            }

                            let currentImageIndex = 0;

                            // Left arrow click event
                            leftArrow.addEventListener('click', () => {
                                currentImageIndex--;
                                if (currentImageIndex < 0) {
                                    currentImageIndex = fileCount - 1;
                                    img.src = '<?php echo $base_url; ?>images/' + post.blog_id + '/' + post.blog_id + '_' + currentImageIndex + '.jpg';
                                } else if (currentImageIndex == 0) {
                                    img.src = '<?php echo $base_url; ?>images/' + post.blog_id + '/' + post.blog_id + '.jpg';
                                } else {
                                    img.src = '<?php echo $base_url; ?>images/' + post.blog_id + '/' + post.blog_id + '_' + currentImageIndex + '.jpg';
                                }
                            });

                            // Right arrow click event
                            rightArrow.addEventListener('click', () => {
                                currentImageIndex++;
                                if (currentImageIndex == fileCount) {
                                    currentImageIndex = 0; // Reset to zero if it reaches fileCount
                                    img.src = '<?php echo $base_url; ?>images/' + post.blog_id + '/' + post.blog_id + '.jpg';
                                } else {
                                    img.src = '<?php echo $base_url; ?>images/' + post.blog_id + '/' + post.blog_id + '_' + currentImageIndex + '.jpg';
                                }
                            });
                        })
                        .catch(error => console.error('Error fetching file count:', error));

                    const blogDescription = document.createElement('p');
                    blogDescription.className = 'blog-description';
                    blogDescription.textContent = post.description;

                    const blogSeparator = document.createElement('hr');
                    blogSeparator.className = 'blog-separator';

                    blogUserContainer.appendChild(userImage);
                    blogUserContainer.appendChild(username);
                    blogUserContainer.appendChild(creationDate);
                    imageContainer.appendChild(leftArrow);
                    imageContainer.appendChild(img);
                    imageContainer.appendChild(rightArrow);
                    blogContainer.appendChild(blogUserContainer);
                    blogContainer.appendChild(blogTitle);
                    blogContainer.appendChild(imageContainer);
                    blogContainer.appendChild(blogDescription);

                    postsContainer.appendChild(blogContainer);
                    postsContainer.appendChild(blogSeparator);
                });
            }

            // Function to display photo-only view
            function displayPhotoOnlyView(blogPosts, postsContainer, sortOrder) {
                const row = document.createElement('div');
                row.className = 'row';

                // Sort blogs based on title
                blogPosts.sort((a, b) => {
                    const titleA = a.title.toLowerCase();
                    const titleB = b.title.toLowerCase();
                    if (sortOrder === 'asc') {
                        return titleA.localeCompare(titleB);
                    } else {
                        return titleB.localeCompare(titleA);
                    }
                });

                blogPosts.forEach(post => {
                    const card = document.createElement('div');
                    card.className = 'card';
                    card.id = `blog-${post.blog_id}`;

                    // Card header
                    const cardHeader = document.createElement('div');
                    cardHeader.className = "card-header";
                    const cardTitle = document.createElement("h4");
                    cardTitle.className = "card-title";
                    cardTitle.textContent = post.title;
                    cardHeader.appendChild(cardTitle);

                    // Card body
                    const cardBody = document.createElement("div");
                    cardBody.className = "card-body";
                    const cardLink = document.createElement("a");
                    cardLink.setAttribute('href', '#');
                    cardLink.onclick = function () { fillModal(post); };
                    const cardImage = document.createElement("img");
                    cardImage.className = "card-img";

                    // Directly construct the image URL
                    const imageUrl = '<?php echo $base_url; ?>images/' + post.blog_id + '/' + post.blog_id + '.jpg';
                    cardImage.src = imageUrl;
                    cardImage.onerror = function() {
                        // Hide the image or set a default image if it fails to load
                        cardImage.style.display = 'none';
                        console.log('Failed to load image for blog_id ' + post.blog_id);
                    };
                    console.log('Card Image URL:', cardImage.src); // Debugging: Check image URL

                    cardBody.appendChild(cardImage);
                    cardBody.appendChild(cardLink);

                    // Card footer
                    const cardFooter = document.createElement("div");
                    cardFooter.className = "card-footer";
                    const cardEmail = document.createElement("p");
                    cardEmail.className = "card-text";
                    cardEmail.textContent = post.creator_email;
                    cardFooter.appendChild(cardEmail);

                    card.appendChild(cardHeader);
                    card.appendChild(cardBody);
                    card.appendChild(cardFooter);

                    row.appendChild(card);
                });

                postsContainer.appendChild(row);
            }


            // Function to fill modal in photo-only view
            function fillModal(post) {
                document.getElementById('card-modal-title').innerHTML = post.title;
                if (post.images && post.images.length > 0) {
                    document.getElementById('card-modal-img').setAttribute('src', baseUrl + 'images/' + post.blog_id + '/' + post.images[0]);
                } else {
                    // Optionally handle the case where there are no images
                    document.getElementById('card-modal-img').style.display = 'none';
                }
                document.getElementById('card-modal-desc').innerHTML = post.description;
                document.getElementById('card-modal-email').innerHTML = post.creator_email;
                // Handle pagination if multiple images are present
            }

            // Event listeners updated to include viewOptions
            document.getElementById('searchButton').addEventListener('click', () => {
                const title = document.getElementById('searchInput').value;
                const startDate = document.getElementById('startDate').value;
                const endDate = document.getElementById('endDate').value;
                const sortOrder = document.getElementById('sortOrder').value;
                const viewOptions = document.getElementById('viewOptions').value;
                fetchBlogs(title, startDate, endDate, sortOrder, viewOptions);
            });

            document.getElementById('searchInput').addEventListener('keydown', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    const title = document.getElementById('searchInput').value;
                    const startDate = document.getElementById('startDate').value;
                    const endDate = document.getElementById('endDate').value;
                    const sortOrder = document.getElementById('sortOrder').value;
                    const viewOptions = document.getElementById('viewOptions').value;
                    fetchBlogs(title, startDate, endDate, sortOrder, viewOptions);
                }
            });

            document.getElementById('sortOrder').addEventListener('change', () => {
                const title = document.getElementById('searchInput').value;
                const startDate = document.getElementById('startDate').value;
                const endDate = document.getElementById('endDate').value;
                const sortOrder = document.getElementById('sortOrder').value;
                const viewOptions = document.getElementById('viewOptions').value;
                fetchBlogs(title, startDate, endDate, sortOrder, viewOptions);
            });

            // Initialize the correct view on page load
            const initialViewOptions = document.getElementById('viewOptions').value;
            if (initialViewOptions === 'photoOnly') {
                loadPhotoOnlyView();
            } else {
                loadTraditionalView();
            }
        </script>
    </div>
</section>
</body>
</html>