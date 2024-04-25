"use client"
import { Menu } from "./menu";
import { getCookie } from 'cookies-next';

export default function Navigation(){
    var state = getCookie("state");
    var no = getCookie("no");
    var c_menu: Menu = new Menu(state, no);

    if(state == '1'){
        return (
            <>
            <nav className="navbar navbar-expand-lg bg-body-tertiary">
                <div className="container-fluid">
                    <a className="navbar-brand"></a>
                    <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span className="navbar-toggler-icon"></span>
                    </button>
                    <div className="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul className="navbar-nav">
                            <li className="nav-item" key="1">
                                <a className="nav-link active" aria-current="page" href="/">홈</a>
                            </li>
                            <li className="nav-item dropdown" key="2">
                                <a className="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">공지사항</a>
                                <ul className="dropdown-menu">
                                    {c_menu.makehtml('공지사항')}
                                </ul>
                            </li>
                            <li className="nav-item dropdown" key="3">
                                <a className="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">책</a>
                                <ul className="dropdown-menu">
                                    {c_menu.makehtml('책')}
                                </ul>
                            </li>
                            <li className="nav-item dropdown" key="4">
                                <a className="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">종류</a>
                                <ul className="dropdown-menu">
                                    {c_menu.makehtml('종류')}
                                </ul>
                            </li>
                            <li className="nav-item dropdown" key="6">
                                <a className="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">도서관</a>
                                <ul className="dropdown-menu">
                                    {c_menu.makehtml('도서관')}
                                </ul>
                            </li>
                            <li className="nav-item dropdown" key="7">
                                <a className="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">자료</a>
                                <ul className="dropdown-menu">
                                    {c_menu.makehtml('자료')}
                                </ul>
                            </li>
                            <li className="nav-item dropdown" key="8">
                                <a className="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">대출</a>
                                <ul className="dropdown-menu">
                                    {c_menu.makehtml('대출')}
                                </ul>
                            </li>
                            <li className="nav-item dropdown" key="9">
                                <a className="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">상호대차</a>
                                <ul className="dropdown-menu">
                                    {c_menu.makehtml('상호대차')}
                                </ul>
                            </li>
                            <li className="nav-item dropdown" key="0">
                                <a className="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">기타</a>
                                <ul className="dropdown-menu">
                                    {c_menu.makehtml('기타')}
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            </>
        );
    }
    else{
        return(
            <>
            <nav className="navbar navbar-expand-lg bg-body-tertiary">
                <div className="container-fluid">
                    <a className="navbar-brand"></a>
                    <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span className="navbar-toggler-icon"></span>
                    </button>
                    <div className="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul className="navbar-nav">
                            <li className="nav-item" key="1">
                                <a className="nav-link active" aria-current="page" href="/">홈</a>
                            </li>
                            <li className="nav-item" key="2">
                                <a className="nav-link" href="/not/list">공지사항</a>
                            </li>
                            <li className="nav-item" key="3">
                                <a className="nav-link" href="/lib/list">도서관</a>
                            </li>
                            <li className="nav-item" key="4">
                                <a className="nav-link" href="/mat/list">자료 검색</a>
                            </li>
                            <li className="nav-item dropdown" key="5">
                                <a className="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">내서재</a>
                                <ul className="dropdown-menu">
                                    {c_menu.makehtml('내서재')}
                                </ul>
                            </li>
                            <li className="nav-item dropdown" key="6">
                                <a className="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">내정보수정</a>
                                <ul className="dropdown-menu">
                                    {c_menu.makehtml('내정보수정')}
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            </>
        );
    }
}