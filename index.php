<?php include("includes/a_config.php");
$conn = OpenCon();
$CURRENT_PAGE = "Index";
?>
<!--
The code below (12-30) will add new user based on the register paramters in the login-register_modal.

It will also execute again if the page is reloaded so we
probably need to put this code into a method or something.
-->

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $retypePassword = $_POST['retype-password'];
    $hashed_pw = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (email, password) VALUES (?,?)";

    if ($stmt = $conn-> prepare($sql)) {
        $stmt-> bind_param("ss", $email, $hashed_pw);
        if ($stmt-> execute()) {
            echo "User registered";
        }
        else{
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}?>

<!DOCTYPE html>
<html>
<head>
	<?php include("includes/head-tag-contents.php");?>
</head>
<body>

<?php include("includes/design-top.php");?>
<?php include("includes/navigation.php");?>

<div class="container" id="main-content">
    <h3>Public Blogs</h3>
    <div class="row row-cols-4 gx-0 gap-4" id="blog-row" style="width: 1800px;"></div>
</div>

<script>
    fetch('get_blog_posts.php')
        .then(response => response.json())
        .then(blogPosts => {
            const blogRow = document.getElementById('blog-row');
            
            blogPosts.forEach(post => {
                // Card Class
                const blogCard = document.createElement("div");
                blogCard.className = "card w-90";

                // Header
                const cardHeader = document.createElement("div");
                cardHeader.className = "card-header";

                const cardTitle = document.createElement("h4");
                cardTitle.className = "card-title";
                cardTitle.textContent = post.title;

                cardHeader.appendChild(cardTitle);
                
                // Body
                const cardBody = document.createElement("div");
                cardBody.className = "card-body";

                const cardImage = document.createElement("img");
                cardImage.className = "card-img";
                cardImage.style = "object-fit: cover; height:15vw ; width: 100%;";
                cardImage.src = `../photo_abcd_A/images/${post.blog_id}/${post.blog_id}.jpg`;

                cardBody.appendChild(cardImage);

                // Footer
                const cardFooter = document.createElement("div");
                cardFooter.className = "card-footer";

                const cardEmail = document.createElement("p");
                cardEmail.className = "card-text";
                cardEmail.textContent = post.creator_email;

                cardFooter.appendChild(cardEmail);

                // Append Blog Card
                blogCard.appendChild(cardHeader);
                blogCard.appendChild(cardBody);
                blogCard.appendChild(cardFooter);

                blogRow.appendChild(blogCard);

            });
        })
        .catch(error => console.error('Error fetching blog posts:', error));
</script>

<?php include("includes/footer.php");?>

</body>
</html>