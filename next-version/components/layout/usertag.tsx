import Image from 'next/image';
import { getCookie } from 'cookies-next';
import { useEffect, useState } from 'react';
import SigninSvg from '../../assets/person.svg';
import LogoutSvg from '../../assets/box-arrow-right.svg';
import LoginSvg from '../../assets/box-arrow-in-right.svg';

export default function Usertag(){
    const [state, setState] = useState(null);
    const [name, setName] = useState('');

    useEffect(() => {
        setState(getCookie('state'));
        setName(getCookie('name'));
    }, []);

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
            <div className="link">
                <button id="login_hbt" onClick={login} />
                <label htmlFor="login_hbt">
                    <Image src={LoginSvg} alt='' width={32}></Image>
                </label>
                <button id="register_hbt" onClick={signup} />
                <label htmlFor="register_hbt">
                    <Image src={SigninSvg} alt='' width={32}></Image>
                </label>
            </div>
        );
    }else{
        return(
            <div className="link">
                <a>{name}님 환영합니다.</a>
                <button id="logout_hbt" onClick={logout}></button>   
                <label htmlFor="logout_hbt">
                    <Image src={LogoutSvg} alt='' width={32} />
                </label>
            </div>
        );
    }
}