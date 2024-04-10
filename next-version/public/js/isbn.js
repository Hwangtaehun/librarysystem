var search_name;
            var page_num = 1;
            var totalPages;
            var first = true;
            var url = location.href;

            function make_card(msg) {
                for (let i = 0; i < 10; i++) {
                    let temp = msg.documents[i].isbn.split(' ');
                    let no = temp[1];
                    let url = msg.documents[i].thumbnail;
                    let name = msg.documents[i].title;
                    let author = msg.documents[i].authors;
                    let publish = msg.documents[i].publisher;
                    temp = msg.documents[i].datetime.split('-');
                    let year = temp[0];
                    let price = msg.documents[i].price;

                    let v_no = '"' + no + '"';
                    let v_url = '"' + url + '"';
                    let v_name = '"' + name + '"';
                    let v_author = '"' + author + '"';
                    let v_publish = '"' + publish + '"';
                    let v_year = '"' + year + '"';
                    let v_price = '"' + price + '"';

                    if(url == ""){
                        let v_url = " ";
                        $(".list").append( "<div class='card col' style='width: 28rem; height: 180px;'> <div class='card-body'> <h5 class='card-title'>"
                                            + name + "</h5> <p class='card-text'>작가: " + author + "<br> 출판사: " + publish + "<br> 출판년도: " + year + "<br> 가격: " 
                                            + price + "<br> </p> <input type='button' value='선택' onclick='opener.parent.isbnValue(" + v_no + ", " + v_name 
                                            + ", " + v_author + ", " + v_publish + ", " + v_year + ", " + v_price +", " + v_url + "); window.close();'> </div> </div>" );
                    }else{
                        $(".list").append( "<div class='card col' style='width: 28rem; height: 180px;'> <img src = '" + url + "' class='card-img-top' alt='...'> <div class='card-body'> <h5 class='card-title'>"
                                            + name + "</h5> <p class='card-text'>작가: " + author + "<br> 출판사: " + publish + "<br> 출판년도: " + year + "<br> 가격: " 
                                            + price + "<br> </p> <input type='button' value='선택' onclick='opener.parent.isbnValue(" + v_no + ", " + v_name 
                                            + ", " + v_author + ", " + v_publish + ", " + v_year + ", " + v_price +", " + v_url + "); window.close();'> </div> </div>" );
                    }
                }
            }

            function search(){
                $.ajax({
                    method: "GET",
                    url: "https://dapi.kakao.com/v3/search/book?sort=accuracy&page=" + page_num,
                    data: { query : search_name },
                    headers : { Authorization: "KakaoAK " + process.env.KAKAO_PW}
                })
                .done(function (msg) {
                    var cnt = msg.meta.total_count;
                            
                    totalPages = cnt / 10;

                    if(totalPages > 100){
                        totalPages = 100;
                    }

                    $(".list").empty();
                    $("#pagination").empty();

                    $(function () {
                        window.pagObj = $('#pagination').twbsPagination({
                            totalPages: totalPages,
                            visiblePages: 10,
                            prev: "‹",
                            next: "›",
                            first: '«',
                            last: '»',
                            onPageClick: function (event, page) {
                                page_num = page;
                            }
                        }).on('page', function (event, page) {
                                $.ajax({
                                    method: "GET",
                                    url: "https://dapi.kakao.com/v3/search/book?sort=accuracy&page=" + page_num,
                                    data: { query : search_name },
                                    headers : { Authorization: "KakaoAK 4a10552ea42f3e71bb5c39c7994f8602"}
                                })
                                .done(function (msg) {
                                    $(".list").empty();
                                    make_card(msg);
                                });
                            });
                    });
                    make_card(msg);
                });
            }

            if(window.location.search != ""){
                let t_array = window.location.href.split('?');

                url = t_array[0];
                first = false;
                search_name = decodeURI(window.location.search.slice(1));
                search();
            }

            $(document).ready(function(){
                $("#search").click(function(){
                    if(first){
                        search_name = $("#bookname").val();
                        first = false;
                    }else{
                        location.href = url + "?"+ $("#bookname").val(); 
                    }
                    search();
                });
            });
//사용출처: http://josecebe.github.io/twbs-pagination/