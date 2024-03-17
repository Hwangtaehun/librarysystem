const nav = document.querySelector('nav');
const sr_html = '<input type="checkbox" id="searchicon"><label for="searchicon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16"><path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/></svg></label>';
nav.insertAdjacentHTML("beforeend", sr_html);

const search_bt = document.querySelector('#searchicon');
const search = document.querySelector('.dynamic_search');
const sidemenu = document.querySelector('.sidemenu');
const menu_bt = document.querySelector('#menuicon');
const search_width = window.innerWidth;
var bs_create = false;

search_disabled(search_width);

window.addEventListener("resize", function() {
    search_disabled(this.window.innerWidth);
})

search_bt.addEventListener("change", function (e) {
    if(search_bt.checked == true){
        search.style.top = '115px';
    }else{
        search.style.top = '-110px';
    }
});

menu_bt.addEventListener("change", function (e) {
    if(menu_bt.checked == true){
        sidemenu.style.background = '#000000';
    }else{
        sidemenu.style.background = 'none';
    }
});

function search_disabled(width) {
    if(width < 992){
        if(!bs_create){
            const nav = document.querySelector('.navbar-nav');
            const copy = search.cloneNode(true);

            search.style.top = '-110px';
            search_bt.checked = false;
            search_bt.disabled = true;
            copy.id = "nav_search";
            nav.after(copy);
            bs_create = true;
        }
    }
    else{
        const id = document.querySelector('#nav_search');
        search_bt.disabled = false;
        if(id != null){
            id.remove();
        }
        bs_create = false;
    }
}