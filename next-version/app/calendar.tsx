"use client"

export default function Calender(props){
    function move(event) {
        const url = event.target.value;
        if (url) {
          window.location.href = url;
        }
    };

    function prevClick() {
        eval("prevCal()");
    };

    function nextClick() {
        eval("nextCal()");
    };

    return(
        <div className="calender">
                <div className="header">
                <div className="select" onChange = {move}>
                    <select id = "s2" name = "lib_select">
                        {props.cal_option}
                    </select>
                </div>
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