"use client";

import Member from "../../member";

export default function Memupdate({params: {id}}: {params: { id: string }}){
    Member(id);
    
}