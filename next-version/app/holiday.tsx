export default async function Holiday(m_year: string, m_month: string){
    let holiday = [];

    if(Number(m_month) < 10){
        m_month = '0' + m_month;
    }

    var url = 'http://apis.data.go.kr/B090041/openapi/service/SpcdeInfoService/getRestDeInfo'; /*URL*/
    var queryParams = '?' + encodeURIComponent('serviceKey') + '=' + process.env.NEXT_PUBLIC_PUBLIC_PW; /*Service Key*/
    queryParams += '&' + encodeURIComponent('solYear') + '=' + encodeURIComponent(m_year); /**/
    queryParams += '&' + encodeURIComponent('solMonth') + '=' + encodeURIComponent(m_month); /**/
    let result = await fetch(url+queryParams);
    let str = await result.text();
    let index = 0;

    while(str.indexOf('<locdate>', index) != -1){
        index = str.indexOf('<locdate>', index) + 9;
        let date = str.slice(index, index + 8); 
        let price = Number(date.slice(6, 8));
        holiday.push(price);
    }

    return holiday;
}