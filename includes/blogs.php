<!DOCTYPE html>
<html lang="en">

    <head>
        <link href="css/blogs.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <?php $blankIcon = '../photo_abcd_A/images/blankicon.jpg';?>
    
        <section>
        <div class="container" id="main-content">
            <h1>Blogs</h1>

    <!-- Search Form -->
    <div id="searchContainer">
        <input type="text" id="searchInput" placeholder="Search by title...">
        <input type="date" id="startDate" placeholder="Start Date">
        <input type="date" id="endDate" placeholder="End Date">
        <button id="searchButton">Search</button>
    </div>

    <div id="sortContainer">
        <label for="sortOrder">Sort By:</label>
        <select id="sortOrder">
            <option value="asc">Alphabetically (A-Z)</option>
            <option value="desc">Alphabetically (Z-A)</option>
        </select>
    </div>

    <div id="postsContainer"></div>
            <script>
                // Function to fetch blog posts with sorting
                const fetchBlogs = (title = '', startDate = '', endDate = '', sortOrder = 'asc') => {
                    fetch(`actions/get-blogs.php?title=${title}&start_date=${startDate}&end_date=${endDate}&sort_order=${sortOrder}`)
                        .then(response => response.json())
                        .then(blogPosts => {
                            const postsContainer = document.getElementById('postsContainer');
                            postsContainer.innerHTML = ''; // Clear previous posts

                            blogPosts.forEach(post => {
                                const blogContainer = document.createElement('div');
                                blogContainer.className = 'blog-container';

                                const blogUserContainer = document.createElement('div');
                                blogUserContainer.className = 'blog-user-container';

                                const userImage = document.createElement('img');
                                userImage.src = '../photo_abcd_A/images/blankicon.jpg';
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
                                img.src = `../photo_abcd_A/images/${post.blog_id}/${post.blog_id}.jpg`;
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

                                        currentImageIndex = 0;

                                        // Left arrow click event
                                        leftArrow.addEventListener('click', () => {
                                            currentImageIndex--;
                                            if (currentImageIndex < 0) {
                                                currentImageIndex = fileCount-1;
                                                img.src = `../photo_abcd_A/images/${post.blog_id}/${post.blog_id}_${currentImageIndex}.jpg`;
                                            } else if (currentImageIndex == 0) {
                                                img.src = `../photo_abcd_A/images/${post.blog_id}/${post.blog_id}.jpg`;
                                            } else {
                                                img.src = `../photo_abcd_A/images/${post.blog_id}/${post.blog_id}_${currentImageIndex}.jpg`;
                                            }
                                            
                                        });

                                        // Right arrow click event
                                        rightArrow.addEventListener('click', () => {
                                            currentImageIndex++;
                                            if (currentImageIndex == fileCount) {
                                                currentImageIndex = 0; // Reset to zero if it reaches fileCount
                                                img.src = `../photo_abcd_A/images/${post.blog_id}/${post.blog_id}.jpg`;
                                            } else {
                                                img.src = `../photo_abcd_A/images/${post.blog_id}/${post.blog_id}_${currentImageIndex}.jpg`;
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
                        })
                        .catch(error => console.error('Error fetching blog posts:', error));
                };


                fetchBlogs();


                document.getElementById('searchButton').addEventListener('click', () => {
                    const title = document.getElementById('searchInput').value;
                    const startDate = document.getElementById('startDate').value;
                    const endDate = document.getElementById('endDate').value;
                    const sortOrder = document.getElementById('sortOrder').value;
                    fetchBlogs(title, startDate, endDate, sortOrder);
                });


                document.getElementById('searchInput').addEventListener('keydown', (event) => {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        const title = document.getElementById('searchInput').value;
                        const startDate = document.getElementById('startDate').value;
                        const endDate = document.getElementById('endDate').value;
                        const sortOrder = document.getElementById('sortOrder').value;
                        fetchBlogs(title, startDate, endDate, sortOrder);
                    }
                });

                // Sort order change event listener
                document.getElementById('sortOrder').addEventListener('change', () => {
                    const title = document.getElementById('searchInput').value;
                    const startDate = document.getElementById('startDate').value;
                    const endDate = document.getElementById('endDate').value;
                    const sortOrder = document.getElementById('sortOrder').value;
                    fetchBlogs(title, startDate, endDate, sortOrder);
                });
            </script>

        </div>
        </section>
        
    </body>
</html>