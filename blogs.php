<?php include("includes/a_config.php");
$CURRENT_PAGE = "Blogs";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("includes/head-tag-contents.php");?>
    <link href="blogs.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php include("includes/design-top.php");?>
<?php include("includes/navigation.php");?>

<?php $blankIcon = '../photo_abcd_A/images/blankicon.jpg';?>

<div class="container" id="main-content">
    <h1>Blogs</h1>

    <div id="postsContainer"></div>

    <script>
        // Fetch data from the backend API
        fetch('get_blog_posts.php')
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

                    const img = document.createElement('img');
					img.src = `../photo_abcd_A/images/${post.blog_id}/${post.blog_id}.jpg`;
                    img.alt = 'Blog Image';
                    img.className = 'blog-photo';

                    const blogDescription = document.createElement('p');
                    blogDescription.className = 'blog-description';
                    blogDescription.textContent = post.description;

                    const blogSeparator = document.createElement('hr');
                    blogSeparator.className = 'blog-separator';

                    blogUserContainer.appendChild(userImage);
                    blogUserContainer.appendChild(username);
                    blogUserContainer.appendChild(userbutton);
                    imageContainer.appendChild(img);
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

<?php include("includes/footer.php");?>

</body>
</html>