import { menu } from "./menu";

export default function Footer(){
    var c_menu: menu = new menu();
    var menus = c_menu.get_menus();
    var state = c_menu.get_state();

    return(
        <div className='table_menu'>
            <table>
                <tr>
                    <th>공지사항</th>
                    <th>책</th>
                    <th>종류</th> 
                    <th>도서관</th>
                    <th>자료</th> 
                    <th>대출</th> 
                    <th>상호대차</th> 
                    <th>기타</th>
                </tr>
                <tr>
                    <td>
                        <a href={menus[0][1][1]}>{menus[0][1][0]}</a>
                    </td>
                    <td>
                        <a href={menus[1][1][1]}>{menus[1][1][0]}</a>
                    </td>
                    <td><a href="'.$menus['종류'][$num][1].'">'.$menus['종류'][$num][0].'</a></td><td><a href="'.$menus['도서관'][$num][1].'">'.$menus['도서관'][$num][0].'</a></td>'
                </tr>
            </table>
        </div>
    )
}