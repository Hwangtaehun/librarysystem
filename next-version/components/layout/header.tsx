'use client';

// import { getSession } from "../includes/session";
import Image from 'next/image'
import LoginSvg from '../../assets/box-arrow-in-right.svg'
import SigninSvg from '../../assets/person.svg'
import header_img from '../img/header.gif'

// const session = JSON.stringify(getSession());

export default function Header(){
    // var data = JSON.parse(session);
    var state;

    function login(e) {
        window.location.href = "/member/login";
    }

    function logout(e){
        window.location.href = "/member/logout";
    }

    function signup(e) {
        window.location.href = "/member/addupdate";
    }

    if(state == null){
        return(
            <header>
                <a href="/">
                    <Image src={header_img} alt=""/>
                </a>
                <div className="link">
                    <button id="login_hbt" onClick={login}>
                    </button>
                    <label htmlFor="login_hbt">
                        <Image src={LoginSvg} alt='' width={32}></Image>
                    </label>
                    <button id="register_hbt" onClick={signup}>
                    </button>
                    <label htmlFor="register_hbt">
                        <Image src={SigninSvg} alt='' width={32}></Image>
                    </label>
                </div>
            </header>
        );
    }else{
        var name = 'data.name';
        return(
            <header>
                <a href="/">
                    <img src="../img/header.gif" alt=""/>
                </a>
                <div className="link">
                    <a>{name}'님 환영합니다.</a>
                    <button id="logout_hbt" onClick={logout}></button>   
                    <label htmlFor="logout_hbt">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" className="bi bi-box-arrow-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                            <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                        </svg>
                    </label>
                </div>
            </header>
        );
    }
}