//달력 스크립트
let CDate = new Date();
let today = new Date();

HolidayData(String(CDate.getFullYear()), String(CDate.getMonth() + 1));

function HolidayData(m_year, m_month){
    var holiday = [];

    if(Number(m_month) < 10){
        m_month = '0' + m_month;
    }

    var xhr = new XMLHttpRequest();
    var url = 'http://apis.data.go.kr/B090041/openapi/service/SpcdeInfoService/getRestDeInfo'; /*URL*/
    var queryParams = '?' + encodeURIComponent('serviceKey') + '='+'9w2R3ZT8bsi3XMGwmm9tHlU1t27lPUZYjDLFHKi700HokF%2FCnB4w5mDKIAAB%2BmofzatSUls54oYcNcRLD11aww%3D%3D'; /*Service Key*/
    queryParams += '&' + encodeURIComponent('solYear') + '=' + encodeURIComponent(m_year); /**/
    queryParams += '&' + encodeURIComponent('solMonth') + '=' + encodeURIComponent(m_month); /**/
    xhr.open('GET', url + queryParams);

    xhr.onreadystatechange = function () {
        if (this.readyState == 4) {
            let index = 0;
            let str = this.responseText

            while(str.indexOf('<locdate>', index) != -1){
                index = str.indexOf('<locdate>', index) + 9;
                let date = str.substr(index, 8); 
                let price = Number(date.substr(6, 2));
                holiday.push(price);
            }

            buildCalender(holiday);
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
    document.querySelector(".yearTitle").innerHTML = CDate.getFullYear();
    document.querySelector(".monthTitle").innerHTML = CDate.getMonth() + 1;
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
        if(i < size_pre || size_next <= i){
            htmlDates += `<div class="date cloud">${dates[i]}</div>`;
        }
        else if(holiday.findIndex((index) => index == dates[i]) != -1){
            htmlDates += `<div class="date holiday break">${dates[i]}</div>`;
        }
        else if(i % 7 == rest){
            htmlDates += `<div class="date break">${dates[i]}</div>`;
        }
        else{
            htmlDates += `<div class="date">${dates[i]}</div>`;
        }
    }
    
    document.querySelector(".dates").innerHTML = htmlDates;
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