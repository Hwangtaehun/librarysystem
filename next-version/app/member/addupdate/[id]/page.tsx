import { cookies } from 'next/headers';
import { getCookie } from "cookies-next";
import Member from "../../member";
import Memform from "../memform";
import Wrongcon from '../../../wrongcon';

export default async function Memupdate({params: {id}}: {params: { id: string }}){
    let memdata = await Member(id);
    let state = getCookie("state", {cookies})
    let no =  getCookie("no", {cookies})

    if(state == '1' || no == id){
        return (
            <Memform data={memdata}/>
        )
    }else{
        return(
            <Wrongcon></Wrongcon>
        )
    }
}