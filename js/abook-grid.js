const booksRow = document.getElementById('book-bar-row');
const alpha_grid = document.getElementById('alpha-grid-row');
const progBar = document.getElementById('progress-bar');
const progHeader = document.getElementById('prog-header');
const utilBar = document.getElementById('util-bar');

let user_books = [];
let user_blogs = [];
let current_book;
let pending_book;
var completion = 0;
var pending = 0;

/*
'actions/abook-get-user-books.php'
'actions/abook-get-user-blogs.php'
*/

init();

// Querying Functions

function init()
{
    Promise.all([fetchArr('actions/abook-get-user-books.php'), fetchArr('actions/abook-get-user-blogs.php')])
        .then(results => {
            user_books = results[0];
            user_blogs = results[1];

            //console.log(user_books);
            //console.log(user_blogs);

            displayBar();
        });
}

async function fetchArr(url)
{
    const response = await fetch(url);
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

async function updateBook()
{
    var str = JSON.stringify(pending_book);
    await fetch(`actions/abook-update-book.php`, 
    {
        method: 'POST',
        body: str
    })
    init();
}

async function deleteBook()
{
    var str = JSON.stringify(current_book);
    await fetch(`actions/abook-delete-book.php`, 
    {
        method: 'POST',
        body: str
    })
    current_book = null;
    init();
}

async function newBook()
{
    await fetch('actions/abook-new-book.php', {
        credentials:"same-origin"
    });
    
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

// Display Functions

/**
 * Sets the progress bar logic.
 * Displays progress and pending changes.
 */
function setProgress()
{
    var progress = ~~((completion / 26)*100);
    var pendStr = '';

    switch (pending) {
        case 0:
            break;
        case 1:
            pendStr = ` (Entry Pending)`;
            break;
        default:
            pendStr = ` (${pending} Entries Pending)`;
            break;
    }

    progBar.style.width = `${progress}%`;
    //progBar.innerHTML = progress;
        
    progHeader.innerHTML = `Book ${current_book.book_id} | ${progress}%${pendStr}`;
}

/**
 * Updates pending letter entry.
 * 
 * @param {string} str
 * Name of the card ID.
 * 
 * Example String: F:6
 */
function updateSlot(str)
{
    arr = [];

    // Seperate string into array.
    res = str.split(':');

    // Cast blog_id as a number.
    res[1] = Number(res[1]);
    arr.push(res);

    // Create value-pair object.
    pair = Object.fromEntries(arr);

    // Assign variable to letter.
    Object.assign(pending_book, pair);
    //console.log(current_book);
    
}

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
        createBarCard(book);
    });
    createBlankBarCard();

    if (user_books.length == 0) {
        noBookDisplay();

    } else if (user_books.length > 0 && current_book == null) {
        var firstBarCard = document.getElementById(`link-${user_books[0].book_id}`);
        firstBarCard.onclick();

    } else {
        var currentCard = document.getElementById(`link-${current_book.book_id}`);
        currentCard.onclick();
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
    completion = 0;
    pending = 0;
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
    completion = 0;
    pending = 0;
    current_book = book;
    pending_book = book;
    
    //console.log('Book before displayGrid: ', current_book);
    clearContainer(alpha_grid);

    // Creates new book object. Prevents overriding of current_book.
    var letters = Object.assign({}, book);
    delete letters['creator_email'];
    delete letters['book_id'];

    entries = Object.entries(letters);
    //console.log('Book after letter block: ', current_book);
    //console.log(entries);

    entries.forEach(pair => {
        var letter = pair[0];
        var blog_id = pair[1];
        //console.log(pair);

        // If blog is empty, create empty slot.
        
        if (blog_id === null) {
            createBlankGridCard(letter);
        } else {
            var blog = getBlogById(blog_id);
            if (blog != null) 
            {
                createGridCard(blog);
                completion++;
            } else {
                createBlankGridCard(letter);
            }
        }
    });

    setProgress();

    function getBlogById(id)
    {
        //console.log('searching');
        let result;
        user_blogs.forEach(blog => {
            if (blog.blog_id === id) {
                //console.log(blog);
                result = blog;
            } 
        });
        return result;
    }
}

function clearContainer(container)
{
    container.innerHTML = '';
}

// Card Behavior Functions

function displayAvailableBlogs(letter)
{
    const modalRow = document.getElementById('abook-modal-row');
    const modalBody = document.getElementById('abook-modal-body');
    const noBlogs = document.getElementById('no-blogs');

    clearContainer(modalRow);

    var hasEntries = false;

    user_blogs.forEach(blog => {
        if (blog.title[0] == letter) {
            if (!hasEntries)
            {
                hasEntries = true;
            }
            createGridCard(blog, modalRow, () => setCard(letter, blog));
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

function setCard(id, blog) 
{
    const cardRef = document.getElementById(`${id}-blank`);
    
    const card = document.createElement("div");
    card.className = 'card a-grid';
    card.id = `${blog.title[0]}:${blog.blog_id}`;

        const cardHeader = document.createElement("div");
        cardHeader.className = "card-header";
        cardHeader.innerHTML = `${blog.title}`;

        const cardBody = document.createElement("div");
        cardBody.className = "card-body";

            const cardImage = document.createElement("img");
            cardImage.className = "card-img";
            cardImage.src = `${blog.dir}${blog.images[0]}`;

            const cardLink = document.createElement("a");
            cardLink.className = 'stretched-link';
            cardLink.setAttribute('data-target', "#abook-modal");
            cardLink.setAttribute('data-toggle', "modal");
            //cardLink.href = '#';
            cardLink.onclick = function () { displayAvailableBlogs(card.id[0]) }

    card.appendChild(cardHeader);
    card.appendChild(cardBody);
    cardBody.appendChild(cardImage);
    cardBody.appendChild(cardLink);
    cardRef.replaceWith(card);
    pending++;
    setProgress();
    updateSlot(card.id);

}

// Card Creation Functions

function createBarCard(book) 
{
    const card = document.createElement("div");
    card.className = 'card bar-card';

        const cardHeader = document.createElement("div");
        cardHeader.className = "card-header";
        cardHeader.innerHTML = `Book ${book.book_id}`

        const cardBody = document.createElement("div");
        cardBody.className = "card-body";

            const cardImage = document.createElement("img");
            cardImage.id = 'book-img';
            cardImage.className = "card-img";
            cardImage.src = "../photo_abcd_A/images/blank-book.jpg";

            const cardLink = document.createElement("a");
            cardLink.id = `link-${book.book_id}`;
            cardLink.className = 'stretched-link';
            cardLink.onclick = function () { displayGrid(book) };

            
    card.appendChild(cardHeader);
    card.appendChild(cardBody);
    cardBody.appendChild(cardImage);
    cardBody.appendChild(cardLink);
    booksRow.appendChild(card);
}

function createGridCard(blog, container = alpha_grid, func = displayAvailableBlogs)
{
    const card = document.createElement("div");
    card.className = 'card a-grid';
    card.id = blog.title[0];

        const cardHeader = document.createElement("div");
        cardHeader.className = "card-header";
        cardHeader.innerHTML = `${blog.title}`;

        const cardBody = document.createElement("div");
        cardBody.className = "card-body";

            const cardImage = document.createElement("img");
            cardImage.className = "card-img";
            cardImage.src = `${blog.dir}${blog.images[0]}`;

            const cardLink = document.createElement("a");
            cardLink.className = 'stretched-link';
            cardLink.setAttribute('data-target', "#abook-modal");
            cardLink.setAttribute('data-toggle', "modal");
            //cardLink.href = '#';
            cardLink.onclick = function () { func(card.id) }
            
    card.appendChild(cardHeader);
    card.appendChild(cardBody);
    cardBody.appendChild(cardImage);
    cardBody.appendChild(cardLink);
    container.appendChild(card);

}

function createBlankBarCard()
{
    const card = document.createElement("div");
    card.className = 'card bar-card';
    card.id = 'new-book'

        const cardBody = document.createElement("div");
        cardBody.className = "card-body";

            const cardImage = document.createElement("img");
            cardImage.className = "card-img";
            cardImage.id = 'blank-bar';
            cardImage.src = "../photo_abcd_A/images/add.png";

            const cardLink = document.createElement("a");
            cardLink.className = 'stretched-link';
            //cardLink.href = '#'; // Create new book here.

            // Might add functionality later?
            cardLink.onclick = function () { newBook(); };
    
    card.appendChild(cardBody);
    cardBody.appendChild(cardImage);
    cardBody.appendChild(cardLink);
    booksRow.appendChild(card);
}

function createBlankGridCard(letter)
{
    const card = document.createElement("div");
    card.className = 'card a-grid';
    card.id = `${letter}-blank`;

        const cardHeader = document.createElement("div");
        cardHeader.className = "card-header";
        cardHeader.innerHTML = `${letter} | Add Entry`;

        const cardBody = document.createElement("div");
        cardBody.className = "card-body";

            const cardImage = document.createElement("img");
            cardImage.className = "card-img";
            cardImage.id = 'blank';
            cardImage.src = "../photo_abcd_A/images/blank-image.png";

            const cardLink = document.createElement("a");
            cardLink.className = 'stretched-link';
            cardLink.setAttribute('data-target', "#abook-modal");
            cardLink.setAttribute('data-toggle', "modal");
            //cardLink.href = `abook/${letter}`;
            //cardLink.href = `#`;
            cardLink.onclick = function () { displayAvailableBlogs(letter) };

            
    card.appendChild(cardHeader);
    card.appendChild(cardBody);
    cardBody.appendChild(cardImage);
    cardBody.appendChild(cardLink);
    alpha_grid.appendChild(card);
}
