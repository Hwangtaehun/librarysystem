import axios from 'axios';

export class BookSymbol{
	//초성
    private cho: Array<string> = ["ㄱ", "ㄲ", "ㄴ", "ㄷ", "ㄸ", "ㄹ", "ㅁ", "ㅂ", "ㅃ", "ㅅ", "ㅆ", "ㅇ", "ㅈ", "ㅉ", "ㅊ", "ㅋ", "ㅌ", "ㅍ", "ㅎ"];
	//중성
	private joong: Array<string> = ["ㅏ", "ㅐ", "ㅑ", "ㅒ", "ㅓ", "ㅔ", "ㅕ", "ㅖ", "ㅗ", "ㅘ", "ㅙ", "ㅚ", "ㅛ", "ㅜ", "ㅝ", "ㅞ", "ㅟ", "ㅠ", "ㅡ", "ㅢ", "ㅣ"];
	//종성
	private jong: Array<string> = ["", "ㄱ", "ㄲ", "ㄳ", "ㄴ", "ㄵ", "ㄶ", "ㄷ", "ㄹ", "ㄺ", "ㄻ", "ㄼ", "ㄽ", "ㄾ", "ㄿ", "ㅀ", "ㅁ", "ㅂ", "ㅄ", "ㅅ", "ㅆ", "ㅇ", "ㅈ", "ㅊ", "ㅋ", "ㅌ", "ㅍ", "ㅎ"];
	
	//작가 이름
    private author_symbol: string;
	//영어권에서는 성을 마지막 붙기 때문에 확인하기위한 변수
	private lastauthor_exist: boolean;
	private author: string;
	
    public constructor(author: string){
		var author_array: Array<string> = author.split(",");
		this.author = author_array[0];
        this.lastauthor_exist = false;
		//공백 단위로 잘라서 배열로 만들기
		author_array = author.split(" ");

		//배열이 만들어 지면 성이 뒤에 있다고 생각해서 lastauthor_exist로 함
		if(author_array.length > 1){
			this.lastauthor_exist = true;
		}
		//this.print(author_array);
		this.inital(author_array);
    }

	//오류 발생할시 확인하기 위해서 출력함수 제작
	private print(array: Array<string>){
		for (let i = 0; i < array.length; i++) { 
            console.log("배열 [" + i + "] = " + array[i] + "\n");
		}
	}
	
	private inital(author_array: Array<string>) {
		var num: number = 0;
		var author_char_array: Array<string> = [];
		
		//작가 이름이 영어 자체인지 아니면 작가 이름이 영어+한글인지 확인하기 위해서 영어 마디가 몇개인지 확인
		while(this.english_check(author_array[num])) {
			if(author_array.length - 1 == num) {
				break;
			}
			num++;
		}
		
		if(num > 0) {
			//한국어 분이 존재하면 char로 형변환
			if(this.korean_check(author_array[num])) {
				author_char_array = this.stringTochar(author_array[num]);
			}
			else {
				//$author_array = this.englishTokorean(this.author);
				if(this.lastauthor_exist) {
					author_array = this.sequence_change(author_array);
				}
				author_char_array = this.stringTochar(author_array[0]);
			}
		}
		else if(author_array.length > 1) {
			if(this.lastauthor_exist) {
				author_array = this.sequence_change(author_array);
			}
			author_char_array = this.stringTochar(author_array[0]);
		}
		else {
			if(this.korean_check(author_array[0])) {
				author_char_array = this.stringTochar(author_array[0]);
			}
		}
		
		if(author_char_array != null) {
			this.finish_symbol(author_char_array);
		}
	}
	
	//한글있는 확인
	private korean_check(str: string): boolean {
        const regx = /[ㄱ-ㅎ|ㅏ-ㅣ|가-힣]/;
		return regx.test(str);
	}
	
	//알파벳있는지 확인
	private english_check(str: string) {
        const regx = /[a-zA-Z]/;
		var character = str.split('.');
		
		if(character.length > 0) {
            return regx.test(character[0]);
		}
		else {
			return regx.test(str);
		}
	}
	
	//영어권에서 이름+성을 성+이름으로 변경 또는 처음 이름+중간 이름+성을 성+중간 이름+처음 이름으로 변경
	private sequence_change(str: Array<string>): Array<string> {
		let temp = str[str.length - 1];
		str[str.length - 1] = str[0];
		str[0] = temp;
		
		return str;
	}
	
	//영어 -> 한글로 변경(나중 고치기)
	private englishTokorean(str: string) : Array<string> {	
		var value: string;
		var result_array: Array<string>;

		const Kakao = axios.create({
			baseURL: 'https://dapi.kakao.com', // 공통 요청 경로를 지정해준다.
			headers: {
			  Authorization: 'KakaoAK ' + process.env.KAKAO_PW,
			},
		});
		  
		const params = {
			query: str,
			sort: 'accuracy',
			page: 1,
			size: 10,
		};
		  
		const data = Kakao.get('/v2/search/web', { params });
		  
		value = data['documents']['0']['title'].split(" - ");
		value = value[0];
		value = value.replace('<b>', '');
		value = value.replace('</b>', '');
		result_array = value.split(" ");

		return result_array;
	}
	//출처: https://velog.io/@97godo/
	
	//string을 char로 변환하는 함수
	private stringTochar(str: string): Array<string> {
		var array = str.split("");
		var result_array = [];
		var str_result: string = array[0];
		//두번째 글자는 낱자로 변환해서 숫자로 변환해야 하므로 따로 지역변수에 저장
		var uniVal = array[1];
		//echo '$str_result = '.$str_result.', $uniVal = '.$uniVal.'<br>';
		str_result += this.separate_character(uniVal);
		result_array = str_result.split("");
		
		return result_array;
	}
	
	private finish_symbol(author_char_array: Array<string>) {
		var num = 0;
		this.author_symbol = author_char_array[num];
		num++;
		
		switch(author_char_array[num]) {
		case 'ㄱ':
		case 'ㄲ':
			this.author_symbol += "1";
			break;
		case 'ㄴ':
			this.author_symbol += "19";
			break;
		case 'ㄷ':
		case 'ㄸ':
			this.author_symbol += "2";
			break;
		case 'ㄹ':
			this.author_symbol += "29";
			break;
		case 'ㅁ':
			this.author_symbol += "3";
			break;
		case 'ㅂ':
		case 'ㅃ':
			this.author_symbol += "4";
			break;
		case 'ㅅ':
		case 'ㅆ':
			this.author_symbol += "5";
			break;
		case 'ㅇ':
			this.author_symbol += "6";
			break;
		case 'ㅈ':
		case 'ㅉ':
			this.author_symbol += "7";
			break;
		case 'ㅊ':
			this.author_symbol += "8";
			break;
		case 'ㅋ':
			this.author_symbol += "87";
			break;
		case 'ㅌ':
			this.author_symbol += "88";
			break;
		case 'ㅍ':
			this.author_symbol += "89";
			break;
		case 'ㅎ':
			this.author_symbol += "9";
			break;
		}
		
		if(this.author_symbol == author_char_array[0]) {
			this.author_symbol += "6";
		}
		else {
			num++;
		}
		
		if(author_char_array[num-1] == 'ㅊ') {
			switch(author_char_array[num]) {
			case 'ㅏ':
			case 'ㅐ':
			case 'ㅑ':
			case 'ㅒ':
				this.author_symbol += "2";
				break;
			case 'ㅓ':
			case 'ㅔ':
			case 'ㅕ':
			case 'ㅖ':
				this.author_symbol += "3";
				break;
			case 'ㅗ':
			case 'ㅘ':
			case 'ㅙ':
			case 'ㅚ':
			case 'ㅛ':
				this.author_symbol += "4";
				break;
			case 'ㅜ':
			case 'ㅝ':
			case 'ㅞ':
			case 'ㅟ':
			case 'ㅠ':
			case 'ㅡ':
			case 'ㅢ':
				this.author_symbol += "5";
				break;
			case 'ㅣ':
				this.author_symbol += "6";
				break;
			}
		}
		else {
			switch(author_char_array[num]) {
			case 'ㅏ':
				this.author_symbol += "2";
				break;
			case 'ㅐ':
			case 'ㅑ':
			case 'ㅒ':
				this.author_symbol += "3";
				break;
			case 'ㅓ':
			case 'ㅔ':
			case 'ㅕ':
			case 'ㅖ':
				this.author_symbol += "4";
				break;
			case 'ㅗ':
			case 'ㅘ':
			case 'ㅙ':
			case 'ㅚ':
			case 'ㅛ':
				this.author_symbol += "5";
				break;
			case 'ㅜ':
			case 'ㅝ':
			case 'ㅞ':
			case 'ㅟ':
			case 'ㅠ':
				this.author_symbol += "6";
				break;
			case 'ㅡ':
			case 'ㅢ':
				this.author_symbol += "7";
				break;	
			case 'ㅣ':
				this.author_symbol += "8";
				break;
			}
		}
	}
	
	//글자를 낱자로 변환
	public separate_character(uniVal: string): string {
		var result: string;
		var temp = uniVal.charCodeAt(0) - 0xAC00;
		var num_jong = temp % 28;
		var num_joong = ((temp - num_jong) / 28) % 21;
		var num_cho = (((temp - num_jong) / 28) - num_joong) / 21;

		result = this.cho[num_cho];
		result += this.joong[num_joong];

		if(this.jong[num_jong] !== ''){
			result += this.jong[num_jong];
		}

		return result;
	}

	//값을 가져오기
	public call_symbol(): string {
		return this.author_symbol;
	}
}