"use client"

import { getCookie } from "cookies-next";

export default function Libselect(props){
    var state = getCookie("state");

    if(state == null){
        state = '2';
    }

    function move(event) {
        const url = event.target.value;
        if (url) {
          window.location.href = url;
        }
    };

    if(state != '1'){
        return(
            <div className="select">
                <select id = "s2" name = "lib_select" onChange = {move} value={props.value}>
                    {props.lib_option}
                </select>
            </div>
        );
    }else{
        return(
            <div className="select">
                <label htmlFor="s2">도서관 선택</label>
                <select id = "s2" name = "lib_select" onChange = {move} value={props.value}>
                    {props.lib_option}
                </select>
            </div>
        );
    }
}