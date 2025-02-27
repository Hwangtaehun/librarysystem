<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="../css/form-popup.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="../js/jquery.twbsPagination.min.js"></script>
        <script src="../js/key.js"></script>
        <script src="../js/isbn.js"></script>
    </head>
    <body>
        <main>
            <div class="search" id = "kakao">
                <input id = "bookname" class="bookname" value="" type = "text" placeholder="책 이름 또는 저자 또는 출판사를 적어주세요.">
                <button id = "search" class="btn btn-outline-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
            </div>
            <div class="container text-center">
                <div class="list row row-cols-2"> </div>
            </div>
            <div class="container">
                <ul class="pagination justify-content-center" id="pagination"></ul>
            </div>
        </main>
        <script>
            const bn = document.querySelector("#bookname");
            const pa = document.querySelector(".pagination");

            bn.value = decodeURI(window.location.search.slice(1));
            window.addEventListener("resize", function() {
                let width = window.innerWidth;
                windowsize(width);
            })

            function windowsize(width) {
                if(width > 991){
                    pa.className = 'pagination justify-content-center pagination-lg';
                }else{
                    pa.className = 'pagination justify-content-center';
                }
            }
        </script>
    </body>
</html>