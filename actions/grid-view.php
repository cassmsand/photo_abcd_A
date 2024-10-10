<html>
<head>
    <link rel="stylesheet" href="blog-grid.css">
</head>

<body>
    <?php 
        if (isset($_SESSION['current_user_email'])) {
            $header = "Your Blogs";
        } else {
            $header = "Public Blogs";
        }
        if (!isset($_GET['blog_pairs'])) {include_once('actions/get-blogs-modular.php');}
    ?>
    <section> 
        <div class="modal fade" id="card-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h3 id='card-modal-title'></h3>
                    </div>

                    <div class="modal-body">
                        <!-- Need to handle multiple page functionality -->
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
    </section>

    <h3><?php echo $header;?></h3>

    <div>
        <label for="sortOrder">Sort By:</label>
        <select id="sortOrder">
            <option value="asc">Alphabetically (A-Z)</option>
            <option value="desc">Alphabetically (Z-A)</option>
        </select>
    </div>

    <div class="row" id="blog-row"></div>

    <script type="text/javascript">
        const blogs = <?php echo $_GET['blog_pairs']; ?>;
        const blogRow = document.getElementById('blog-row');

        function displaySortedBlogs(sortOrder = 'asc') {
            blogRow.innerHTML = ''; // Clear the container

            // Sort blogs based on title in ascending or descending order
            blogs.sort((a, b) => {
                const titleA = a.table.title.toLowerCase();
                const titleB = b.table.title.toLowerCase();
                if (sortOrder === 'asc') {
                    return titleA < titleB ? -1 : (titleA > titleB ? 1 : 0);
                } else {
                    return titleA > titleB ? -1 : (titleA < titleB ? 1 : 0);
                }
            });

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
                const img_src = `${images.dir}${images.img_names[0]}`;
                createCard(blogRow, title, email, img_src, blog_id, pair);
            });
        }
        function createCard(container, title, email, img, id, pair) {
            const card = document.createElement("div");
            card.className='card';
            card.id = `blog-${id}`;
                // Header
                const cardHeader = document.createElement("div");
                cardHeader.className = "card-header";
                    const cardTitle = document.createElement("h4");
                    cardTitle.className = "card-title";
                    cardTitle.textContent = title;
                cardHeader.appendChild(cardTitle);
                // Body
                const cardBody = document.createElement("div");
                cardBody.className = "card-body";
                    const cardLink = document.createElement("a");
                    cardLink.setAttribute('data-target', "#card-modal");
                    cardLink.setAttribute('data-toggle', "modal");
                    cardLink.className = 'stretched-link';
                    cardLink.onclick = function() {fillModal(pair);};
                    const cardImage = document.createElement("img");
                    cardImage.className = "card-img";
                    cardImage.src = img;
                cardBody.appendChild(cardImage);
                cardBody.appendChild(cardLink);
                // Footer
                const cardFooter = document.createElement("div");
                cardFooter.className = "card-footer";
                    const cardEmail = document.createElement("p");
                    cardEmail.className = "card-text";
                    cardEmail.textContent = email;
                cardFooter.appendChild(cardEmail);

            card.appendChild(cardHeader);
            card.appendChild(cardBody);
            card.appendChild(cardFooter);

            // Attach to container.
            container.appendChild(card);
        }

        function fillModal(pair) {
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

            // Image Source
            const img_src = `${images.dir}${images.img_names[0]}`;

            document.getElementById('card-modal-title').innerHTML = title;
            document.getElementById('card-modal-img').setAttribute('src', img_src);
            document.getElementById('card-modal-desc').innerHTML = description;
            document.getElementById('card-modal-email').innerHTML = email;

            // Find a way to work an index with this.
            pagenav = document.getElementById('card-modal-img-nav');
        }
        displaySortedBlogs();

        // Event listener for sort order change
        document.getElementById('sortOrder').addEventListener('change', (event) => {
            const sortOrder = event.target.value;
            displaySortedBlogs(sortOrder);
        });

    </script>
</body>
</html>