"use client";

import { useEffect, useState } from "react";
import Aside from "../../components/layout/aside";
import Navigation from "../../components/layout/navigation";

export default function Kindlist(props){
    const [check, setCheck] = useState(false);
    const [width, setWidth] = useState(992);
    const [disable, setDisable] = useState(false);
    // const [basearray, setBasearray] = useState<string[][]>(props.base);
    // const [subarray, setSubarray] = useState<string[][]>(props.sub);
    let pop = false;
    let url = "kind/list"

    if(props.pop != null){
        pop = true;
        url = "kind/list?pop=true";
    }

    useEffect(() => {
        const handleResize = () => {
            setWidth(window.innerWidth);
        };

        function locationSearch(width){
            if(width < 992){
                setCheck(false);
                setDisable(true);
            }else{
                setDisable(false);
            }
        }

        window.addEventListener("resize", handleResize);
        return () => {
            window.removeEventListener("resize", handleResize);
            locationSearch(width)
        };
    });

    function superChange(e){
        var stepCategoryJsonArray = props.basearray;
        var target = document.querySelector("#s2");
        var value = e.value;

        if(e.value === "0"){
            value = "000";
        }

        target.innerHTML = "";
        for(var i = 0; i < stepCategoryJsonArray[value].length; i++){
            var opt = document.createElement('option');
            opt.value = stepCategoryJsonArray[value][i][0];
            opt.innerHTML = stepCategoryJsonArray[value][i][1];
            target.appendChild(opt);
        }
        var stepCategoryJsonArray = props.subarray;
        var target = document.querySelector("#s3");
        target.innerHTML = "";
        for(var i = 0; i < stepCategoryJsonArray[value].length; i++){
            var opt = document.createElement('option');
            opt.value = stepCategoryJsonArray[value][i][0];
            opt.innerHTML = stepCategoryJsonArray[value][i][1];
            target.appendChild(opt);
        }
    }

    // 중분류 선택이 바뀌었을때, 소분류 바뀌게 하는 함수
    function baseChange(e){
        var stepCategoryJsonArray = props.subarray;
        var target = document.querySelector("#s3");
        var value = e.value;

        if(e.value === "0"){
            value = "000";
        }
        
        target.innerHTML = "";
        for(var i = 0; i < stepCategoryJsonArray[value].length; i++){
            var opt = document.createElement('option');
            opt.value = stepCategoryJsonArray[value][i][0];
            opt.innerHTML = stepCategoryJsonArray[value][i][1];
            target.appendChild(opt);
        }
    }

    function Navsearch(){
        function checkEvent(e){
            setCheck(e.target.checked);
        }
    
        return(
            <>
                <input type="checkbox" id="searchicon" checked={check} disabled={disable} onChange={checkEvent}/>
                <label htmlFor="searchicon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="bi bi-x-lg" viewBox="0 0 16 16">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                    </svg>
                </label>
            </>
        );
    }

    function Search(){
        async function sumbit(formData: FormData) {
            formData.forEach(function(value, key){
                if(value == null){
                    if(key == 'user_search'){
                        alert("검색할 내용을 입력해주세요.");
                    }
                    return 0;
                }
            });
    
            const value = formData.get("user_search");
    
            location.href = url + "?value=" + value;
        }

        function optionArray(array){
            let element: JSX.Element[] = [];
            for(let i = 0; i < array.length; i++){
                element.push(<option value={array[i][0]}>{array[i][1]}</option>)
            }
            return element;
        }
    
        return(
            <form action={sumbit} method="post">
                <div className="sel">
                    <label htmlFor="s1">대분류</label>
                    <select name="super" id="s1" onChange={superChange}>
                        {optionArray(props.sup)}
                    </select>
                    <label htmlFor="s2">중분류</label>
                    <select name="base" id="s2" onChange={baseChange}>
                        {optionArray(props.base)}
                    </select>
                    <label htmlFor="s3">소분류</label>
                    <select name="sup" id="s3">
                        {optionArray(props.sub)}
                    </select>
                    <input type="submit" value = "검색"/>
                </div>
            </form>
        );
    }


    if(pop){
        return(
            <main>
                {Search()}
            </main>
        );
    }else{
        return(
            <>
            <Navigation navsearch={Navsearch()} search={Search()} /><Aside id={'기타'} /><div className="dynamic_search">
                {Search()}
            </div></> 
        );
    }
}