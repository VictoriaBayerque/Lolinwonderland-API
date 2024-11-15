"use strict"

const apiUrl = 'http://localhost/Web2/3er-entrega/api/';
let library = [];
let authors = [];

////////////////////////////////////////////////////////////////////////
///------------------------------ HOME ------------------------------///
///////////////////////////////////////////////////////////////////////

document.addEventListener('DOMContentLoaded', home());

async function home() {

    try {
        const response = await fetch('http://localhost/Web2/3er-entrega/home.html');

        if(!response.ok) {
            throw new Error('Home could not be loaded.');
        }

        const home = await response.text();
        let mainHTML = document.querySelector('#main');
        mainHTML.innerHTML = home;
    } catch (error) {
        console.log(error);
    }
    
}

const libraryBTN = document.querySelector('.libraryBtn');
libraryBTN.addEventListener('click', (e) => {
    e.preventDefault();
    getLibrary();
})
const authorsBTN = document.querySelector('.authorsBtn');
authorsBTN.addEventListener('click', (e) => {
    e.preventDefault();
    getAuthors();
})

///////////////////////////////////////////////////////////////////////////
///------------------------------ LIBRARY ------------------------------///
//////////////////////////////////////////////////////////////////////////

async function getLibrary(orderby = null) {
    if(orderby !== null) {
        try {
            const responseLibrary = await fetch(apiUrl + 'library?order=' + orderby);
    
            if(!responseLibrary.ok) {
                throw new Error('There was an error. Library could have not been listed.');
            }
            library = await responseLibrary.json();
    
        } catch (error) {
            console.log(error);
        }
    } else {
        try {

            const responseLibrary = await fetch(apiUrl + 'library');
            if(!responseLibrary.ok) {
                throw new Error('There was an error. Library could have not been listed.');
            }

            library = await responseLibrary.json();

        } catch (error) {

            console.log(error);

        }
    }
    const responseAuthors = await fetch(apiUrl + 'authors');
    
    if(!responseAuthors.ok) {
        throw new Error('There was an error. Authors could have not been listed.');
    }

    authors = await responseAuthors.json();

    displayLibrary(orderby);
}

function sliceSummary (summary) {
    if (summary.length > 130) {
        let sliced = summary.slice(0, 130) + '...';
        return sliced;
    } else{
        return summary;
    }
}

async function displayLibrary(orderby = null) {
    let bigBox = "";
    try {

        const r = await fetch('library.html');

        if(!r.ok) {
            throw new Error('Library container could not be loaded.');
        }

        bigBox = await r.text();

    } catch (error) {

        console.log(error);

    }
    
    let main = document.querySelector('#main');
    main.innerHTML = bigBox;

    const title = document.querySelector('.orderTitle');
    title.style.display = 'block';
    const titleSpan = document.querySelector('.orderSpan');
    titleSpan.innerHTML = orderby;

    if(orderby == null) {
        title.style.display = 'none';
    }

    let libraryContainer = document.querySelector('#library-container');
    

    for (const book of library) {

        let authorName = "";

        for (const author of authors) {

            if(author.author_id === book.book_authorid) {
                authorName = author.author_name;
            }

        }
        let sum = sliceSummary(book.book_summary);
        
        let newhtml = `
            <div class="card col-4" style="width: 18rem; height: 30rem; margin-bottom: 1rem;">
                <img
                class="card-img"
                style="height: 12rem;"
                src="public/statics/images/books/${book.book_img}"
                alt="Card image">
                <div
                class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title">
                            ${book.book_name}
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            ${authorName}
                            - Series: ${book.book_series}
                        </h6>
                        <p class="card-text">
                        ${sum}
                        </p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <a
                        href="#"
                        data-book="${book.book_id}"
                        class="readBook-btn more-btn"
                        style="
                        background-color: rgb(165, 56, 107);
                        padding: 0.3rem;
                        padding-left: 0.5rem;
                        padding-right: 0.5rem;
                        border-radius: 0.4rem;
                        color: white;
                        ">
                            Read more
                        </a>
                        <!-- <?php if(isset($_SESSION['username'])): ?> -->
                            <div>
                                <a data-book="${book.book_id}" class="card-link edit-btn">
                                    Editar
                                </a>
                                <a data-book="${book.book_id}" class="card-link delete-btn">
                                    Borrar
                                </a>
                            </div>
                        <!-- <?php endif; ?> -->
                    </div>
                </div>
            </div>
        `;

        libraryContainer.innerHTML += newhtml;

    }
    const addBookBtn = `
        </br>
        <div
        class="container d-flex justify-content-center"
        style="padding-top: 3rem; padding-bottom: 3rem;">
            <a
            class="add-btn"
            style="
            background-color: rgb(165, 56, 107);
            padding: 0.3rem;
            padding-left: 0.5rem;
            padding-right: 0.5rem;
            border-radius: 0.4rem;
            color: white;
            ">
                Add new book
            </a>
        </div>
    `;

    libraryContainer.innerHTML += addBookBtn;

    const addBookBTN = document.querySelector('.add-btn');
    addBookBTN.addEventListener('click', (e) => {
        e.preventDefault();
        displayAddBookForm();
    });

    const moreBTN = document.querySelectorAll('.more-btn');
    for (const btn of moreBTN) {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            let bookID = btn.getAttribute('data-book');
            readMore(bookID);
        });
    }

    const deleteBookBTN = document.querySelectorAll('.delete-btn');
    for (const btn of deleteBookBTN) {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            let bookID = btn.getAttribute('data-book');
            deleteBook(bookID);
        });
    }

    const editBookBTN = document.querySelectorAll('.edit-btn');
    for (const btn of editBookBTN) {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            let bookID = btn.getAttribute('data-book');
            displayEditForm(bookID);
        });
    }

    const orderBySelect = document.querySelector('#orderBy');
    if(orderBySelect !== null) {
        orderBySelect.addEventListener('change', (e) => {
            e.preventDefault();
            if (
                orderBySelect.value === 'name' ||
                orderBySelect.value === 'author' ||
                orderBySelect.value === 'series'
            ) {
                getLibrary(orderBySelect.value);
            }
        });
    }
    
}

////////////////////////////////////////////////////////////////////////
///------------------------------ FORMS ------------------------------///
////////////////////////////////////////////////////////////////////////

async function displayAddBookForm() {

    try {

        const response = await fetch('form_addbook.html');

        if(!response.ok) {
            throw new Error('The form to add a new book could have not been displayed.');
        }

        const form = await response.text();
        document.querySelector('#main').innerHTML = form;
        await authorsSelect();
        
        const addBookForm = document.querySelector('#addbook-form');
        
        addBookForm.addEventListener('submit', (e) => {
            e.preventDefault();
            submitBook(addBookForm)
        });
        document.querySelector('.goBack-form').addEventListener('click', (e) => {
            e.preventDefault();
            getLibrary();
        });

    } catch (error) {

        console.log(error);

    }
}

async function authorsSelect() {
    
    let authorsSelect = "";

    try {

        for(const author of authors) {
            let newhtml = `
            <option value="${author.author_id}">
                ${author.author_name}
            </option>`;
            authorsSelect += newhtml;
        }

        document.querySelector('.authorsSelect').innerHTML = authorsSelect;

    } catch (error) {

        console.log(error);

    }
    
}

async function displayEditForm(id) {
    const bookID = id;
    let book;
    try {

        const r = await fetch(apiUrl + 'library/' + id);
        if(!r.ok) {
            throw new Error('The book could not be found.');
        }
        book = await r.json();

    } catch (error) {

        console.log(error);

    }

    let page = `
        <div class="container justify-content-center" style="width: 40%;">
            <form
            id="editBook"
            method="POST"
            enctype="multipart/form-data">

                <div class="form-group">
                    <label style="font-weight: bold;">Book's name</label>
                    <input
                    type="text"
                    class="form-control"
                    name="book_name"
                    value="${book.book_name}">
                </div>
                <br>
                <div class="form-group">
                    <label style="font-weight: bold;">Select the author</label>
                    <select
                    class="form-control form-control-lg authorsSelect"
                    name="book_authorid"
                    value="${book.book_authorid}">
                        
                    </select>
                </div>
                <br>
                <div class="form-group">
                    <label style="font-weight: bold;">Series</label>
                    <input
                    type="text"
                    class="form-control"
                    name="book_series"
                    value="${book.book_series}">
                </div>
                <br>
                <div class="form-group">
                    <label style="font-weight: bold;">Number of the book in the series</label>
                    <input
                    type="number"
                    class="form-control"
                    name="book_seriesnumber"
                    value="${book.book_seriesnumber}">
                </div>
                <br>
                <div class="form-group">
                    <label style="font-weight: bold;">Book's summary</label>
                    <textarea
                    type="textarea"
                    class="form-control"
                    name="book_summary">${book.book_summary}</textarea>
                </div>
                <div class="d-flex justify-content-center" style="margin-top: 5rem;">
                    <button
                    type="submit"
                    name="submit"
                    style="
                    background-color: rgb(165, 56, 107);
                    margin-right: 2rem;
                    margin-bottom: 4rem;
                    padding: 0.3rem;
                    padding-left: 0.5rem;
                    padding-right: 0.5rem;
                    border: 0px;
                    border-radius: 0.4rem;
                    color: white;
                    ">
                        Submit
                    </button>
                    <a
                    class="goBack-form">
                        Go back
                    </a>
                </div>
            </form>
        </div>
    `;

    let main = document.querySelector('#main');
    main.innerHTML = page;
    await authorsSelect();

    const editBookForm = document.querySelector('#editBook');
    editBookForm.addEventListener('submit', (e) => {
        e.preventDefault();
        saveBook(editBookForm, bookID);
    })

    document.querySelector('.goBack-form').addEventListener('click', (e) => {
        e.preventDefault();
        getLibrary();
    });

}

///////////////////////////////////////////////////////////////////////////////////
///------------------------------ LIBRARY ACTIONS ------------------------------///
///////////////////////////////////////////////////////////////////////////////////


async function submitBook(addBookForm) {
    
    let data = new FormData(addBookForm);
   
    if(data.get('book_img')) {
        data.append('book_img', data.get('book_img'));
    }

    try {

        let r = await fetch(
            apiUrl + 'library', {
                method: "POST",
                body: data
            }
        );
        if(!r.ok) {
            let errorText = await r.text();
            console.error('Server Error:', errorText);
            throw new Error('Server error');
        }
        let newBook = await r.text();

        console.log(newBook);
        
    } catch (error) {

        console.log(error);

    }
    getLibrary();
}

async function saveBook(editBookForm, bookID) {
    let data = new FormData(editBookForm);
    let book = {
        book_name: data.get('book_name'),
        book_authorid: data.get('book_authorid'),
        book_series: data.get('book_series'),
        book_seriesnumber: data.get('book_seriesnumber'),
        book_summary: data.get('book_summary'),
    };

    // if(data.get('book_img') && data.get('book_img').size === 0) {
    console.log(JSON.stringify(book));
    try {
        

        let r = await fetch(
            apiUrl + 'library/' + bookID, {
                method: "PUT",
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(book)
            }
        );
        
        if(!r.ok) {
            let respuesta = await r;
            console.log(respuesta);
            throw new Error('The book could not be updated.');
        }
        
        getLibrary();

    } catch (error) {

        console.log(error);

    }
    // } else {
    //     try {
    //         console.log(data.get('book_img'));
    //         const img = data.get('book_img');
    //         book.book_img = {
    //             name: img.name,
    //             tmp_name: img.lastModified,
    //             lastModifiedDate: img.lastModifiedDate,
    //             size: img.size,
    //             type: img.type,
    //         };
    //         let r = await fetch(
    //             apiUrl + 'library/' + bookID, {
    //                 method: "PUT",
    //                 headers: { 'Content-Type': 'application/json'},
    //                 body: JSON.stringify(book)
    //             }
    //         );
    //         let responseText = await r.text(); 
    //         console.log('Response from server:', responseText);
    //         if(!r.ok) {
    //             let errorText = await r.text();
    //             console.log('ERROR:', errorText);
    //             throw new Error('Server error');
    //         }
    //         // try {
    //         //     let editedBook = JSON.parse(responseText);
    //         //     console.log(editedBook);
    //         // } catch (jsonError) {
    //         //     console.error('Error parsing JSON:', jsonError);
    //         // }
            
            
    //     } catch (error) {

    //         console.log(error);

    //     }
    // }
}

async function deleteBook(id) {
    
    let response = await fetch(apiUrl + 'library/' + id, {method: 'DELETE'});
    if (!response.ok) {
        throw new Error('It cannot be deleted');
    }
    getLibrary();
}

async function readMore(id) {
    let book;
    let author;
    try {
        const response = await fetch(apiUrl + 'library/' + id);
        if(!response.ok) {
            throw new Error('The book could not be reached.');
        }
        book = await response.json();

        let authorID = book.book_authorid;
        const authorR = await fetch(apiUrl + 'authors/' + authorID);
        if(!authorR.ok) {
            throw new Error('The author could not be found.');
        }

        author = await authorR.json();
        
    } catch (error) {
        console.log(error);
    }
    
    let html = `
        <div class="container">
            <div class="card-body justify-content-center">
                <img
                class="card-img"
                src="public/statics/images/books/${book.book_img}"
                style="width: 30rem; max-height: 10rem;"
                alt="Card image">
                <div class="">
                    <h5 class="card-title">${book.book_name}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">${author.author_name}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Series: ${book.book_series} (book number ${book.book_seriesnumber} in the series)</h6>
                    <p class="card-text">${book.book_summary}</p>
                </div>
            </div>
            <div class="d-flex justify-content-end"style="margin-top: 4rem; margin-bottom: 5rem;">
                <a
                class="goBack"
                style="
                background-color: rgb(165, 56, 107);
                margin-right: 1rem;
                padding: 0.3rem;
                padding-left: 0.5rem;
                padding-right: 0.5rem;
                border-radius: 0.4rem;
                color: white;">
                    Library
                </a>
                <a
                class="more-btn"
                style="
                background-color: rgb(165, 56, 107);
                margin-right: 1rem;
                padding: 0.3rem;
                padding-left: 0.5rem;
                padding-right: 0.5rem;
                border-radius: 0.4rem;
                color: white;">
                    Author's profile
                </a>
            </div>
        </div>
    `;

    let box = document.querySelector('#main');
    box.innerHTML = html;

    document.querySelector('.goBack').addEventListener('click', (e) => {
        e.preventDefault();
        getLibrary();
    });
    document.querySelector('.more-btn').addEventListener('click', (e) => {
        e.preventDefault();
        knowMore(book.book_authorid);
    });

}

///////////////////////////////////////////////////////////////////////////
///------------------------------ AUTHORS ------------------------------///
//////////////////////////////////////////////////////////////////////////

async function getAuthors(orderby = null) {
    if(orderby) {
        try {
            const r = await fetch(apiUrl + 'authors?order=' + orderby);
            if(!r.ok) {
                throw new Error('The authors could have not been organized.');
            }
            authors = await r.json();
        } catch (error) {
            console.log(error);
        }
    } else {
        try {
            const r = await fetch(apiUrl + 'authors');
            if(!r.ok) {
                throw new Error('The authors could not be found.')
            }
            authors = await r.json();
        } catch (error) {
            console.log(error);
        }
    }

    displayAuthors(orderby);
}

async function displayAuthors(orderby) {
    let bigBox;
    try {
        const r = await fetch('authors.html');
        if(!r.ok) {
            throw new Error('The page could not be found.');
        }
        bigBox = await r.text();
    } catch (error) {
        console.log(error);
    }
    let main = document.querySelector('#main');
    main.innerHTML = bigBox;

    const title = document.querySelector('.orderTitle');
    title.style.display = 'block';
    const spanTitle = document.querySelector('.orderSpan');
    spanTitle.innerHTML = orderby;

    if(orderby == null) {
        title.style.display = 'none';
    }

    let authorsContainer = document.querySelector('#authors-container');

    for (const author of authors) {
        let html = `
            <div class="card col-4" style="width: 18rem; height: 25rem; margin-bottom: 1rem;">
                <img
                class="card-img"
                style="height: 12rem;"
                src="public/statics/images/authors/${author.author_img}"
                alt="Card image">
                <div
                class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title">
                            ${author.author_name}
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            ${author.author_age} years old.
                        </h6>
                        <h6 class="card-subtitle mb-2 text-muted">
                            Active since ${author.author_activity}.
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <a
                        data-author="${author.author_id}"
                        class="more-btn"
                        style="
                        background-color: rgb(165, 56, 107);
                        padding: 0.3rem;
                        padding-left: 0.5rem;
                        padding-right: 0.5rem;
                        border-radius: 0.4rem;
                        color: white;
                        ">
                            Know more
                        </a>
                        <!-- <?php if(isset($_SESSION['username'])): ?> -->
                            <div>
                                <a data-author="${author.author_id}" class="card-link edit-btn">
                                    Editar
                                </a>
                                <a data-author="${author.author_id}" class="card-link delete-btn">
                                    Borrar
                                </a>
                            </div>
                        <!-- <?php endif; ?> -->
                    </div>
                </div>
            </div>
        `;
        authorsContainer.innerHTML += html;
    }

    const addAuthorBtn = `
        </br>
        <div
        class="container d-flex justify-content-center"
        style="padding-top: 3rem; padding-bottom: 3rem;">
            <a
            class="add-btn"
            style="
            background-color: rgb(165, 56, 107);
            padding: 0.3rem;
            padding-left: 0.5rem;
            padding-right: 0.5rem;
            border-radius: 0.4rem;
            color: white;
            ">
                Add new author
            </a>
        </div>
    `;

    authorsContainer.innerHTML += addAuthorBtn;

    let moreBTN = document.querySelectorAll('.more-btn');
    for (const btn of moreBTN) {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const authorID = btn.getAttribute('data-author');
            knowMore(authorID);
        });
    }
    
    
    let editBTN = document.querySelectorAll('.edit-btn');
    for (const btn of editBTN) {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const authorID = btn.getAttribute('data-author');
            displayEditAuthorForm(authorID);
        });
    }

    let deleteBTN = document.querySelectorAll('.delete-btn');
    for (const btn of deleteBTN) {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const authorID = btn.getAttribute('data-author');
            deleteAuthor(authorID);
        });
    }

    const addAuthorBTN = document.querySelector('.add-btn');
    addAuthorBTN.addEventListener('click', (e) => {
        e.preventDefault();
        displayAddAuthorForm();
    });

    const authorsSelect = document.querySelector('#orderByAuthors');
    if(authorsSelect !== null) {
        authorsSelect.addEventListener('change', (e) => {
            e.preventDefault();
            if(
                authorsSelect.value === 'name' ||
                authorsSelect.value === 'age' ||
                authorsSelect.value === 'activity'
            ) {
                getAuthors(authorsSelect.value);
            }
       });
    }
}

////////////////////////////////////////////////////////////////////////
///------------------------------ FORMS ------------------------------///
////////////////////////////////////////////////////////////////////////

async function displayAddAuthorForm() {

    try {

        const response = await fetch('form_addauthor.html');

        if(!response.ok) {
            throw new Error('The form to add a new author could have not been displayed.');
        }

        const form = await response.text();
        document.querySelector('#main').innerHTML = form;
        
        const addAuthorForm = document.querySelector('#addauthor-form');
        
        addAuthorForm.addEventListener('submit', (e) => {
            e.preventDefault();
            submitAuthor(addAuthorForm)
        });
        const goBack = document.querySelector('.goBack-form');
        goBack.addEventListener('click', (e) => {
            e.preventDefault();
            getAuthors();
        });

    } catch (error) {

        console.log(error);

    }
}
async function displayEditAuthorForm(id) {
    const main = document.querySelector('#main');
    let author;
    try {
        const r = await fetch(apiUrl + 'authors/' + id);
        if(!r.ok) {
            throw new Error('The author could not be found.');
        }
        author = await r.json();
    } catch (error) {
        console.log(error);
    }

    let html = `
        <div class="container justify-content-center" style="width: 40%;">
            <form
            id="editauthor-form"
            method="POST"
            enctype="multipart/form-data">

                <div class="form-group">
                    <label style="font-weight: bold;">Author's name</label>
                    <input
                    type="text"
                    class="form-control"
                    name="author_name"
                    value="${author.author_name}">
                </div>
                <br>
                <div class="form-group">
                    <label style="font-weight: bold;">Author's age</label>
                    <input
                    type="number"
                    class="form-control"
                    name="author_age"
                    value="${author.author_age}">
                </div>
                <br>
                <div class="form-group">
                    <label style="font-weight: bold;">Author's activity</label>
                    <input
                    type="text"
                    class="form-control"
                    name="author_activity"
                    value="${author.author_activity}">
                </div>
                <div class="d-flex justify-content-center" style="margin-top: 2rem;">
                    <button
                    type="submit"
                    name="submit"
                    style="
                    background-color: rgb(165, 56, 107);
                    margin-bottom: 5rem;
                    margin-right: 2rem;
                    padding: 0.3rem;
                    padding-left: 0.5rem;
                    padding-right: 0.5rem;
                    border: 0px;
                    border-radius: 0.4rem;
                    color: white;
                    ">
                        Submit
                    </button>
                    <a
                    class="goBack-form">
                        Go back
                    </a>
                </div>
            </form>

        </div>
    `;
    main.innerHTML = html;
    const editAuthorForm = document.querySelector('#editauthor-form');
    editAuthorForm.addEventListener('submit', (e) => {
        e.preventDefault();
        saveAuthor(editAuthorForm, id);
    });
    const goBack = document.querySelector('.goBack-form');
    goBack.addEventListener('click', (e) => {
        e.preventDefault();
        getAuthors();
    });

}



///////////////////////////////////////////////////////////////////////////////////
///------------------------------ AUTHORS ACTIONS ------------------------------///
//////////////////////////////////////////////////////////////////////////////////

async function submitAuthor(addAuthorForm) {
    let data = new FormData(addAuthorForm);
   
    try {
        for (let [key, value] of data.entries()) {
            console.log(`${key}: ${value}`);
        }
        let r = await fetch(
            apiUrl + 'authors', {
                method: "POST",
                body: data
            }
        );
        
        if(!r.ok) {
            let errorText = await r.text();
            console.error('Server Error:', errorText);
            throw new Error('Server error');
        }

        let newAuthor = await r.text();
        console.log(newAuthor);
        
    } catch (error) {
        console.log(error);
    }

    getAuthors();
}

async function deleteAuthor(id) {
    try {
        const r = await fetch(apiUrl + 'authors/' + id, { method: 'DELETE' });
        if(!r.ok) {
            throw new Error('The author could not be found.');
        }
        const deletedAuthor = await r.json();
        console.log(deletedAuthor);
    } catch (error) {
        console.log(error);
    }
    getAuthors();
}

async function saveAuthor(editAuthorForm, id) {
    const data = new FormData(editAuthorForm);
    let author = {
        author_name: data.get('author_name'),
        author_age: data.get('author_age'),
        author_activity: data.get('author_activity')
    };

    try {
        const r = await fetch(
            apiUrl + 'authors/' + id, {
                method: "PUT",
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(author)
            });
        console.log(author);
        if(!r.ok) {
            let errorText = await r.text();
            console.error('Server Error:', errorText);
            throw new Error('The author could not be updated.');
        }
    } catch (error) {
        console.log(error);
    }
    
    getAuthors();
}

function displayBooksByAuthor(books) {
    let bookHTML = "";
    let serie = [];
    for(const book of books) {
        if(!serie.includes(book.book_series)) {
            serie.push(book.book_series);
        }
    }
    for(const s of serie) {
        bookHTML += `
                    <div
                    class="
                        d-flex
                        justify-content-center"
                    style={
                    }>
                        <h5><span>${s}</span> series.</h5>
                    </div>
                    <div class="row justify-content-center">
                        
            `;

        for(const book of books)
            if(s === book.book_series) {
                bookHTML += `
                    <div class="card col-4" style="width: 20rem; height: 20rem; margin-bottom: 1rem;">
                        <img
                        class="card-img"
                        style="height: 12rem;"
                        src="public/statics/images/books/${book.book_img}"
                        alt="Card image">
                        <div
                        class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title">
                                    ${book.book_name}
                                </h5>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    Book number ${book.book_seriesnumber} in the series.
                                </h6>
                            </div>
                            <div class="d-flex justify-content-end mb-2">
                                <a
                                data-book="${book.book_id}"
                                class="readBook-btn"
                                style="
                                background-color: rgb(165, 56, 107);
                                padding: 0.3rem;
                                padding-left: 0.5rem;
                                padding-right: 0.5rem;
                                border-radius: 0.4rem;
                                color: white;
                                ">
                                    +
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            }
        bookHTML += `</div>`;
    }

    return bookHTML;
}

async function knowMore(id) {
    let author;
    let books;

    try {
        const r = await fetch(apiUrl + 'authors/' + id);
        if(!r.ok) {
            throw new Error('The author could not be loaded.');
        }
        author = await r.json();
    } catch (error) {
        console.log(error);
    }

    try {
        const r = await fetch(apiUrl + 'library?author=' + id + '&order=series');
        if(!r.ok) {
            throw new Error('The books could not be loaded.');
        }
        books = await r.json();
    } catch (error) {
        console.log(error);
    }
    let bookHTML = displayBooksByAuthor(books);
    
    let html = `
        <div class="container">
            <div class="card-body justify-content-center">
                <img
                class="card-img"
                src="public/statics/images/authors/${author.author_img}"
                style="width: 20rem;"
                alt="Card image">
                <div class="">
                    <h3 class="card-title"><span>${author.author_name}</span></h3>
                    <h6 class="card-subtitle mb-2 text-muted">${author.author_age} years old</h6>
                    <p class="card-text">Active since: ${author.author_activity}</p>
                </div>
                <div style="margin-top: 3rem;">
                    <h6><span>Libros</span> del autor: </h6>
                    <div>
                        ${bookHTML}
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end"style="margin-top: 4rem; margin-bottom: 5rem;">
                <a
                class="goBack"
                style="
                background-color: rgb(165, 56, 107);
                padding: 0.3rem;
                padding-left: 0.5rem;
                padding-right: 0.5rem;
                border-radius: 0.4rem;
                color: white;">
                    Go back
                </a>
            </div>
        </div>
    `;

    const main = document.querySelector('#main');
    main.innerHTML = html;

    const plusBTN = document.querySelectorAll('.readBook-btn');
    for(const btn of plusBTN) {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const bookID = btn.getAttribute('data-book');
            readMore(bookID);
        });
    }
    const goBack = document.querySelector('.goBack');
    goBack.addEventListener('click', (e) => {
        e.preventDefault();
        getAuthors();
    })
}


















{/* <div class="form-group">
    <label style="font-weight: bold;">Author's photo</label>
    <input
    type="file"
    name="author_img"
    id="">
</div>
<br> */}


// async function saveAuthor(editAuthorForm, id) {
//     const data = new FormData(editAuthorForm);
//     if(data.get('author_img') && data.get('author_img').size === 0) {
//         let image = null;
//         let author = {
//             author_name: data.get('author_name'),
//             author_age: data.get('author_age'),
//             author_activity: data.get('author_activity'),
//             author_img: image
//         };
    
//         try {
//             const r = await fetch(
//                 apiUrl + 'authors/' + id, {
//                     method: "PUT",
//                     headers: { 'Content-Type': 'application/json' },
//                     body: JSON.stringify(author)
//                 });
//             console.log(author);
//             if(!r.ok) {
//                 let errorText = await r.text();
//                 console.error('Server Error:', errorText);
//                 throw new Error('The author could not be updated.');
//             }
//         } catch (error) {
//             console.log(error);
//         }
//     } else {
//         try {
//             console.log('AUTOR');
//             console.log(data.get('author_img'));
//             for (let [key, value] of data.entries()) {
//                 console.log(`${key}: ${value}`);
//             }
//             const r = await fetch(
//                 apiUrl + 'authors/' + id, {
//                     method: "PUT",
//                     body: data
//                 });
            
//             if(!r.ok) {
//                 let errorText = await r.text();
//                 console.error('Server Error:', errorText);
//                 throw new Error('The author could not be updated.');
//             }
//         } catch (error) {
//             console.log(error);
//         }
//     }

    
//     getAuthors();
// }