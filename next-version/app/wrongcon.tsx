"use client";

import { useRouter } from 'next/router';

export default function Wrongcon(props){
    const router = useRouter();

    if(props.message == null){
        location.href = "/";
        alert("잘못 접근했습니다.");
    }else{
        alert(props.message);
        router.back();
    }

    return(<div>잘못접근했습니다.</div>)
}