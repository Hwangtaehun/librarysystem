'use client';

import Image from 'next/image';
import dynamic from 'next/dynamic'
import headerimg from '../img/header.gif';

export default function Header(){
    const Usertag = dynamic(() => import('../layout/usertag'), { ssr: false })

    return(
        <header>
            <a href="/">
                <Image src={headerimg} alt=""/>
            </a>
            <Usertag />
        </header>
    );
}