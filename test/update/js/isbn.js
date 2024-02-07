            var search_name;
            var page_num = 1;
            var totalPages;

            $(document).ready(function(){
                $("#search").click(function(){
                    search_name = $("#bookname").val();
                    $.ajax({
                        method: "GET",
                        url: "https://dapi.kakao.com/v3/search/book?sort=accuracy&page=" + page_num,
                        data: { query : search_name },
                        headers : { Authorization: "KakaoAK 4a10552ea42f3e71bb5c39c7994f8602"}
                    })
                        .done(function (msg) {
                            var cnt = msg.meta.total_count;
                            
                            totalPages = cnt / 10;
                            console.log(totalPages);

                            if(totalPages > 100){
                                totalPages = 100;
                            }

                            $( "p" ).empty();

                            for (let i = 0; i < 10; i++) {
                                $( "p" ).append( "<strong>" + msg.documents[i].title + "</strong>" );
                                $( "p" ).append( "<img src = '" + msg.documents[i].thumbnail + "'</src>" ); 
                            }

                            $(function () {
                                window.pagObj = $('#pagination').twbsPagination({
                                    totalPages: totalPages,
                                    visiblePages: 10,
                                    prev: "‹",
                                    next: "›",
                                    first: '«',
                                    last: '»',
                                    onPageClick: function (event, page) {
                                        // console.info(page + ' (from options)');
                                        page_num = page;
                                    }
                                }).on('page', function (event, page) {
                                    // console.info(page + ' (from event listening)');
                                    $.ajax({
                                        method: "GET",
                                        url: "https://dapi.kakao.com/v3/search/book?sort=accuracy&page=" + page_num,
                                        data: { query : search_name },
                                        headers : { Authorization: "KakaoAK 4a10552ea42f3e71bb5c39c7994f8602"}
                                    })
                                    .done(function (msg) {
                                        $( "p" ).empty();

                                        for (let i = 0; i < 10; i++) {
                                            $( "p" ).append( "<strong>" + msg.documents[i].title + "</strong>" );
                                            $( "p" ).append( "<img src = '" + msg.documents[i].thumbnail + "'</src>" ); 
                                        }
                                    });
                                });
                            });
                        });
                });
            });