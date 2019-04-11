// note: IE8 doesn't support DOMContentLoaded
document.addEventListener('DOMContentLoaded', function () {

    let suggestions = document.getElementById("suggestions");
    let form = document.getElementById("search-form");
    let search = document.getElementById("search");

    function suggestionsToList(items) {
        // <li><a href="search.php?q=alpha">Alpha</a></li>
        let output = '';
        for (let i = 0; i < items.length; i++) {
            output += '<li>';
            output += '<a href="search.php?q=' + items[i] + '">';
            output += items[i];
            output += '</a>';
            output += '</li>';
        }
        return output;
    }

    function showSuggestions(json) {
        let li_list = suggestionsToList(json);
        suggestions.innerHTML = li_list;
        suggestions.style.display = 'block';
    }

    function getSuggestions() {
        let q = search.value;
        if (q.length < 3) {
            suggestions.style.display = 'none';
            return;
        }
        let xhr = new XMLHttpRequest();
        xhr.open('GET', 'autosuggest.php?q=' + q, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let result = xhr.responseText;
                console.log('Result: ' + result);
                let json = JSON.parse(result);
                showSuggestions(json);
            }
        };
        xhr.send();
    }

    // use "input" (every key), not "change" (must lose focus)
    search.addEventListener("input", getSuggestions);

});
