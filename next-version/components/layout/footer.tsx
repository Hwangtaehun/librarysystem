import { menu } from "./menu";
import Image from 'next/image'
import foot_img from '../img/footer.gif'

export default function Footer(){
    var c_menu: menu = new menu();
    var menus = c_menu.get_menus();
    var state = c_menu.get_state();

    if(state == '1'){
        return(
            <footer>
                <Image src={foot_img} alt="" />
                <div className='table_menu'>
                    <table>
                        <tbody>
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
                                    <a href={menus[0][0][1]}>{menus[0][0][0]}</a>
                                </td>
                                <td>
                                    <a href={menus[1][0][1]}>{menus[1][0][0]}</a>
                                </td>
                                <td>
                                    <a href={menus[2][0][1]}>{menus[2][0][0]}</a>
                                </td>
                                <td>
                                    <a href={menus[3][0][1]}>{menus[3][0][0]}</a>
                                </td>
                                <td>
                                    <a href={menus[4][0][1]}>{menus[4][0][0]}</a>
                                </td>
                                <td>
                                    <a href={menus[5][0][1]}>{menus[5][0][0]}</a>
                                </td>
                                <td>
                                    <a href={menus[6][0][1]}>{menus[6][0][0]}</a>
                                </td>
                                <td>
                                    <a href={menus[7][0][1]}>{menus[7][0][0]}</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href={menus[0][1][1]}>{menus[0][1][0]}</a>
                                </td>
                                <td>
                                    <a href={menus[1][1][1]}>{menus[1][1][0]}</a>
                                </td>
                                <td>
                                    <a href={menus[2][1][1]}>{menus[2][1][0]}</a>
                                </td>
                                <td>
                                    <a href={menus[3][1][1]}>{menus[3][1][0]}</a>
                                </td>
                                <td>
                                    <a href={menus[4][1][1]}>{menus[4][1][0]}</a>
                                </td>
                                <td>
                                    <a href={menus[5][1][1]}>{menus[5][1][0]}</a>
                                </td>
                                <td>
                                    <a href={menus[6][1][1]}>{menus[6][1][0]}</a>
                                </td>
                                <td>
                                    <a href={menus[7][1][1]}>{menus[7][1][0]}</a>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <a href={menus[5][2][1]}>{menus[5][2][0]}</a>
                                </td>
                                <td>
                                    <a href={menus[6][2][1]}>{menus[6][2][0]}</a>
                                </td>
                                <td>
                                    <a href={menus[7][2][1]}>{menus[7][2][0]}</a>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <a href={menus[5][3][1]}>{menus[5][3][0]}</a>
                                </td>
                                <td>
                                    <a href={menus[6][3][1]}>{menus[6][3][0]}</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </footer>
        );
    }
    else{
        return(
            <footer>
                <Image src={foot_img} alt="" />
                <div className='table_menu'>
                    <table>
                        <tbody>
                            <tr>
                                <th>공지사항</th>
                                <th>도서관</th>
                                <th>자료 검색</th>
                                <th>내서재</th>
                                <th>내정보수정</th>
                            </tr>
                            <tr>
                                <td>
                                    <a href="/not/list">공지사항</a>
                                </td>
                                <td>
                                    <a href="/lib/list">도서관</a>
                                </td>
                                <td>
                                    <a href="/mat/list">자료검색</a>
                                </td>
                                <td>
                                    <a href={menus[0][0][1]}>{menus[0][0][0]}</a>
                                </td>
                                <td>
                                    <a href={menus[1][0][1]}>{menus[1][0][0]}</a>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    <a href={menus[0][1][1]}>{menus[0][1][0]}</a>
                                </td>
                                <td>
                                    <a href={menus[1][1][1]}>{menus[1][1][0]}</a>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    <a href={menus[0][2][1]}>{menus[0][2][0]}</a>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    <a href={menus[0][3][1]}>{menus[0][3][0]}</a>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </footer>
        );
    }
}