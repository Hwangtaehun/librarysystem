import { menu } from "./menu";

export default function Aside(menu){
    var c_menu: menu = new menu();

    return(
        <aside>
            <div className='sidemenu'>
                <input type='checkbox' id='menuicon'/>
                <label htmlFor='menuicon'>
                    <span></span><span></span><span></span>
                </label>
                <menu>
                    <li><h3>{menu}</h3></li>
                    {c_menu.makehtml(menu)}
                </menu>
            </div>
        </aside>
    )
}