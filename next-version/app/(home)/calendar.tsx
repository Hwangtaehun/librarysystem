"use client"

import Libselect from "./libselect";

export default function Calender(props){
    let today: Date = new Date();
    let CDate: Date = new Date();
    let rest = props.rest
    
    function prevClick() {
        eval("prevCal()");
    };

    function nextClick() {
        eval("nextCal()");
    };

    return(
        <div className="calender">
            <div className="header">
                <Libselect lib_option={props.cal_option} value={props.value}/>
                <button className="prevBtn" onClick={prevClick}></button>
                <div className="title">
                        <div className="yearTitle"></div>
                        <div>년</div>
                        <div className="monthTitle"></div>
                        <div>월</div>
                </div>
                <button className="nextBtn" onClick={nextClick}></button>
            </div>
            <div className="main">
                <div className="days">
                    <div className="day">Sun</div>
                    <div className="day">Mon</div>
                    <div className="day">Tue</div>
                    <div className="day">Wed</div>
                    <div className="day">Thu</div>
                    <div className="day">Fri</div>
                    <div className="day">Sat</div>
                </div>
                <div className="dates"></div>
                <div className="image"></div>
            </div>
        </div>
    );
}