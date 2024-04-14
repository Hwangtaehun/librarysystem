const search_bt = document.querySelector('#searchicon');
const search = document.querySelector('.dynamic_search');
const sidemenu = document.querySelector('.sidemenu');
const menu_bt = document.querySelector('#menuicon');
const search_width = window.innerWidth;
var bs_create = false;

search_disabled(search_width);

window.addEventListener("resize", function() {
    search_disabled(this.window.innerWidth);
    size_pagination(this.window.innerWidth);
})

search_bt.addEventListener("change", function (e) {
    console.log(e);
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