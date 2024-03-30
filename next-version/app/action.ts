'use server'
 
import { cookies } from 'next/headers';
import jwt from 'jsonwebtoken';

const JWT_SECRET = 'password';

function encrypt(payload){
  return jwt.sign(payload, JWT_SECRET);
}

function decrypt(token){
  return jwt.verify(token, JWT_SECRET);
}
 
export async function handleLogin(sessionData) {
  const encryptedSessionData = encrypt(sessionData)
  cookies().set('session', encryptedSessionData, {
    httpOnly: true,
    secure: process.env.NODE_ENV === 'production',
    maxAge: 60 * 60 * 24 * 7, // One week
    path: '/',
  })
}
 
export async function getSessionData() {
  const encryptedSessionData = cookies().get('session')?.value
  return encryptedSessionData ? JSON.parse(decrypt(encryptedSessionData)) : null
}