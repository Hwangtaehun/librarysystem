import axios from 'axios';

class BookSymbol{
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
	
    public __construct(author: string){
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
		num = 0;
		author_char_array = [];
		
		//작가 이름이 영어 자체인지 아니면 작가 이름이 영어+한글인지 확인하기 위해서 영어 마디가 몇개인지 확인
		while($this->english_check($author_array[$num])) {
			if(sizeof($author_array)-1 == $num) {
				break;
			}
			$num++;
		}
		
		if($num > 0) {
			//한국어 분이 존재하면 char로 형변환
			if($this->korean_check($author_array[$num])) {
				$author_char_array = $this->stringTochar($author_array[$num]);
			}
			else {
				//$author_array = $this->englishTokorean($this->author);
				if($this->lastauthor_exist) {
					$author_array = $this->sequence_change($author_array);
				}
				$author_char_array = $this->stringTochar($author_array[0]);
			}
		}
		else if(sizeof($author_array) > 1) {
			if($this->lastauthor_exist) {
				$author_array = $this->sequence_change($author_array);
			}
			$author_char_array = $this->stringTochar($author_array[0]);
		}
		else {
			if($this->korean_check($author_array[0])) {
				$author_char_array = $this->stringTochar($author_array[0]);
			}
		}
		
		if($author_char_array != null) {
			$this->finish_symbol($author_char_array);
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
	private englishTokorean(str: string) {	
        const URL = "https://dapi.kakao.com/v2/search/web";
        const HEADERS = {
        Authorization: `KakaoAK 4a10552ea42f3e71bb5c39c7994f8602`
        };

        const apiClient = axios.create({
        url: URL,
        headers: HEADERS,
        params: {
            query: str,
            sort: "accuracy",
            size: 10,
            target: "title"
        }
        });

		// $parameter = array(
		// 	"query"=>$str
		// );
		 
		// $host = "https://dapi.kakao.com/v2/search/web";
		// $api_key = "4a10552ea42f3e71bb5c39c7994f8602";
		// $headers = array("Authorization: KakaoAK {$api_key}");
		 
		// $query = http_build_query($parameter);
		// $content_type = "json";
		 
		// $opts = array(
		// 	CURLOPT_URL => $host . '.' . $content_type . '?' . $query,
		// 	CURLOPT_RETURNTRANSFER => true,
		// 	CURLOPT_SSL_VERIFYPEER => false,
		// 	CURLOPT_SSLVERSION => 1,
		// 	CURLOPT_HEADER => false,
		// 	CURLOPT_HTTPHEADER => $headers
		// );
		 
		// $curl_session = curl_init();
		// curl_setopt_array($curl_session, $opts);
		// $return_data = curl_exec($curl_session);
		
		// $decode = json_decode($return_data, true);
		// $result = $decode['documents']['0']['title'];
		// $result = explode("-", $result);
		// $result_array = rtrim($result[0]);
		// $result_array = explode(" ", $result_array);
		 
		// if (curl_errno($curl_session)) {
		// 	throw new Exception(curl_error($curl_session));
		// } else {
		// 	curl_close($curl_session);
		// }
		// return $result_array;
	}
	//출처: https://mintea.tistory.com/7
	
	//string을 char로 변환하는 함수
	private stringTochar(String $str) {
		$array = [];
		for ($i = 0; $i < mb_strlen($str,"UTF-8"); $i++) {
			$char = mb_substr ($str, $i, 1, 'UTF-8');
			array_push ($array, $char);
		}
		$result_array = [];
		
		$str_result = $array[0];
		//두번째 글자는 낱자로 변환해서 숫자로 변환해야 하므로 따로 지역변수에 저장
		$uniVal = $array[1];
		//echo '$str_result = '.$str_result.', $uniVal = '.$uniVal.'<br>';
		$str_result = $str_result.$this->separate_character($uniVal);
		$result_array = mb_str_split($str_result, $split_length = 1, $encoding = "utf-8");
		
		return $result_array;
	}
	
	private finish_symbol(array $author_char_array) {
		$num = 0;
		$this->author_symbol = $author_char_array[$num];
		$num++;
		
		switch($author_char_array[$num]) {
		case 'ㄱ':
		case 'ㄲ':
			$this->author_symbol = $this->author_symbol."1";
			break;
		case 'ㄴ':
			$this->author_symbol = $this->author_symbol."19";
			break;
		case 'ㄷ':
		case 'ㄸ':
			$this->author_symbol = $this->author_symbol."2";
			break;
		case 'ㄹ':
			$this->author_symbol = $this->author_symbol."29";
			break;
		case 'ㅁ':
			$this->author_symbol = $this->author_symbol."3";
			break;
		case 'ㅂ':
		case 'ㅃ':
			$this->author_symbol = $this->author_symbol."4";
			break;
		case 'ㅅ':
		case 'ㅆ':
			$this->author_symbol = $this->author_symbol."5";
			break;
		case 'ㅇ':
			$this->author_symbol = $this->author_symbol."6";
			break;
		case 'ㅈ':
		case 'ㅉ':
			$this->author_symbol = $this->author_symbol."7";
			break;
		case 'ㅊ':
			$this->author_symbol = $this->author_symbol."8";
			break;
		case 'ㅋ':
			$this->author_symbol = $this->author_symbol."87";
			break;
		case 'ㅌ':
			$this->author_symbol = $this->author_symbol."88";
			break;
		case 'ㅍ':
			$this->author_symbol = $this->author_symbol."89";
			break;
		case 'ㅎ':
			$this->author_symbol = $this->author_symbol."9";
			break;
		}
		
		if($this->author_symbol == $author_char_array[0]) {
			$this->author_symbol = $this->author_symbol."6";
		}
		else {
			$num++;
		}
		
		if($author_char_array[$num-1] == 'ㅊ') {
			switch($author_char_array[$num]) {
			case 'ㅏ':
			case 'ㅐ':
			case 'ㅑ':
			case 'ㅒ':
				$this->author_symbol = $this->author_symbol."2";
				break;
			case 'ㅓ':
			case 'ㅔ':
			case 'ㅕ':
			case 'ㅖ':
				$this->author_symbol = $this->author_symbol."3";
				break;
			case 'ㅗ':
			case 'ㅘ':
			case 'ㅙ':
			case 'ㅚ':
			case 'ㅛ':
				$this->author_symbol = $this->author_symbol."4";
				break;
			case 'ㅜ':
			case 'ㅝ':
			case 'ㅞ':
			case 'ㅟ':
			case 'ㅠ':
			case 'ㅡ':
			case 'ㅢ':
				$this->author_symbol = $this->author_symbol."5";
				break;
			case 'ㅣ':
				$this->author_symbol = $this->author_symbol."6";
				break;
			}
		}
		else {
			switch($author_char_array[$num]) {
			case 'ㅏ':
				$this->author_symbol = $this->author_symbol."2";
				break;
			case 'ㅐ':
			case 'ㅑ':
			case 'ㅒ':
				$this->author_symbol = $this->author_symbol."3";
				break;
			case 'ㅓ':
			case 'ㅔ':
			case 'ㅕ':
			case 'ㅖ':
				$this->author_symbol = $this->author_symbol."4";
				break;
			case 'ㅗ':
			case 'ㅘ':
			case 'ㅙ':
			case 'ㅚ':
			case 'ㅛ':
				$this->author_symbol = $this->author_symbol."5";
				break;
			case 'ㅜ':
			case 'ㅝ':
			case 'ㅞ':
			case 'ㅟ':
			case 'ㅠ':
				$this->author_symbol = $this->author_symbol."6";
				break;
			case 'ㅡ':
			case 'ㅢ':
				$this->author_symbol = $this->author_symbol."7";
				break;	
			case 'ㅣ':
				$this->author_symbol = $this->author_symbol."8";
				break;
			}
		}
	}

	//유니코드 문자 포인트 가져오기
	private ord8(c) {
		$len = strlen($c);
		if($len <= 0) return false;
		$h = ord($c[0]);
		if ($h <= 0x7F) return $h;
		if ($h < 0xC2) return false;
		if ($h <= 0xDF && $len>1) return ($h & 0x1F) <<  6 | (ord($c[1]) & 0x3F);
		if ($h <= 0xEF && $len>2) return ($h & 0x0F) << 12 | (ord($c[1]) & 0x3F) <<  6 | (ord($c[2]) & 0x3F);		  
		if ($h <= 0xF4 && $len>3) return ($h & 0x0F) << 18 | (ord($c[1]) & 0x3F) << 12 | (ord($c[2]) & 0x3F) << 6 | (ord($c[3]) & 0x3F);
		return false;
	}
	
	//글자를 낱자로 변환
	public separate_character($uniVal) {
		$result = "";

		for ($i=0; $i<mb_strlen($uniVal, 'UTF-8'); $i++) {
			//낱자를 불리하기위해서 글자를 숫자로 변환
			$code = $this->ord8(mb_substr($uniVal, $i, 1, 'UTF-8')) - 44032;
			if ($code > -1 && $code < 11172) {
				$temp = $code / 588;
				$num_cho = (int)$temp;
				$temp = $code % 588 / 28;
				$num_joong = (int)$temp;
				$num_jong = $code % 28;
				$result .= $this->cho[$num_cho].$this->joong[$num_joong].$this->jong[$num_jong];
			} else {
				$result .= mb_substr($uniVal, $i, 1, 'UTF-8');
			}
		}
		trim($result);
		return $result;
	}

	//값을 가져오기
	public call_symbol(): string {
		return this.author_symbol;
	}
}