import axios from 'axios';

const Kakao = axios.create({
  baseURL: 'https://dapi.kakao.com', // 공통 요청 경로를 지정해준다.
  headers: {
    Authorization: 'KakaoAK ' + process.env.KAKAO_PW,
  },
});

// search book api
export const WebSearch = (params) => {
  return Kakao.get('/v2/search/web', { params });
};
