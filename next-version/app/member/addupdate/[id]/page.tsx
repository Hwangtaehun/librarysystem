import Member from "../../member";
import Memform from "../memform";

export default async function Memupdate({params: {id}}: {params: { id: string }}){
    console.log(id);
    let memdata = await Member(id);
    console.log(memdata);

    return (
        <Memform data={memdata}/>
    )
}