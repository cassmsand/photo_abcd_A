<?php include("includes/a_config.php");
$conn = OpenCon();
$CURRENT_PAGE = "Index";
?>
<!--
The code below (12-30) will add new user based on the register parameters in the login-register_modal.

It will also execute again if the page is reloaded, so we
probably need to put this code into a method or something.
-->

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $retypePassword = $_POST['retype-password'];
    $hashed_pw = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (email, password) VALUES (?,?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ss", $email, $hashed_pw);
        if ($stmt->execute()) {
            echo "User registered";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("includes/head-tag-contents.php");?>
    <style>
        .container {
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
        }

        .row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            justify-items: center;
        }

        .card {
            width: 100%;
            max-width: 350px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            background-color: #fff;
        }

        .card-header {
            background-color: #f8f9fa;
            padding: 10px;
        }

        .card-title {
            margin: 0;
            font-size: 1.25rem;
        }

        .card-body {
            padding: 10px;
        }

        .card-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #e0e0e0;
        }

        .card-footer {
            padding: 10px;
            background-color: #f1f1f1;
        }

        .card-text {
            margin: 0;
            font-size: 0.875rem;
            color: #6c757d;
        }

        @media (max-width: 768px) {
            .card-img {
                height: 150px;
            }
        }
    </style>
</head>
<body>

<?php include("includes/design-top.php");?>
<?php include("includes/navigation.php");?>

<div class="container" id="main-content">
    <h3>Public Blogs</h3>
    <div class="row" id="blog-row"></div>
</div>

<script>
    fetch('get_blog_posts.php')
        .then(response => response.json())
        .then(blogPosts => {
            const blogRow = document.getElementById('blog-row');

            blogPosts.forEach(post => {
                const blogCard = document.createElement("div");
                blogCard.className = "card";

                const cardHeader = document.createElement("div");
                cardHeader.className = "card-header";

                const cardTitle = document.createElement("h4");
                cardTitle.className = "card-title";
                cardTitle.textContent = post.title;

                cardHeader.appendChild(cardTitle);

                const cardBody = document.createElement("div");
                cardBody.className = "card-body";

                const cardImage = document.createElement("img");
                cardImage.className = "card-img";
                cardImage.src = `../photo_abcd_A/images/${post.blog_id}/${post.blog_id}.jpg`;

                cardBody.appendChild(cardImage);

                const cardFooter = document.createElement("div");
                cardFooter.className = "card-footer";

                const cardEmail = document.createElement("p");
                cardEmail.className = "card-text";
                cardEmail.textContent = post.creator_email;

                cardFooter.appendChild(cardEmail);

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