"use server";

import { getSession } from "../../components/includes/session";

export default async function get_session(){
    var session = JSON.stringify(getSession());
    var data = JSON.parse(session);
    return data;
}