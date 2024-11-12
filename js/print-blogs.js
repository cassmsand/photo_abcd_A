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
 * 
 * @param {*} blogArr Array of blog rows.
 */
function printBlogs(blogArr) 
{
    // Create and append container for print pages
    const printContainer = document.createElement("div");
    printContainer.classList.add("printable");
    document.body.appendChild(printContainer);

    // Create a page for every blog entry in blogArr parameter.
    blogArr.forEach((blog) => createPage(blog));

    // Open print menu.
    window.print();

    // Clear print elements from body.
    document.body.removeChild(printContainer);

    /**
     * Creates and appends a page with a given blogs info.
     * Requires that blogs contain an array of images.
     * 
     * @param {*} blog Blog that is being printed.
     */
    function createPage(blog)
    {
        var imgSrc;
        if (blog.images.length != 0) {
            imgSrc = `images/${blog.blog_id}/${blog.images[0]}`
        } else {
            imgSrc = "images/photoABCDLogo.png";
        }

        // Page Element: Consists of 3 parts: Header, Body, and Footer.
        const printElement = document.createElement('div');
        printElement.classList.add("printelement");

        // Page Header Container
        const printHeader = document.createElement('div');
        printHeader.className = "print-header";

            const headerRow = document.createElement('div');
            headerRow.className = "row";

                const blogTitle = document.createElement("h1");
                blogTitle.className = "col";
                blogTitle.innerHTML = blog.title;

                const blogEventDate = document.createElement("p");
                blogEventDate.className = "col";
                blogEventDate.innerHTML = blog.event_date;

            headerRow.appendChild(blogTitle);
            headerRow.appendChild(blogEventDate);
            printHeader.appendChild(headerRow);

        // Page Body Container
        const printBody = document.createElement('div');
        printBody.className = "print-body";

            const blogImage = document.createElement('img');
            blogImage.src = imgSrc;

            printBody.appendChild(blogImage);


        // Page Footer Container
        const printFooter = document.createElement('div');
        printFooter.className = "print-footer";
            const blogDesc = document.createElement("p");
            blogDesc.innerHTML = blog.description;

            printFooter.appendChild(blogDesc);

        // Appending of page element parts.
        printElement.appendChild(printHeader);
        printElement.appendChild(printBody);
        printElement.appendChild(printFooter);
        printContainer.appendChild(printElement);
    }
};