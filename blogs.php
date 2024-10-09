<!DOCTYPE html>
<html lang="en">

    <?php include("includes/head-tag-contents.php");?>

    <head>
        <link href="blogs.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <?php include("includes/top-bar.php");?>
        <?php $blankIcon = '../photo_abcd_A/images/blankicon.jpg';?>
    
        <section>
        <div class="container" id="main-content">
            <h1>Blogs</h1>

            <div id="postsContainer"></div>

            <script>
                // Fetch data from the backend API
                fetch('actions/get-blogs.php')
                    .then(response => response.json())
                    .then(blogPosts => {
                        const postsContainer = document.getElementById('postsContainer');
                        const buttontext = '⚪ ⚪ ⚪';

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

                            const userbutton = document.createElement('button');
                            userbutton.className = 'blog-userbutton';
                            userbutton.textContent = buttontext;

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

                            let currentImageIndex = 0;
                            let images = [];
                            
                            if (post.images.length > 0) {
                                img.src = `../photo_abcd_A/images/${post.blog_id}/${post.images[0]}`;
                        
                                // Show arrows only if there's more than one image
                                if (post.images.length > 1) {
                                    leftArrow.style.display = 'inline';  
                                    rightArrow.style.display = 'inline'; 
                                }
                            }

                            leftArrow.addEventListener('click', () => {
                                currentImageIndex = (currentImageIndex - 1 + post.images.length) % post.images.length;
                                img.src = `../photo_abcd_A/images/${post.blog_id}/${post.images[currentImageIndex]}`;
                            });

                            rightArrow.addEventListener('click', () => {
                                currentImageIndex = (currentImageIndex + 1) % post.images.length;
                                img.src = `../photo_abcd_A/images/${post.blog_id}/${post.images[currentImageIndex]}`;
                            });

                            const blogDescription = document.createElement('p');
                            blogDescription.className = 'blog-description';
                            blogDescription.textContent = post.description;

                            const blogSeparator = document.createElement('hr');
                            blogSeparator.className = 'blog-separator';

                            blogUserContainer.appendChild(userImage);
                            blogUserContainer.appendChild(username);
                            blogUserContainer.appendChild(userbutton);
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
            </script>

        </div>
        </section>
        
    </body>

    <footer>
        <?php include("includes/footer.php");?>
    </footer>
</html>