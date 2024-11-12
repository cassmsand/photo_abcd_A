const booksRow = document.getElementById('book-bar-row');
const alpha_grid = document.getElementById('alpha-grid-row');
const modalRow = document.getElementById('abook-modal-row');
const modalBody = document.getElementById('abook-modal-body');
const progBar = document.getElementById('progress-bar');
const progBarPending = document.getElementById('progress-bar-pending');
const progBarRegress = document.getElementById('progress-bar-regress');
const progHeader = document.getElementById('prog-header');
const utilBar = document.getElementById('util-bar');
const bookeditTitle = document.getElementById("bookedit-title");
const bookPrintBtn = document.getElementById("print-button");

// Array of book and blog objects.
let user_books = [];
let user_blogs = [];

/**
 * Book objects. Contains title and letter entries.
 * current_book represents the book in the database.
 * pending_book represents the pending changes in the page.
 * All book updates done by pending_book.
 */
let current_book;
let pending_book;
let possible_entries;

/**
 * Variables for Selection Logic.
 * 
 * selected_card, selected_book:
 * Used for toggling card visuals when selected.
 * 
 * selected_letter, selected_blogs:
 * Handles key-value logic for current book.
 * 
 */
let selected_card;
let selected_book;
let selected_letter;
var selected_blogs = [];


/**
 * In the database: [Key => Value]
 * Expected: creator_email => [...string of all letters]
 * 
 * [email] => 'title:/A:/B:/C:/D:/E:/F:/G:/H:/I:/J:/K:/L:/M:/N:/O:/P:/Q:/R:/S:/T:/U:/V:/W:/X:/Y:/Z:'
 * Books Separated by '|'
 * Attributes separated by '/'
 * Key-Value pairs separated by ':'
 * Value Entries Separated by ','
 * 
 * Input: 'title:Book Name/A:6,4,8/B:3,5,9/...'
 * Output:
 * 
 * Array 
 *  {
 *      title => "Book Name",
 *      A => "6,4,8",
 *      B => "3,5,9",
 *      ...
 *  }
 * 
 * 
 * Functional Requirements:
 * Cards MUST support multiple card selections of same letter.
 * Completion based on if letter has at least 1 entry.
 * 
 */


init();

/**
 * Cast the letter and letter array as an JSON object.
 * Update functionality after.
 * Update Letter.
 */

// Querying Functions

function init()
{
    Promise.all([fetchBooks(), fetchBlogs()])
        .then(results => {
            user_books = results[0];
            user_blogs = results[1];

            if (possible_entries === undefined) {
                possible_entries = {};
                user_blogs.forEach(blog => {
                    const letter = blog.title[0].toUpperCase();
                    const id = blog.blog_id;
                    if (possible_entries[letter] === undefined) {
                        possible_entries[letter] = [id];
                    } else {
                        if (!possible_entries[letter].includes(id)) {
                            possible_entries[letter].push(id);
                        }
                    }
                });
            }

            console.log(user_books);
            console.log(user_blogs);
            console.log(possible_entries);
            
            displayBar();
        });
}

async function fetchBlogs()
{
    const response = await fetch('actions/abook-get-user-blogs.php');
    if (!response.ok)
    {
        throw new Error('Network Response error');
    }
    const dataArr = await response.json();
    const rows = dataArr.map(row =>{
        return row;
    });
    return rows;
}

async function fetchBooks()
{
    const response = await fetch('actions/abook-get-user-books.php');
    if (!response.ok)
    {
        throw new Error('Network Response error');
    }
    const dataArr = await response.json();
    //console.log(dataArr);
    const rows = strToBook(dataArr);
    return rows;

    function strToBook(strArr)
    {
        // Will all alphabet books.
        var bookArr = [];

        // For each book string in the array
        strArr.forEach((bookStr) => {
            // Add Book Object (Has key values value pairs)
            bookArr.push(
                // Creates Key Value Pair
                Object.fromEntries(
                    // Splits key value strings
                    bookStr.value.split("/")
                        // Splits the key from the value
                        .map(pair => pair.split(":")
                            // Splits values.
                            .map(values => values.split(","))
                )))
        });
        
        return bookArr; 
    }
}

async function updateBook()
{
    var oldBookTitle = current_book['title'][0];
    let newBookStr = "";

    for (let key in pending_book) {
        let value = pending_book[key].join(",");
        newBookStr += `${key}:${value}/`;
    }

    newBookStr = newBookStr.substring(0, newBookStr.length - 1);
    newBookStr = `${oldBookTitle}|${newBookStr}`
    console.log(newBookStr);
    
    await fetch(`actions/abook-update-book.php`, 
    {
        method: 'POST',
        body: newBookStr
    }).then(response => console.log(response.text()))
    
    current_book = Object.assign({}, pending_book);
    init();
    
}

async function deleteBook()
{
    const oldBookTitle = `${current_book['title'][0]}`;
    await fetch(`actions/abook-delete-book.php`, 
    {
        method: 'POST',
        body: oldBookTitle
    })
    current_book = null;
    init();
}

async function newBook(newbookTitle)
{
    await fetch('actions/abook-new-book.php', {
        method: 'POST',
        body: newbookTitle
    }).then(response => console.log(response.text()));
    
    let noBook = document.getElementById('no-book');
    if (noBook) {
        noBook.remove();
    }

    if (utilBar.hidden)
    {
        utilBar.hidden = false;
        alpha_grid.hidden = false;
    }
    init();

}

// Modal Functions

/**
 * Sets the progress bar logic.
 * Displays progress and pending changes.
 */
function setProgress()
{
    var totalCurrent = Object.values(current_book).filter(value => (value != "")).length;
    var totalPending = Object.values(pending_book).filter(value => (value != "")).length;
    totalPending -= totalCurrent;
    var regression = 0;

    if (totalPending < 0) {
        regression = totalPending;
    }

    var progress = ~~(((totalCurrent+regression-1) / 26) * 100);
    var progressPending = ~~((totalPending / 26) * 100);
    var progressRegress = ~~(((regression*-1) / 26) * 100);

    var pendStr = '';

    switch (totalPending) {
        case totalPending < 0:
        case 0:
            break;
        case 1:
            pendStr = ` (Entry Pending)`;
            break;
        case totalPending > 1:
            pendStr = ` (${totalPending} Entries Pending)`;
            break;
    }

    progBar.style.width = `${progress}%`;
    progBarPending.style.width = `${progressPending}%`;
    progBarRegress.style.width = `${progressRegress}%`;
        
    progHeader.innerHTML = `${current_book.title} | ${progress}%${pendStr}`;
}

/**
 * Updates pending letter entry.
 * Does not query. Does not provide visual feedback.
 * 
 * @param {string} str
 * Name of the card ID.
 * 
 * Example String: F:6
 */
function updatePending()
{
    const postAmt = selected_blogs.length;
    var obj = {};
    obj[selected_letter] = selected_blogs;
    Object.assign(pending_book, obj);
    updateSelectedCard(postAmt);

}

// Display Functions

/**
 * Clears the Book Bar and generates cards for all user books.
 * Adds card with book creation functionality at the end of the book element.
 * Automatically selects first Book element when page loads.
 * Defers to current_book if recalled.
 * Handles case in which user has no books.
 */
function displayBar() 
{
    clearContainer(booksRow);
    user_books.forEach(book => {
        createBookCard(book);
    });
    createBookCard(null, true);

    if (user_books.length == 0) {
        noBookDisplay();

        // Executes on click method for book card.
    } else if (current_book == null) {
        var bookCard = document.getElementById(`${user_books[0].title}`);
        toggleCard(bookCard);
        displayGrid(user_books[0]);

    } else {
        
        displayGrid(current_book);
    }

}

/**
 * Displays when there are no books for the current user.
 */
function noBookDisplay()
{
    //alphaStr = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //[...alphaStr].forEach(letter => createBlankGridCard(letter));
    clearContainer(alpha_grid);
    pending_book = null;

    const gridCont = document.getElementById('alpha-grid');
    utilBar.hidden = true;
    alpha_grid.hidden = true;

    const noBook = document.createElement("div");
        noBook.className = 'container no-book';
        noBook.id = 'no-book';
    
    const noBookHeader = document.createElement("h1");
        noBookHeader.innerHTML = 'No Books Found'

    noBook.appendChild(noBookHeader);
    gridCont.appendChild(noBook);
}

function displayGrid(book) 
{
    current_book = Object.assign({}, book);
    pending_book = Object.assign({}, book);

    clearContainer(alpha_grid);

    // Creates new book object. Prevents overriding of current_book.
    var letters = Object.assign({}, book);
    delete letters['title'];

    // Represents the array of blog_ids for a letter of the book.
    entries = Object.entries(letters);
    
    entries.forEach(pair => {
        var letter = pair[0];
        var blogidArr = pair[1];
        //console.log(pair);

        /**
         * case 0: No related blogs.
         * case 1: Only has one blog.
         * default: Has multiple blogs.
         * 
         * Key : [value]
         */
        switch (blogidArr.length)
        {
            case 0:
                createBlogCard(letter, 'blank');
                break;

            case 1:
                var blog = getBlogById(blogidArr[0]);
                if (blog != null) 
                {
                    createBlogCard(blog, 'grid');
                } 
                else 
                {
                    createBlogCard(letter, 'blank');
                }
                break;

            default:
                var multiBlog = [];
                blogidArr.forEach(blogid => {
                    multiBlog.push(getBlogById(blogid));
                });
                createBlogCard(multiBlog, 'multi');
                break;
        }
    });

    setProgress();
}

function getBlogById(id)
{
    let result;
    user_blogs.forEach(blog => {
        if (blog.blog_id === id) {
            result = blog;
        } 
    });
    return result;
}

function clearContainer(container)
{
    container.innerHTML = '';
}

// Card Behavior Functions

function displayAvailableBlogs(letter, hasPending = false)
{
    selected_letter = letter.toUpperCase();
    console.log(letter);
    var blogCardType;
    var initialEntries = 0;

    switch (hasPending)
    {
        case false:
            blogCardType = "modal";
            break;

        case true:
            blogCardType = "modalpending";
            break;
    }

    const noBlogs = document.getElementById('no-blogs');
    clearContainer(modalRow);

    var hasEntries = false;
    user_blogs.forEach(blog => {
        if (blog.title[0].toUpperCase() == letter) {
            if (!hasEntries)
            {
                hasEntries = true;
            }
            createBlogCard(blog, blogCardType);
        }
    });

    if (hasEntries) {
        if (noBlogs != null) {
            noBlogs.remove();
        }
    } else {
        if (noBlogs == null) 
        {
            const noBlogs = document.createElement("div");
                noBlogs.className = 'container no-blogs';
                noBlogs.id = 'no-blogs';
            
            const noBlogsHeader = document.createElement("h1");
                noBlogsHeader.innerHTML = 'No Blogs Found'

            noBlogs.appendChild(noBlogsHeader);
            modalBody.appendChild(noBlogs);
        }
    }
}

function toggleCard(element, type='book')
{
    switch(type)
    {
        case "book":
            switch(selected_book)
            {
                case undefined:
                    selected_book = element;
                    selected_book.classList.add('selected');
                    break;
                
                default:
                    selected_book.classList.remove('selected');
                    selected_book = element;
                    selected_book.classList.add('selected');
                    break;
            }
            break;

        case "blog":
            switch(selected_card)
            {
                case undefined:
                    selected_card = element;
                    selected_card.classList.add('selected');
                    //console.log(selected_card);
                    break;
                
                default:
                    selected_card.classList.remove('selected');
                    selected_card = element;
                    selected_card.classList.add('selected');
                    //console.log(selected_card);
                    break;
            }
            break;
    }
        
}

// Card Creation Functions

function createBlogCard(blogOrChar, type = 'grid')
{
    const card = document.createElement("div");
    const cardHeader = document.createElement("div");
    const cardBody = document.createElement("div");
    const cardImage = document.createElement("img");
    const cardLink = document.createElement("a");

    switch (type)
    {
        case 'blank':
            blank();
            break;

        case 'grid':
            grid();
            break;

        case 'modal':
            modal();
            break;

        case 'modalpending':
            modal(true);
            break;

        case 'multi':
            multi();
            break;

    }

    function blank()
    {
        var letter = blogOrChar.toUpperCase();
        let entry = possible_entries[letter];
        
        card.className = 'card a-grid';
        card.id = `${letter}-blank`;
        cardHeader.className = "card-header";
        cardHeader.innerHTML = `${letter} | Add Entry`;
        cardBody.className = "card-body";
        cardImage.className = "card-img";
        cardImage.id = 'blank';
        cardImage.src = "images/blank-image.png";
        cardLink.className = 'stretched-link';
        cardLink.setAttribute('data-bs-target', "#abook-modal");
        cardLink.setAttribute('data-bs-toggle', "modal");
        cardLink.addEventListener('click', function (e) {
            toggleCard(card, "blog");
            displayAvailableBlogs(letter);
        });
        card.appendChild(cardHeader);
        card.appendChild(cardBody);
        cardBody.appendChild(cardImage);
        cardBody.appendChild(cardLink);
        if (entry != undefined) {
            const multiNum = document.createElement('div');
            multiNum.className = "entry-count-badge";
            multiNum.innerHTML = `${entry.length} Available`
            card.appendChild(multiNum);
        }
        alpha_grid.appendChild(card);
    }

    function grid()
    {
        var blog = blogOrChar;
        var letter = blog.title[0].toUpperCase();
        let entry = possible_entries[letter];
        var imgSrc;
        if (blog.images.length != 0) {
            imgSrc = `images/${blog.blog_id}/${blog.images[0]}`;
        } else {
            imgSrc = "images/blank-image.png";
            cardImage.id = 'blank';
        }
        card.className = 'card a-grid';
        card.id = blog.title[0];
        cardHeader.className = "card-header";
        cardHeader.innerHTML = `${blog.title}`;
        cardBody.className = "card-body";
        cardImage.className = "card-img";
        cardImage.src = imgSrc;
        cardLink.className = 'stretched-link';
        cardLink.setAttribute('data-bs-target', "#abook-modal");
        cardLink.setAttribute('data-bs-toggle', "modal");
        cardLink.addEventListener('click', function (e) {
            toggleCard(card, "blog");
            displayAvailableBlogs(card.id.toUpperCase());
        });
        card.appendChild(cardHeader);
        card.appendChild(cardBody);
        cardBody.appendChild(cardImage);
        cardBody.appendChild(cardLink);
        if (entry != undefined) {
            const multiNum = document.createElement('div');
            multiNum.className = "entry-count-badge";
            multiNum.innerHTML = `${entry.length} Available`
            card.appendChild(multiNum);
        }
        alpha_grid.appendChild(card);
    }

    function multi()
    {
        var blogArr = blogOrChar;
        var blog = blogArr[0];
        var letter = blog.title[0].toUpperCase();
        let entry = possible_entries[letter];
        var imgSrc;
        if (blog.images.length != 0) {
            imgSrc = `images/${blog.blog_id}/${blog.images[0]}`;
        } else {
            imgSrc = "images/blank-image.png";
            cardImage.id = 'blank';
        }
        const multiNum = document.createElement('div');
        multiNum.className = "nested-count-badge";
        multiNum.innerHTML = `${blogArr.length} Nested`;
        var headerText = `${blog.title}`;
        card.className = 'card a-grid';
        card.id = blog.title[0];
        cardHeader.className = "card-header";
        cardHeader.innerHTML = headerText;
        cardBody.className = "card-body";
        cardImage.className = "card-img";
        cardImage.src = imgSrc;
        cardLink.className = 'stretched-link';
        cardLink.setAttribute('data-bs-target', "#abook-modal");
        cardLink.setAttribute('data-bs-toggle', "modal");
        cardLink.addEventListener('click', function (e) {
            toggleCard(card, "blog");
            displayAvailableBlogs(card.id);
        });
        card.appendChild(cardHeader);
        card.appendChild(cardBody);
        card.appendChild(multiNum);
        cardBody.appendChild(cardImage);
        cardBody.appendChild(cardLink);
        if (entry != undefined) {
            const multiNum = document.createElement('div');
            multiNum.className = "entry-count-badge";
            multiNum.innerHTML = `${entry.length} Available`
            card.appendChild(multiNum);
        }
        alpha_grid.appendChild(card);
    }

    function modal(hasPending = false)
    {
        var blog = blogOrChar;
        const letter = blog.title[0];
        const id = blog.blog_id;
        var imgSrc;
        if (blog.images.length != 0) {
            imgSrc = `images/${blog.blog_id}/${blog.images[0]}`;
        } else {
            imgSrc = "images/blank-image.png";
            cardImage.id = 'blank';
        }
        card.className = 'card a-grid';
        card.id = blog.title[0];
        cardHeader.className = "card-header";
        cardHeader.innerHTML = `${blog.title}`;
        cardBody.className = "card-body";
        cardImage.className = "card-img";
        cardImage.src = imgSrc;
        cardLink.className = 'stretched-link';
        card.appendChild(cardHeader);
        card.appendChild(cardBody);
        cardBody.appendChild(cardImage);
        cardBody.appendChild(cardLink);
        card.addEventListener('click', function (e) {

            if (!card.classList.contains('selected'))
            {
                card.classList.add('selected');
                selected_blogs.push(id);

                console.log(selected_blogs);

            } 
            else 
            {
                card.classList.remove('selected');
                var index = selected_blogs.indexOf(id);
                selected_blogs.splice(index,1);

                console.log(selected_blogs);
            }
        });
        modalRow.appendChild(card);

        if (hasPending)
        {
            if (pending_book[letter.toUpperCase()].includes(id))
            {
                card.classList.add('selected');
                selected_blogs.push(id);
            }
        }
        else
        {
            if (current_book[letter.toUpperCase()].includes(id))
            {
                //console.log('Contains Blog: '+id);
                card.classList.add('selected');
                selected_blogs.push(id);
                //console.log(selected_blogs);
            }
        }
        
    }
}

function createBookCard(book = null, isblank = false)
{
    const card = document.createElement("div");
    const cardHeader = document.createElement("div");
    const cardBody = document.createElement("div");
    const cardImage = document.createElement("img");
    const cardLink = document.createElement("a");

    switch (isblank) 
    {
        case false:
            normal();
            break;
        
        case true:
            blank();
            break;
    }
    
    function normal()
    {
        card.className = 'card bar-card';
        card.id = `${book.title}`;
        cardHeader.className = "card-header";
        cardHeader.innerHTML = `${book.title}`;
        cardBody.className = "card-body";
        cardImage.id = 'book-img';
        cardImage.className = "card-img";
        cardImage.src = "images/blank-book.png";
        cardLink.id = `link-${book.title}`;
        cardLink.className = 'stretched-link';
        //cardLink.onclick = function () { displayGrid(book) };
        cardLink.addEventListener('click', function (e) {
            displayGrid(book);
        });
        cardLink.addEventListener('click', function (e) {
            toggleCard(card, 'book');
        });
        card.appendChild(cardHeader);
        card.appendChild(cardBody);
        cardBody.appendChild(cardImage);
        cardBody.appendChild(cardLink);
        booksRow.appendChild(card);
    }

    function blank()
    {
        card.className = 'card bar-card';
        card.id = 'new-book'
        cardBody.className = "card-body";
        cardImage.className = "card-img";
        cardImage.id = 'blank-bar';
        cardImage.src = "images/add.png";
        cardLink.className = 'stretched-link';
        cardLink.setAttribute('data-bs-target', "#new-book-modal");
        cardLink.setAttribute('data-bs-toggle', "modal");
        cardLink.addEventListener("click", function (e) {
            
        })
        card.appendChild(cardBody);
        cardBody.appendChild(cardImage);
        cardBody.appendChild(cardLink);
        booksRow.appendChild(card);
    }
}

function updateSelectedCard(blogCount)
{
    var bId = selected_blogs[0];
    var letter = selected_letter;
    var blog = getBlogById(bId);
    let entry = possible_entries[letter];

    const card = document.createElement("div");
    const cardHeader = document.createElement("div");
    const cardBody = document.createElement("div");
    const cardImage = document.createElement("img");
    const cardLink = document.createElement("a");

    switch (blogCount)
    {
        case 0:
            none();
            break;

        case 1:
            single();
            break;

        default:
            multi();
            break;

    }

    function none()
    {
        card.className = 'card a-grid';
        card.id = `${letter}-blank`;
        cardHeader.className = "card-header";
        cardHeader.innerHTML = `${letter} | Add Entry`;
        cardBody.className = "card-body";
        cardImage.className = "card-img";
        cardImage.id = 'blank';
        cardImage.src = "images/blank-image.png";
        cardLink.className = 'stretched-link';
        cardLink.setAttribute('data-bs-target', "#abook-modal");
        cardLink.setAttribute('data-bs-toggle', "modal");
        cardLink.addEventListener('click', function (e) {
            toggleCard(card, "blog");
            displayAvailableBlogs(letter, true);
        });
        card.appendChild(cardHeader);
        card.appendChild(cardBody);
        card.classList.add('selected');
        cardBody.appendChild(cardImage);
        cardBody.appendChild(cardLink);
        if (entry != undefined) {
            const multiNum = document.createElement('div');
            multiNum.className = "entry-count-badge";
            multiNum.innerHTML = `${entry.length} Available`
            card.appendChild(multiNum);
        }
        selected_card.replaceWith(card);
    }

    function single()
    {
        var imgSrc;
        if (blog.images.length != 0) {
            imgSrc = `images/${blog.blog_id}/${blog.images[0]}`;
        } else {
            imgSrc = "images/blank-image.png";
            cardImage.id = 'blank';
        }
        card.className = 'card a-grid';
        card.id = blog.title[0];
        cardHeader.className = "card-header";
        cardHeader.innerHTML = `${blog.title}`;
        cardBody.className = "card-body";
        cardImage.className = "card-img";
        cardImage.src = imgSrc;
        cardLink.className = 'stretched-link';
        cardLink.setAttribute('data-bs-target', "#abook-modal");
        cardLink.setAttribute('data-bs-toggle', "modal");
        cardLink.addEventListener('click', function (e) {
            toggleCard(card, "blog");
            displayAvailableBlogs(card.id, true);
        });
        card.appendChild(cardHeader);
        card.appendChild(cardBody);
        card.classList.add('selected');
        cardBody.appendChild(cardImage);
        cardBody.appendChild(cardLink);
        if (entry != undefined) {
            const multiNum = document.createElement('div');
            multiNum.className = "entry-count-badge";
            multiNum.innerHTML = `${entry.length} Available`
            card.appendChild(multiNum);
        }
        selected_card.replaceWith(card);
    }

    function multi()
    {
        var imgSrc;
        if (blog.images.length != 0) {
            imgSrc = `images/${blog.blog_id}/${blog.images[0]}`;
        } else {
            imgSrc = "images/blank-image.png";
            cardImage.id = 'blank';
        }
        const multiNum = document.createElement('div');
        multiNum.className = "nested-count-badge";
        multiNum.innerHTML = `${blogCount} Nested`
        var headerText = `${blog.title}`;
        card.className = 'card a-grid';
        card.id = blog.title[0];
        cardHeader.className = "card-header";
        cardHeader.innerHTML = headerText;
        cardBody.className = "card-body";
        cardImage.className = "card-img";
        cardImage.src = imgSrc;
        cardLink.className = 'stretched-link';
        cardLink.setAttribute('data-bs-target', "#abook-modal");
        cardLink.setAttribute('data-bs-toggle', "modal");
        cardLink.addEventListener('click', function (e) {
            toggleCard(card, "blog");
            displayAvailableBlogs(card.id, true);
        });
        card.appendChild(cardHeader);
        card.appendChild(cardBody);
        card.appendChild(multiNum);
        card.classList.add('selected');
        cardBody.appendChild(cardImage);
        cardBody.appendChild(cardLink);
        if (entry != undefined) {
            const multiNum = document.createElement('div');
            multiNum.className = "entry-count-badge";
            multiNum.innerHTML = `${entry.length} Available`
            card.appendChild(multiNum);
        }
        selected_card.replaceWith(card);
    }
}

/**
 * Dynamically creates printing elements for given blogs
 * and appends them to the body of the page.
 * 
 * CSS styling hides all elements in the body that
 * do not have or aren't children of the .printable class
 * when printing.
 * 
 * Will automatically clear the body of print elements
 * after the menu has been called.
 */
const printBook = () => {
    const printContainer = document.createElement("div");
    printContainer.classList.add("printable");
    
    document.body.appendChild(printContainer);
    
    /**
     * To get this to work, all you need to do is call the
     * createPage function and pass a blog_id for all of the
     * blogs selected for printing.
     * 
     * Issues with the print layout can be caused by the margins
     * of higher order elements.
     */
    var elements = Object.assign({}, current_book);
    var bookTitle = elements["title"];
    delete elements["title"];
    for (const letter in elements) {
        const idArr = elements[letter];
        if (idArr != "") {
            idArr.forEach(blog_id => {
                createPage(blog_id);
            });
        }
    }

    window.print();
    document.body.removeChild(printContainer);

    /**
     * 
     * 
     * @param {*} blog_id ID of the blog chosen for printing.
     */
    function createPage(blog_id)
    {
        const blog = getBlogById(blog_id);
        var imgSrc;
        if (blog.images.length != 0) {
            imgSrc = `images/${blog_id}/${blog.images[0]}`
        } else {
            imgSrc = "images/photoABCDLogo.png";
        }

        const printElement = document.createElement('div');
        printElement.classList.add("printelement");

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

        const printBody = document.createElement('div');
        printBody.className = "print-body";

            const blogImage = document.createElement('img');
            blogImage.src = imgSrc;

            printBody.appendChild(blogImage);


        const printFooter = document.createElement('div');
        printFooter.className = "print-footer";
            const blogDesc = document.createElement("p");
            blogDesc.innerHTML = blog.description;

            printFooter.appendChild(blogDesc);

        printElement.appendChild(printHeader);
        printElement.appendChild(printBody);
        printElement.appendChild(printFooter);
        printContainer.appendChild(printElement);
    }
    
};

bookPrintBtn.addEventListener("click", () => {
    printBook();
});

// Grid Modal Confirm & Cancel
const gridConfirmBtn = document.getElementById("confirm-selection-button");
gridConfirmBtn.addEventListener("click", function (e) {
    updatePending();
    //selected_card.classList.remove("selected");
    selected_letter = undefined;
    selected_blogs = [];
    selected_card = undefined;
    initialEntries = 0;
    setProgress();
})

const gridCancelBtn = document.getElementById("cancel-selection-button");
gridCancelBtn.addEventListener("click", function (e) {
    selected_letter = undefined;
    selected_blogs = [];
    selected_card.classList.remove("selected");
    selected_card = undefined;
    initialEntries = 0;
})

// New Book Modal Confirm
const newBookConfirmBtn = document.getElementById("newbook-confirm-button");
newBookConfirmBtn.addEventListener("click", function (e) {
    var newbookTitle = document.getElementById("newbook-title").value;
    newBook(newbookTitle);
})

// Edit Book Modal Toggle
const bookEditModalBtn = document.getElementById("edit-button");
bookEditModalBtn.addEventListener("click", function (e) {
    var title = current_book["title"][0];
    bookeditTitle.value = title;
})

// Book Edit Modal Confirm & Cancel
const bookConfirmBtn = document.getElementById("bookedit-confirm-button");
bookConfirmBtn.addEventListener("click", function (e) {
    const obj = {};
    obj['title'] = [bookeditTitle.value];
    Object.assign(pending_book, obj);
    bookeditTitle.value = "";
})

const bookCancelBtn = document.getElementById("bookedit-cancel-button");
bookCancelBtn.addEventListener("click", function (e) {
    bookeditTitle.value = "";
})