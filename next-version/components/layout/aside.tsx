"use client";

import { getCookie } from "cookies-next";
import { Menu } from "./menu";
import { useState } from "react";

export default function Aside({id}: {id:string}){
    const [check, setCheck] = useState(false);
    var state = getCookie("state");
    var no = getCookie("no");
    var c_menu: Menu = new Menu(state, no);

    function checkEvent(e){
        setCheck(e.target.checked);
    }

    return(
        <aside>
            <div className='sidemenu' style={{ background: check ? '#000000' : 'none' }}>
                <input type='checkbox' id='menuicon' onChange={checkEvent} />
                <label htmlFor='menuicon'>
                    <span></span><span></span><span></span>
                </label>
                <menu>
                    <li><h3>{id}</h3></li>
                    {c_menu.makehtml(id)}
                </menu>
            </div>
        </aside>
    )
}