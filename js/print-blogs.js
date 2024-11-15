/**
 * Dynamically creates and appends page elements for printing blogs.
 * Print elements are removed after print menu is displayed.
 *
 * The layout of the printed pages requires the print-page.css file.
 *
 * Blogs require an array of names from the blog images. Refer to
 * the abook-get-user-blogs.php file for implementation details.
 *
 * ---
 * Usage:
 * - Include print-page.css in head.
 * - Get array of blog rows
 * - Pass blog rows to printBlogs
 * ---
 * Structure of elements:
 * - Page Container: Contains the pages. Is appeneded to the < body >.
 *   - Page: A single page formatted for printing.
 *     - Page Header: Contains the blog title and event date.
 *     - Page Body: Contains the blog images.
 *     - Page Footer: Contains the blog descriptions.
 *    - Other Pages...
 * ---
 * @param {*} blogArr Array of blog rows.
 */
function printBlogs(blogArr)
{
    // Create and append container for print pages
    const printContainer = document.createElement("div");
    printContainer.classList.add("printable");
    document.body.appendChild(printContainer);

    // Page number tracker.
    var pageNum = 1;

    // Add Title Page
    // Add Table of Contents Page

    // Create a page for every blog entry in blogArr parameter.
    blogArr.forEach((blog) => createPage(blog));

    // Open print menu.
    window.print();

    // Clear print elements from body after a short delay for cross-platform compatibility.
    setTimeout(() => {
        document.body.removeChild(printContainer);
    }, 100); // 100 ms delay to allow print dialog to load fully

    /**
     * Creates and appends a page with a given blogs info.
     * Requires that blogs contain an array of images.
     *
     * @param {*} blog Blog that is being printed.
     * @param {*} image Blog image to display for multi-image blogs.
     */
    function createPage(blog, image = undefined)
    {
        var imgSrc;
        const blogCount = blog.images.length;
        const printElement = document.createElement('div');
        const printHeader = document.createElement('div');
        const blogTitle = document.createElement("h1");
        const printBody = document.createElement('div');
        const blogImage = document.createElement('img');
        const printFooter = document.createElement('div');
        const numBadge = document.createElement('div');
        const blogEventDate = document.createElement("div");
        const dateStr = new Date(blog.event_date).toLocaleDateString(undefined, {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        });
        const blogDesc = document.createElement("div");

        if (image == undefined) {
            switch (blogCount)
            {
                case 0:
                    imgSrc = "images/photoABCDLogo.png";
                    createElements();
                    pageNum++;
                    break;

                case 1:
                    imgSrc = `images/${blog.blog_id}/${blog.images[0]}`
                    createElements();
                    pageNum++;
                    break;

                default:
                    blog.images.forEach(blogImage => {
                        createPage(blog, blogImage);
                    });
                    break;
            }
        } else {
            imgSrc = `images/${blog.blog_id}/${image}`;
            createElements();
            pageNum++;
        }

        function createElements()
        {
            // Page Element: Consists of 3 parts: Header, Body, and Footer.
            printElement.classList.add("printelement");

            // Page Header Container.
            printHeader.className = "print-header";
                blogTitle.innerHTML = blog.title;
            printHeader.appendChild(blogTitle);

            // Page Body Container
            printBody.className = "print-body";
                blogImage.src = imgSrc;
            printBody.appendChild(blogImage);


            // Page Footer Container
            printFooter.className = "print-footer";
                numBadge.className = "page-num"
                numBadge.innerHTML = `Pg. ${pageNum}`;
                blogEventDate.className = "event-date-badge";
                blogEventDate.innerHTML = dateStr;
                blogDesc.className = "desc";
                blogDesc.innerHTML = blog.description;
            printFooter.appendChild(numBadge);
            printFooter.appendChild(blogEventDate);
            printFooter.appendChild(blogDesc);

            // Appending of page element parts.
            printElement.appendChild(printHeader);
            printElement.appendChild(printBody);
            printElement.appendChild(printFooter);
            printContainer.appendChild(printElement);
        }
    }
};
