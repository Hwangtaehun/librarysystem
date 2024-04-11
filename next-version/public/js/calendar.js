//달력 스크립트
const url = window.location.search.slice(1).split('=');
let rest = 5;
let CDate = new Date();
let today = new Date();

if(url[0] == 'no'){
    let no = url[1];
    if(no == 1 || no == 4){
        rest = 5;
    }else{
        rest = 1;
    }
}

HolidayData(String(CDate.getFullYear()), String(CDate.getMonth() + 1));

window.addEventListener("resize", function() {
    breakImg();
})

function HolidayData(m_year, m_month){
    var holiday = [];

    if(Number(m_month) < 10){
        m_month = '0' + m_month;
    }

    var xhr = new XMLHttpRequest();
    var url = 'http://apis.data.go.kr/B090041/openapi/service/SpcdeInfoService/getRestDeInfo'; /*URL*/
    var queryParams = '?' + encodeURIComponent('serviceKey') + '=' + 'eEL73Oq71v%2B%2BsPzxxoE0jNKIbDdNn5H1MCHQPl6ZH3OGDvE6%2BCaCLD%2FfgmaUjqrMmFC17xdbSe2o%2B%2BdAqRTXXQ%3D%3D'; /*Service Key*/
    queryParams += '&' + encodeURIComponent('solYear') + '=' + encodeURIComponent(m_year); /**/
    queryParams += '&' + encodeURIComponent('solMonth') + '=' + encodeURIComponent(m_month); /**/
    xhr.open('GET', url + queryParams);

    xhr.onreadystatechange = function () {
        if (this.readyState == 4) {
            let index = 0;
            let str = this.responseText

            while(str.indexOf('<locdate>', index) != -1){
                index = str.indexOf('<locdate>', index) + 9;
                let date = str.slice(index, index + 8); 
                let price = Number(date.slice(6, 8));
                holiday.push(price);
            }

            buildCalender(holiday);
            breakImg();
        }
    };

    xhr.send('');
}

function buildCalender(holiday){
    let size_pre = 0;
    let size_next = 0;
    let prevLast = new Date(CDate.getFullYear(), CDate.getMonth(), 0);
    let thisFirst = new Date(CDate.getFullYear(), CDate.getMonth(), 1);
    let thisLast = new Date(CDate.getFullYear(), CDate.getMonth() + 1, 0);
    document.querySelector(".yearTitle").innerHTML = CDate.getFullYear().toString();
    document.querySelector(".monthTitle").innerHTML = (CDate.getMonth() + 1).toString();
    let dates = [];

    if(thisFirst.getDay()!=0){
        size_pre = thisFirst.getDay();
        for(let i = 0; i < thisFirst.getDay(); i++){
            dates.unshift(prevLast.getDate()-i);
        }
    }

    for(let i = 1; i <= thisLast.getDate(); i++){
        dates.push(i);
    }

    for(let i = 1; i <= 13 - thisLast.getDay(); i++){
        dates.push(i);
    }

    for(let i = 0; i < 42; i++){
        if(dates[i-1] > dates[i]){
            size_next = i;
        }
    }

    let htmlDates = '';
    for(let i = 0; i < 42; i++){
        var toclass = '';

        if(today.getDate()==dates[i] && today.getMonth()==CDate.getMonth() && today.getFullYear()==CDate.getFullYear()){
            toclass = 'today';
        }

        if(i < size_pre || size_next <= i){
            htmlDates += `<div class="date cloud">${dates[i]}</div>`;
        }
        else if(holiday.findIndex((index) => index == dates[i]) != -1){
            htmlDates += `<div class="date holiday ${toclass}" id="break">${dates[i]}</div>`;
        }
        else if(i % 7 == rest){
            htmlDates += `<div class="date ${toclass}" id="break">${dates[i]}</div>`;
        }
        else{
            htmlDates += `<div class="date ${toclass}">${dates[i]}</div>`;
        }
    }
    
    document.querySelector(".dates").innerHTML = htmlDates;
}

function breakImg() {
    let array = document.querySelectorAll("#break");
    let html = '';
    for (let i = 0; i < array.length; i++) { 
        let top = window.scrollY + array[i].getBoundingClientRect().top + 1;
        let left = window.scrollX + array[i].getBoundingClientRect().left + array[i].getBoundingClientRect().width / 3 - 1;
        html += '<img src="../img/icon/star.png" class="break" style="left: ' + left + 'px; top: ' + top + 'px;">'
    }

    document.querySelector(".image").innerHTML = html;
}

function prevCal(){
    CDate.setDate(1)
    CDate.setMonth(CDate.getMonth()-1);
    HolidayData(String(CDate.getFullYear()), String(CDate.getMonth() + 1));
}

function nextCal(){
    CDate.setDate(1)
    CDate.setMonth(CDate.getMonth()+1);
    HolidayData(String(CDate.getFullYear()), String(CDate.getMonth() + 1));
}
//참고 사이트: https://cl0clam.tistory.com/5