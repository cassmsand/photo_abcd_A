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

        // Page Header Container.
        const printHeader = document.createElement('div');
        printHeader.className = "print-header";

        const blogTitle = document.createElement("h1");
        blogTitle.innerHTML = blog.title;

        printHeader.appendChild(blogTitle);

        // Page Body Container
        const printBody = document.createElement('div');
        printBody.className = "print-body";

        const blogImage = document.createElement('img');
        blogImage.src = imgSrc;
        printBody.appendChild(blogImage);


        // Page Footer Container
        const printFooter = document.createElement('div');
        printFooter.className = "print-footer";
        const blogEventDate = document.createElement("div");
        blogEventDate.className = "event-date-badge";
        const dateStr = new Date(blog.event_date).toLocaleDateString(undefined, {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        });
        blogEventDate.innerHTML = dateStr;
        printFooter.appendChild(blogEventDate);

        const blogDesc = document.createElement("div");
        blogDesc.className = "desc";
        blogDesc.innerHTML = blog.description;
        printFooter.appendChild(blogDesc);

        // Appending of page element parts.
        printElement.appendChild(printHeader);
        printElement.appendChild(printBody);
        printElement.appendChild(printFooter);
        printContainer.appendChild(printElement);
    }
};
