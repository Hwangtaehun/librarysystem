<?php
class BookSymbol{
    private $cho = array("ㄱ", "ㄲ", "ㄴ", "ㄷ", "ㄸ", "ㄹ", "ㅁ", "ㅂ", "ㅃ", "ㅅ", "ㅆ", "ㅇ", "ㅈ", "ㅉ", "ㅊ", "ㅋ", "ㅌ", "ㅍ", "ㅎ");
	private $joong = array("ㅏ", "ㅐ", "ㅑ", "ㅒ", "ㅓ", "ㅔ", "ㅕ", "ㅖ", "ㅗ", "ㅘ", "ㅙ", "ㅚ", "ㅛ", "ㅜ", "ㅝ", "ㅞ", "ㅟ", "ㅠ", "ㅡ", "ㅢ", "ㅣ");
	private $jong = ["", "ㄱ", "ㄲ", "ㄳ", "ㄴ", "ㄵ", "ㄶ", "ㄷ", "ㄹ", "ㄺ", "ㄻ", "ㄼ", "ㄽ", "ㄾ", "ㄿ", "ㅀ", "ㅁ", "ㅂ", "ㅄ", "ㅅ", "ㅆ", "ㅇ", "ㅈ", "ㅊ", "ㅋ", "ㅌ", "ㅍ", "ㅎ"];
	
    private $author_symbol;
	private $lastauthor_exist;
	
    public function __construct(String $author){
        $this->lastauthor_exist = false;
		$author_array = explode(' ', $author);
		if(sizeof($author_array) > 1){
			$this->lastauthor_exist = true;
		}
		//$this->print($author_array);
		$this->inital($author_array);
    }

	private function print(array $array){
		for ($i = 0; $i < sizeof($array); $i++) { 
			echo '배열 ['.$i.'] = '.$array[$i].'<br>';
		}
	}
	
	private function inital(array $author_array) {
		$num = 0;
		$author_char_array = [];
		
		while($this->english_check($author_array[$num])) {
			if(sizeof($author_array)-1 == $num) {
				break;
			}
			$num++;
		}
		
		if($num > 0) {
			if($this->korean_check($author_array[$num])) {
				$author_char_array = $this->stringTochar($author_array[$num]);
			}
			else {
				if($this->lastauthor_exist) {
					$author_array = $this->sequence_change($author_array);
				}
				$author_array = $this->englishTokorean($author_array[0]);
				$author_char_array = $this->first_word($author_array);
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
	
	private function korean_check(String $str) {
		return preg_match("/[\xA1-\xFE][\xA1-\xFE]/", $str);
	}
	
	private function english_check(String $str) {
		$character = explode( '.', $str );
		
		if(sizeof($character) > 0) {
			return preg_match("/^[a-zA-Z]+$/", $character[0]);
		}
		else {
			return preg_match("/^[a-zA-Z]+$/", $str);
		}
	}
	
	private function sequence_change(array $str) {
		$temp = $str[sizeof($str)-1];
		$str[sizeof($str)-1] = $str[0];
		$str[0] = $temp;
		
		return $str;
	}
	
	private function englishTokorean(String $str) {
		$result = "";
		$result_array = [];
		$array = mb_str_split($str, $split_length = 1, $encoding = "utf-8");
		//$this->print($array);
		
		for($i = 0; $i < sizeof($array); $i++) {
			switch($array[$i]) {
			case 'a':
			case 'A':
				if($i == sizeof($array) - 1) {
					$result = $result."ㅏ";
				}
				else {
					$i++;
					if($array[$i] == 'e') {
						$result = $result."ㅐ";
					}
					else {
						$i--;
						$result = $result."ㅏ";
					}
				}
				break;
			case 'b':
			case 'B':
				$result = $result."ㅂ";
				break;
			case 'c':
			case 'C':
				if($i == sizeof($array) - 1) {
					$result = $result."ㅋ";
				}
				else {
					$i++;
					if($array[$i] == 'h') {
						$result = $result."ㅊ";
					}
					else {
						$i--;
						$result = $result."ㅋ";
					}
				}
				break;
			case 'd':
			case 'D':
				$result = $result."ㄷ";
				break;
			case 'e':
			case 'E':
				if($i == sizeof($array) - 1) {
					$result = $result."ㅔ";
				}
				else {
					$i++;
					if($array[$i] == 'o') {
						$result = $result."ㅓ";
					}
					else if($array[$i] == 'u') {
						$result = $result."ㅡ";
					}
					else if($array[$i] == 'e') {
						$result = $result."ㅣ";
					}
					else {
						$i--;
						$result = $result."ㅔ";
					}
				}
				break;
			case 'f':
			case 'F':
				$result = $result."ㅍ";
				break;
			case 'G':
			case 'g':
				$result = $result."ㄱ";
				break;
			case 'H':
			case 'h':
				$result = $result."ㅎ";
				break;
			case 'I':
			case 'i':
				$result = $result."ㅣ";
				break;
			case 'J':
			case 'j':
				if($i == sizeof($array) - 1) {
					$result = $result."ㅈ";
				}
				else {
					$i++;
					if($array[$i] == 'j') {
						$result = $result."ㅉ";
					}
					else {
						$i--;
						$result = $result."ㅈ";
					}
				}
				break;
			case 'K':
			case 'k':
				if($i == sizeof($array) - 1) {
					$result = $result."ㅋ";
				}
				else {
					$i++;
					if($array[$i] == 'k') {
						$result = $result."ㄲ";
					}
					else {
						$i--;
						$result = $result."ㅋ";
					}
				}
				break;
			case 'L':
			case 'l':
				$result = $result."ㄹ";
				break;
			case 'M':
			case 'm':
				$result = $result."ㅁ";
				break;
			case 'N':
			case 'n':
				if($i == sizeof($array) - 1) {
					$result = $result."ㄴ";
				}
				else {
					$i++;
					if($array[$i] == 'g') {
						$result = $result."ㅇ";
					}
					else {
						$i--;
						$result = $result."ㄴ";
					}
				}
				break;
			case 'O':
			case 'o':
				if($i == sizeof($array) - 1) {
					$result = $result."ㅗ";
				}
				else {
					$i++;
					if($array[$i] == 'e') {
						$result = $result."ㅚ";
					}
					else if($array[$i] == 'o') {
						$result = $result."ㅜ";
					}
					else {
						$i--;
						$result = $result."ㅗ";
					}
				}
				break;
			case 'P':
			case 'p':
				if($i == sizeof($array) - 1) {
					$result = $result."ㅍ";
				}
				else {
					$i++;
					if($array[$i] == 'p') {
						$result = $result."ㅃ";
					}
					else {
						$i--;
						$result = $result."ㅍ";
					}
				}
				break;
			case 'Q':
			case 'q':
				$result = $result."ㅋ";
				break;
			case 'R':
			case 'r':
				$result = $result."ㄹ";
				break;
			case 'S':
			case 's':
				if($i == sizeof($array) - 1) {
					$result = $result."ㅅ";
				}
				else {
					$i++;
					if($array[$i] == 's') {
						$result = $result."ㅆ";
					}
					else {
						$i--;
						$result = $result."ㅅ";
					}
				}
				break;
			case 'T':
			case 't':
				if($i == sizeof($array) - 1) {
					$result = $result."ㅌ";
				}
				else {
					$i++;
					if($array[$i] == 't') {
						$result = $result."ㄸ";
					}
					else {
						$i--;
						$result = $result."ㅌ";
					}
				}
				break;
			case 'U':
			case 'u':
				if($i == sizeof($array) - 1) {
					$result = $result."ㅜ";
				}
				else {
					$i++;
					if($array[$i] == 'i') {
						$result = $result."ㅢ";
					}
					else {
						$i--;
						$result = $result."ㅜ";
					}
				}
				break;
			case 'V':
			case 'v':
				$result = $result."ㅂ";
				break;
			case 'W':
			case 'w':
				if($i == sizeof($array) - 1) {
					$result = $result."ㅝ";
				}
				else {
					$i++;
					if($array[$i] == 'a') {
						if($i == sizeof($array) - 1) {
							$result = $result."ㅘ";
						}
						else {
							$i++;
							if($array[$i] == 'e') {
								$result = $result."ㅙ";
							}
							else {
								$i--;
								$result = $result."ㅘ";
							}
						}
					}
					else if($array[$i] == 'e') {
						$result = $result."ㅞ";
					}
					else if($array[$i] == 'i') {
						$result = $result."ㅟ";
					}
					else if($array[$i] == 'o') {
						$result = $result."ㅝ";
					}
					else {
						$i--;
						$result = $result."ㅝ";
					}
				}
				break;
			case 'X':
			case 'x':
				$result = $result."ㅋ";
				$result = $result."ㅡ";
				$result = $result."ㅅ";
				$result = $result."ㅡ";
				break;
			case 'Y':
			case 'y':
				if($i == sizeof($array) - 1) {
					$result = $result."ㅏ";
					$result = $result."ㅇ";
					$result = $result."ㅣ";
				}
				else {
					$i++;
					if($array[$i] == 'a') {
						if($i == sizeof($array) - 1) {
							$result = $result."ㅒ";
						}
						else {
							$i++;
							if($array[$i] == 'e') {
								$result = $result."ㅑ";
							}
							else {
								$i--;
								$result = $result."ㅒ";
							}
						}
					}
					else if($array[$i] == 'e') {
						if($i == sizeof($array) - 1) {
							$result = $result."ㅖ";
						}
						else {
							$i++;
							if($array[$i] == 'o') {
								$result = $result."ㅕ";
							}
							else {
								$i--;
								$result = $result."ㅖ";
							}
						}
					}
					else if($array[$i] == 'o') {
						$result = $result."ㅛ";
					}
					else if($array[$i] == 'u') {
						$result = $result."ㅠ";
					}
					else {
						$i--;
						$result = $result."ㅣ";
					}
				}
				break;
			case 'Z':
			case 'z':
				$result = $result."ㅅ";
				break;
			}
		}
		//echo 'englishTokorean함수의 $result: '.$result.'<br>';
		$result_array = mb_str_split($result, $split_length = 1, $encoding = "utf-8");;
		
		return $result_array;
	}
	
	private function first_word(array $str) {
		$num = 0;
		$cho_num = 99;
		$joong_num = 99;
		$jong_num = 0;
		$result_array = [];
		
		//echo '$str['.$num.'] = '.$str[$num].'<br>';
		for($i = 0; $i < sizeof($this->cho); $i++) {
			if($str[$num] === $this->cho[$i]) {
				$cho_num = $i;
			}
		}
		
		if($cho_num == 99) {
			$cho_num = 11;
		}
		//echo 'cho_num: '.$cho_num;
		
		$num++;
		
		for($i = 0; $i < sizeof($this->joong); $i++) {
			if($str[$num] === $this->joong[$i]) {
				$joong_num = $i;
			}
		}
		//echo 'joong_num: '.$joong_num;
		
		$num++;
		
		for($i = 0; $i < sizeof($this->jong); $i++) {
			if($str[$num] === $this->jong[$i]) {
				$jong_num = $i;
			}
		}
		//echo 'jong_num: '.$jong_num;
		
		if($jong_num == 0) {
			$num--;
		}
		
		if($joong_num == 99) {
			return $result_array;
		}
		
		$num++;
		
		$uni_num = 0xAC00 + 28 * 21 * $cho_num + 28 * $joong_num + $jong_num;
		$unicode = mb_chr($uni_num, 'UTF-8');
		//echo '$unicode = '.$unicode;
		
		$result = $unicode;
		for($i = $num; $i < sizeof($str); $i++) {
			$result = $result.$str[$i];
		}
		
		$result_array = mb_str_split($result, $split_length = 1, $encoding = "utf-8");
		return $result_array;
	}
	
	private function stringTochar(String $str) {
		$array = [];
		for ($i = 0; $i < mb_strlen($str,"UTF-8"); $i++) {
			$char = mb_substr ($str, $i, 1, 'UTF-8');
			array_push ($array, $char);
		}
		$result_array = [];
		
		$str_result = $array[0];
		$uniVal = $array[1];
		//echo '$str_result = '.$str_result.', $uniVal = '.$uniVal.'<br>';
		$str_result = $str_result.$this->separate_character($uniVal);
		$result_array = mb_str_split($str_result, $split_length = 1, $encoding = "utf-8");
		
		return $result_array;
	}
	
	private function finish_symbol(array $author_char_array) {
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

	private function ord8($c) {
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
	
	public function separate_character($uniVal) {
		$result = "";

		for ($i=0; $i<mb_strlen($uniVal, 'UTF-8'); $i++) {
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
	
	public function call_symbol() {
		return $this->author_symbol;
	}
}
?>