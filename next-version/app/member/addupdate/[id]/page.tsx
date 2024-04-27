import { cookies } from 'next/headers';
import { getCookie } from "cookies-next";
import Member from "../../member";
import Memform from "../memform";
import Wrongcon from '../../../wrongcon';
import Aside from '../../../../components/layout/aside';
import Navigation from "../../../../components/layout/navigation";

export default async function Memupdate({params: {id}}: {params: { id: string }}){
    let memdata = await Member(id);
    let state = getCookie("state", {cookies})
    let no =  getCookie("no", {cookies})

    if(state == '1' || no == id){
        return (
            <>
                <link rel="stylesheet" href="/css/form-base.css" />
                <Navigation />
                <Aside id={'기타'} />
                <main>
                    <Memform data={memdata}/>
                </main>
            </>
        );
    }else{
        return(
            <Wrongcon></Wrongcon>
        )
    }
}