function search(str) {
    $.ajax({
      method: "GET",
      url: "https://dapi.kakao.com/v2/search/web = " + page_num,
      data: { query : search_name },
      headers : { Authorization: "KakaoAK 4a10552ea42f3e71bb5c39c7994f8602"}
  })
  .done(function (msg) {})
}