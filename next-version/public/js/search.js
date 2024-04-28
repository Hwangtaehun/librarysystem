const search = document.querySelector('.dynamic_search');
const search_width = window.innerWidth;
var bs_create = false;

search_disabled(search_width);

window.addEventListener("resize", function() {
    search_disabled(this.window.innerWidth);
    size_pagination(this.window.innerWidth);
})

function search_disabled(width) {
    if(width < 992){
        if(!bs_create){
            const nav = document.querySelector('.navbar-nav');
            const copy = search.cloneNode(true);
            copy.id = "nav_search";
            nav.after(copy);
            bs_create = true;
        }
    }
    else{
        const id = document.querySelector('#nav_search');
        if(id != null){
            id.remove();
        }
        bs_create = false;
    }
}

function size_pagination(width) {
    var pa = document.querySelector(".pagination");
    if(pa != null){
        if(width > 991){
            pa.className = 'pagination justify-content-center';
        }else{
            pa.className = 'pagination justify-content-center pagination-sm';
        }
    }
}