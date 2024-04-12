"use client";

import { deleteCookie } from "cookies-next";

export default function logout(){
    deleteCookie("state");
    deleteCookie("name");
    deleteCookie("no");
    location.href = "/";
}