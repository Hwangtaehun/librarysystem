import {selectSQL} from "../_lib/db";

export const getUserData = () => {
    const query = 'SELECT * FROM TB_USER;';

    return selectSQL(query);
}