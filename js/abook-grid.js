const booksRow = document.getElementById('book-bar-row');
const alpha_grid = document.getElementById('alpha-grid-row');
const modalRow = document.getElementById('abook-modal-row');
const modalBody = document.getElementById('abook-modal-body');
const progBar = document.getElementById('progress-bar');
const progBarPending = document.getElementById('progress-bar-pending');
const progBarRegress = document.getElementById('progress-bar-regress');
const progHeader = document.getElementById('prog-header');
const utilBar = document.getElementById('util-bar');

let user_books = [];
let user_blogs = [];

/**
 * Essentially just book states.
 * All book updates done by pending_book.
 */
let current_book;
let pending_book;

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

// Variables for progress bar logic.
var initialEntries = 0;
var completion = 0;
var pending = 0;
var regression = 0;

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

            console.log(user_books);
            console.log(user_blogs);

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
    const rows = strToBook(dataArr[0].value);
    return rows;

    function strToBook(str)
    {
        // Will all alphabet books.
        var bookArr = [];

        // Splits Books from abook string.
        var res = str.split("|");

        // For each book string in the array
        res.forEach((bookStr) => {
            // Add Book Object (Has key values value pairs)
            bookArr.push(
                // Creates Key Value Pair
                Object.fromEntries(
                    // Splits key value strings
                    bookStr.split("/")
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
    let str = "";
    for (let key in pending_book) {
        let value = pending_book[key].join(",");
        str += `${key}:${value}/`;
    }
    str = str.substring(0, str.length - 1);
    //console.log(str);

    await fetch(`actions/abook-update-book.php`, 
    {
        method: 'POST',
        body: str
    }).then(response => console.log(response.text()))
    
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

// Modal Functions

/**
 * Sets the progress bar logic.
 * Displays progress and pending changes.
 */
function setProgress()
{
    var progress = ~~(((completion-regression) / 26) * 100);
    var progressPending = ~~((pending / 26) * 100);
    var progressRegress = ~~(((regression - pending) / 26) * 100);
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
    progBarPending.style.width = `${progressPending}%`;
    progBarRegress.style.width = `${progressRegress}%`;
    //progBar.innerHTML = progress;
        
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
    console.log(postAmt);
    var obj = {};
    obj[selected_letter] = selected_blogs;

    Object.assign(pending_book, obj);
    selected_letter = undefined;
    selected_blogs = [];
    
    /**
     * Logic goes as follows:
     * Both the initial and post values will only
     * ever be 0 or greater than 0.
     */
  
    // If post amount is 0, card is reset. Doesn't matter what the initial is.
    if (postAmt == 0 && initialEntries > 0)
    {
        console.log("regress");
        regression++
    }
        
    // If post amount is greater 0 and initial is 0, can only increase.
    else if (postAmt > 0 && initialEntries == 0)
    {
        console.log("increase");
        pending++
    }
        
    // If both numbers are greater than 0, the value is only being replaced.
    else if (postAmt > 0 && initialEntries > 0)
    {
        console.log("reset");
        regression++
        pending++
    }

    // No changes. Should be made impossible to do in modal.
    // case postAmt == 0 && initialEntries == 0
            

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
    } else if (user_books.length > 0 && current_book == null) {
        var bookCard = document.getElementById(`${user_books[0].title}`);
        toggleCard(bookCard);
        //firstBarCard.click
        displayGrid(user_books[0]);

    } else {
        //var currentCard = document.getElementById(`link-${current_book.title}`);
        //currentCard.onclick();
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
    regression = 0;
    current_book = book;
    pending_book = book;
    clearContainer(alpha_grid);

    // Creates new book object. Prevents overriding of current_book.
    var letters = Object.assign({}, book);
    delete letters['title'];

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
                    completion++;
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
                completion++;
                break;
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
    selected_letter = letter;

    // Initial number of entries defined by book.
    initialEntries = current_book[letter].filter(value => (value != "")).length;
    console.log(initialEntries);

    const noBlogs = document.getElementById('no-blogs');
    clearContainer(modalRow);

    var hasEntries = false;
    user_blogs.forEach(blog => {
        if (blog.title[0] == letter) {
            if (!hasEntries)
            {
                hasEntries = true;
            }
            createBlogCard(blog, 'modal');
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

/**
 * Replaces the card in the grid.
 * Does not perform queries.
 * 
 * @param {*} id 
 * @param {*} blog 
 */
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
    updatePending(card.id);

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

        case 'multi':
            multi();
            break;

    }

    function blank()
    {
        var letter = blogOrChar;
        card.className = 'card a-grid';
        card.id = `${letter}-blank`;
        cardHeader.className = "card-header";
        cardHeader.innerHTML = `${letter} | Add Entry`;
        cardBody.className = "card-body";
        cardBody.style.backgroundColor = "lightgray";
        cardImage.className = "card-img";
        cardImage.id = 'blank';
        cardImage.src = "../photo_abcd_A/images/blank-image.png";
        cardLink.className = 'stretched-link';
        cardLink.setAttribute('data-target', "#abook-modal");
        cardLink.setAttribute('data-toggle', "modal");
        //cardLink.onclick = function () { displayAvailableBlogs(letter) };
        cardLink.addEventListener('click', function (e) {
            toggleCard(card, "blog");
            displayAvailableBlogs(letter);
        });
        card.appendChild(cardHeader);
        card.appendChild(cardBody);
        cardBody.appendChild(cardImage);
        cardBody.appendChild(cardLink);
        alpha_grid.appendChild(card);
    }

    function grid()
    {
        var blog = blogOrChar;
        card.className = 'card a-grid';
        card.id = blog.title[0];
        cardHeader.className = "card-header";
        cardHeader.innerHTML = `${blog.title}`;
        cardBody.className = "card-body";
        cardImage.className = "card-img";
        cardImage.src = `${blog.dir}${blog.images[0]}`;
        cardLink.className = 'stretched-link';
        cardLink.setAttribute('data-target', "#abook-modal");
        cardLink.setAttribute('data-toggle', "modal");
        cardLink.addEventListener('click', function (e) {
            toggleCard(card, "blog");
            displayAvailableBlogs(card.id);
        });
        card.appendChild(cardHeader);
        card.appendChild(cardBody);
        cardBody.appendChild(cardImage);
        cardBody.appendChild(cardLink);
        alpha_grid.appendChild(card);
    }

    function multi()
    {
        var blogArr = blogOrChar;
        var blog = blogArr[0];
        const multiNum = document.createElement('div');
        multiNum.className = "multi-num";
        multiNum.innerHTML = `${blogArr.length}+`
        var headerText = `${blog.title}`;
        card.className = 'card a-grid';
        card.id = blog.title[0];
        cardHeader.className = "card-header";
        cardHeader.innerHTML = headerText;
        cardBody.className = "card-body";
        cardImage.className = "card-img";
        cardImage.src = `${blog.dir}${blog.images[0]}`;
        cardLink.className = 'stretched-link';
        cardLink.setAttribute('data-target', "#abook-modal");
        cardLink.setAttribute('data-toggle', "modal");
        cardLink.addEventListener('click', function (e) {
            toggleCard(card, "blog");
            displayAvailableBlogs(card.id);
        });
        card.appendChild(cardHeader);
        card.appendChild(cardBody);
        card.appendChild(multiNum);
        cardBody.appendChild(cardImage);
        cardBody.appendChild(cardLink);
        alpha_grid.appendChild(card);
    }

    function multi2()
    {
        var blogArr = blogOrChar;
        const cardInner = document.createElement("div");
            cardInner.className = "carousel-inner";
        card.className = 'carousel slide card a-grid';
        card.setAttribute("data-ride", "carousel");
        card.id = blogArr[0].title[0];
        let firstEl = true;
        blogArr.forEach(blog => 
        {
            const caroItem = document.createElement("div");
            caroItem.className = "carousel-item";
            if (firstEl == true) {
                firstEl = false;
                caroItem.classList.add("active");
            }
                const cardCaroHeader = document.createElement("div");
                    cardCaroHeader.className = "card-header";
                    cardCaroHeader.innerHTML = `${blog.title}`;
                const cardCaroBody = document.createElement("div");
                    cardCaroBody.className = "card-body";
                    const cardCaroImage = document.createElement("img");
                        cardCaroImage.className = "card-img";
                        cardCaroImage.src = `${blog.dir}${blog.images[0]}`;
                        cardCaroBody.appendChild(cardCaroImage);
                caroItem.appendChild(cardCaroHeader);
                caroItem.appendChild(cardCaroBody);
            cardInner.appendChild(caroItem);
        });
        cardLink.className = 'stretched-link';
        cardLink.setAttribute('data-target', "#abook-modal");
        cardLink.setAttribute('data-toggle', "modal");
        cardLink.addEventListener('click', function (e) {
            displayAvailableBlogs(card.id);
        });
        cardInner.appendChild(cardLink);
        card.appendChild(cardInner);
        alpha_grid.appendChild(card);
        
    }

    function modal()
    {
        var blog = blogOrChar;
        const letter = blog.title[0];
        const id = blog.blog_id;
        card.className = 'card a-grid';
        card.id = blog.title[0];
        cardHeader.className = "card-header";
        cardHeader.innerHTML = `${blog.title}`;
        cardBody.className = "card-body";
        cardImage.className = "card-img";
        cardImage.src = `${blog.dir}${blog.images[0]}`;
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

        if (current_book[letter].includes(id))
        {
            //console.log('Contains Blog: '+id);
            card.classList.add('selected');
            selected_blogs.push(id);
            //console.log(selected_blogs);
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
        cardImage.src = "../photo_abcd_A/images/blank-book.jpg";
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
        cardImage.src = "../photo_abcd_A/images/add.png";
        cardLink.className = 'stretched-link';
        cardLink.onclick = function () { newBook(); };
        card.appendChild(cardBody);
        cardBody.appendChild(cardImage);
        cardBody.appendChild(cardLink);
        booksRow.appendChild(card);
    }
}

// Modal Confirm
const confirmBtn = document.getElementById("confirm-selection-button");
confirmBtn.addEventListener("click", function (e) {
    updatePending();
    //selected_card.classList.remove("selected");
    selected_card = undefined;
    initialEntries = 0;
    setProgress();
})

// Modal Cancel
const cancelBtn = document.getElementById("cancel-selection-button");
cancelBtn.addEventListener("click", function (e) {
    selected_letter = undefined;
    selected_blogs = [];
    selected_card.classList.remove("selected");
    selected_card = undefined;
    initialEntries = 0;
})
