import { handleLogin } from "./action";

async function server(data){
    'use server';
    handleLogin(data);
}

export default async function home(){
    const data = {
        id: '1234',
        name: 'test',
        state: '1',
    };

    server(data);
    
    return <h1>Hello NextJs</h1>
}