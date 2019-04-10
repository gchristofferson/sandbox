<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Infinite Scroll</title>
    <style>
        #blog-posts {
            width: 700px;
        }

        .blog-post {
            border: 1px solid black;
            margin: 10px 10px 20px 10px;
            padding: 6px 10px;
        }

        #spinner {
            display: none;
        }
    </style>
</head>
<body>
<div id="blog-posts">

</div>

<div id="spinner">
    <img src="spinner.gif" width="50" height="50"/>
</div>

<div id="load-more-container">
    <button id="load-more">Load more</button>
</div>

<script>

    let container = document.getElementById('blog-posts');
    let load_more = document.getElementById('load-more');

    function showSpinner() {
        let spinner = document.getElementById("spinner");
        spinner.style.display = 'block';
    }

    function hideSpinner() {
        let spinner = document.getElementById("spinner");
        spinner.style.display = 'none';
    }

    function showLoadMore() {
        load_more.style.display = 'inline';
    }

    function hideLoadMore() {
        load_more.style.display = 'none';
    }
    
    function appendToDiv(div, new_html) {
        // Put the new HTML into a temp div
        // This causes browser to parse it as elements
        let temp = document.createElement('div');
        temp.innerHTML = new_html;
    }

    function loadMore() {

        showSpinner();
        hideLoadMore();

        let xhr = new XMLHttpRequest();
        xhr.open('GET', 'blog_posts.php?page=1', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                let result = xhr.responseText;
                console.log('Result: ' + result);

                hideSpinner();
                // append results to end of blog posts
                appendToDiv(container, result);

                showLoadMore();

            }
        };
        xhr.send();
    }

    load_more.addEventListener("click", loadMore);

    // Load even the first page with Ajax
    loadMore();
</script>

</body>
</html>
