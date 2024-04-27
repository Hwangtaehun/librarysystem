"use client"

import { useEffect, useState } from "react";
import Libselect from "./libselect";
import Holiday from "./holiday";

export default function Calender(props){
    const [click, setClick] = useState(0);
    let today: Date = new Date();
    let CDate: Date = new Date();
    let rest = props.rest

    useEffect(() => {
        async function getHoliday() {
            CDate.setMonth(CDate.getMonth() + click);
            const data = await Holiday(String(CDate.getFullYear()), String(CDate.getMonth() + 1));
            buildCalender(data);
            breakImg();
        }
        getHoliday();
    }, [click]);

    useEffect(() => {
        window.addEventListener("resize", function() {
            breakImg();
        })
    })

    

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
    
    function prevClick() {
        setClick(click - 1);
        CDate.setDate(1);
    };

    function nextClick() {
        setClick(click + 1);
        CDate.setDate(1);
    };

    return(
        <div className="calender" key="calender">
            <div className="header" key="header">
                <Libselect lib_option={props.cal_option} value={props.value}/>
                <button className="prevBtn" onClick={prevClick}></button>
                <div className="title" key="title">
                        <div className="yearTitle" key="yearTitle"></div>
                        <div>년</div>
                        <div className="monthTitle" key="monthTitle"></div>
                        <div>월</div>
                </div>
                <button className="nextBtn" onClick={nextClick}></button>
            </div>
            <div className="main" key="main">
                <div className="days" key="days">
                    <div className="day" key="sun">Sun</div>
                    <div className="day" key="mon">Mon</div>
                    <div className="day" key="tue">Tue</div>
                    <div className="day" key="wed">Wed</div>
                    <div className="day" key="thu">Thu</div>
                    <div className="day" key="fri">Fri</div>
                    <div className="day" key="sat">Sat</div>
                </div>
                <div className="dates" key="dates"></div>
                <div className="image" key="image"></div>
            </div>
        </div>
    );
}