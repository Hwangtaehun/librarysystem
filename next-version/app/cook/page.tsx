import { getSessionData } from '../action'
 
export default async function page(){
  const data = getSessionData();
  console.log(data);
}