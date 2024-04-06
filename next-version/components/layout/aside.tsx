"use client";

import { getCookie } from "cookies-next";
import { Menu } from "./menu";

export default function Aside({id}: {id:string}){
    var state = getCookie("state");
    var no = getCookie("no");
    var c_menu: Menu = new Menu(state, no);

    return(
        <aside>
            <div className='sidemenu'>
                <input type='checkbox' id='menuicon'/>
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