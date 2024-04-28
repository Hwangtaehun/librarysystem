//pagementation 설정하기
"use client";

import Memdel from "./list/memdel";
import { getCookie } from "cookies-next";
import Aside from '../../components/layout/aside';
import Navigation from "../../components/layout/navigation";
import { useEffect, useState } from "react";

function cardparame(data, pop){
    let result: JSX.Element[] = [];

    async function memdelete(formData: FormData) {
        const res = await Memdel(formData);

        if(res.message == true){
            location.href = "/member/list";
        }
    }

    async function parentInform(formData: FormData){
        let no: string = formData.get('mem_no').toString();
        let id: string = formData.get("mem_id").toString();
        let state: string = formData.get("mem_state").toString();
        window.parent.postMessage({action: "memValue", data: {no: no, id: id, state: state}}, "*")
        window.close();
    }

    if(pop){
        for(let i = 0; data.length; i++){
            let mem_state = '일반';
    
            if(data[i]['mem_state'] == '2'){
                mem_state = '정지';
            }

            result.push(
                <div className="col">
                    <div className="card" style={{ width: "16rem", height: "210px" }}>
                        <div className="card-body">
                            <h5 className="card-title">{data[i]['mem_name']}</h5>
                            <p className="card-text">
                                아이디: {data[i]['mem_id']}<br />
                                비밀번호: {data[i]['mem_pw']}<br />
                                주소: {data[i]['mem_add']}<br />
                                상태: {mem_state}<br />
                            </p>
                            <form action={parentInform}>
                                <input type="hidden" name="mem_no" value={data[i]['mem_no']} />
                                <input type="hidden" name="mem_id" value={data[i]['mem_id']} />
                                <input type="hidden" name="mem_id" value={data[i]['state']} />
                                <input type="submit" value="선택" />
                            </form>
                        </div>
                    </div>
                </div>
            )
        }
    }else{
        for(let i = 0; i < data.length; i++){
            let url = "/member/addupdate/" + data[i]['mem_no'];
            let mem_state = '일반';
        
            if(data[i]['mem_state'] == '2'){
                mem_state = '정지';
            }
            result.push(
                <div className="col">
                    <div className="card" style={{ width: "16rem", height: "210px" }}>
                        <div className="card-body">
                            <h5 className="card-title">{data[i]['mem_name']}</h5>
                            <p className="card-text">
                                아이디: {data[i]['mem_id']}<br />
                                비밀번호: {data[i]['mem_pw']}<br />
                                주소: {data[i]['mem_add']}<br />
                                상태: {mem_state}<br />
                            </p>
                            <form action={memdelete} method="post">
                                <input type="hidden" name="mem_no" value={data[i]['mem_no']}/>
                                <input type="submit" value="삭제"/>
                                <a href={url}><input type="button" value="수정"/></a>
                            </form>
                        </div>
                    </div>
                </div>
            )
        }
    }

    return result;
}

export default function Memlist(props){
    const [check, setCheck] = useState(false);
    const [disable, setDisable] = useState(false);
    const [width, setWidth] = useState(992);
    let pop = false;
    let url = "/member/list";
    let card;
    let state = getCookie("state");
    let nav = Navsearch();

    if(state == null){
        state = '2';
    }

    if(props.pop != null){
        pop = true;
        url = "member/list?pop=true";
    }
    card = cardparame(props.data, pop)
      
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
    
        return(
            <form action={sumbit} method="post">
                <div className="search">
                    <input type="text" name="user_search" id="id_search" placeholder="검색할 회원 이름을 입력해주세요." />
                    <button type="submit" className="btn btn-outline-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </div>
            </form>
        );
    }

    if(pop){
        return(
            <>
                <main>
                    <link rel="stylesheet" href="/css/form-base.css" />
                    {Search()}
                    <div className="container text-center">
                        <div className="row row-cols-auto">
                            {card}
                        </div>
                    </div>
                </main>
            </>
        );        
    }else{
        if(state != '1'){
            return(
                <>
                    <Navigation navsearch={nav} />
                    <main>
                        <div className="dynamic_search" style={{ top: check ? '115px' : '-110px' }}>
                            {Search()}
                        </div>
                        <div className="container text-center">
                            <div className="row row-cols-auto">
                                {card}
                            </div>
                        </div>
                    </main>
                </>
            );
        }else{
            return(
                <>
                    <Navigation navsearch={nav} search={Search()} />
                    <Aside id={'기타'} />
                    <main>
                        <div className="dynamic_search" style={{ top: check ? '115px' : '-110px' }}>
                            {Search()}
                        </div>
                        <div className="container text-center">
                            <div className="row row-cols-auto">
                                {card}
                            </div>
                        </div>
                    </main>
                </>
            );
        }
    }
}