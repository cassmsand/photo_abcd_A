<html>
<body>

    <?php 
        if (isset($_SESSION['current_user_email'])) {
            $header = "Your Blogs";
        } else {
            $header = "Public Blogs";
        }
    ?>

    <h3><?php echo $header;?></h3>
    <div class="row" id="blog-row"></div>

    <template id='card-template'>
    <div class='card'>
        <div class='card-header'>
            <h4 class='card-title'></h4>
        </div>
        <div class='card-body'>
            <img class="card-img" src='' alt="">
            <a class='stretched-link' href="#card-modal" data-target="cardModal" data-toggle="modal"></a>
        </div>
        <div class="card-footer">
            <p class="card-text"></p>
        </div>
    </div>
    </template>

    <?php
        if (!isset($_GET['blog_pairs'])) {include_once('actions/get-blogs-2.php');}
        include('card-modal.php');
    ?>

    <script type="text/javascript">
        const blogs = <?php echo $_GET['blog_pairs']; ?>;
        const blogRow = document.getElementById('blog-row');

        blogs.forEach(pair => {
            // Blog Row Attributes
            const table = pair.table;

            const blog_id = table.blog_id;
            const email = table.creator_email;
            const title = table.title;
            const description = table.description;
            const event_date = table.event_date;
            const creation_date = table.creation_date;
            const modification_date = table.modification_date;
            const privacy_filter = table.privacy_filter;

            // Image Array
            const images = pair.images;
            const newcard = createCard(title, email, images[0]);
            blogRow.appendChild(newcard);
        });
        /*
        // https://www.youtube.com/watch?v=zjYgz50E0mA

        tag.class[attributes]
        img.card-img['src']
        */
        function createCard(title, email, img_src) {
            template = document.getElementById('card-template');
            card = template.content.cloneNode(true);

            btitle = document.querySelector('h4.card-title').innerHTML = title;
            bfooter = document.querySelector('.card-text');
            bimg = document.querySelector('.card-img');

            

            return card;
        }
        
    </script>

</body>
</html>