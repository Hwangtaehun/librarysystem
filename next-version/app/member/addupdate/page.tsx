"use client";

import Memform from "./memform";
import Navigation from "../../../components/layout/navigation";

export default function Meminsert(){
    return (
        <>
            <link rel="stylesheet" href="/css/form-noaside.css" />
            <Navigation />
            <main>
                <Memform />
            </main>
        </>
    ) 
}