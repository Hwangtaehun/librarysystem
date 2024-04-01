import { menu } from "./menu";

export default function Aside(menu_str){
    var c_menu: menu = new menu();
    return(
        <aside>
            <div className='sidemenu'>
                <input type='checkbox' id='menuicon'/>
                <label htmlFor='menuicon'>
                    <span></span><span></span><span></span>
                </label>
                <menu>
                    <li><h3>{menu_str}</h3></li>
                    {c_menu.makehtml(menu_str)}
                </menu>
            </div>
        </aside>
    )
}