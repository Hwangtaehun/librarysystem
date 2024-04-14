'use client';

import Image from 'next/image'
import LoginSvg from '../../assets/box-arrow-in-right.svg'
import LogoutSvg from '../../assets/box-arrow-right.svg';
import SigninSvg from '../../assets/person.svg'
import headerimg from '../img/header.gif'
import { getCookie } from 'cookies-next';

export default function Header(){
    var state = getCookie("state");
    var name = getCookie("name");

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
                    <Image src={headerimg} alt=""/>
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
        return(
            <header>
                <a href="/">
                    <Image src={headerimg} alt=""/>
                </a>
                <div className="link">
                    <a>{name}님 환영합니다.</a>
                    <button id="logout_hbt" onClick={logout}></button>   
                    <label htmlFor="logout_hbt">
                        <Image src={LogoutSvg} alt='' width={32} />
                    </label>
                </div>
            </header>
        );
    }
}