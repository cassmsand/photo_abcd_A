<?php 
    if (isset($_SESSION['current_user_email'])) {
        $header = "Your Blogs";
    } else {
        $header = "Public Blogs";
    }
?>

<h3><?php echo $header;?></h3>
<div class="row" id="blog-row"></div>

<script>
    fetch('actions/get-blogs.php')
    .then(response => response.json())
    .then(blogs => {
        const blogRow = document.getElementById('blog-row');

        blogs.forEach(post => {
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
    }).catch(error => console.error('Error fetching blog posts:', error));
</script>