<?php
class BookSymbol{
    private $cho = array("ㄱ", "ㄲ", "ㄴ", "ㄷ", "ㄸ", "ㄹ", "ㅁ", "ㅂ", "ㅃ", "ㅅ", "ㅆ", "ㅇ", "ㅈ", "ㅉ", "ㅊ", "ㅋ", "ㅌ", "ㅍ", "ㅎ");
	private $joong = array("ㅏ", "ㅐ", "ㅑ", "ㅒ", "ㅓ", "ㅔ", "ㅕ", "ㅖ", "ㅗ", "ㅘ", "ㅙ", "ㅚ", "ㅛ", "ㅜ", "ㅝ", "ㅞ", "ㅟ", "ㅠ", "ㅡ", "ㅢ", "ㅣ");
	private $jong = ["", "ㄱ", "ㄲ", "ㄳ", "ㄴ", "ㄵ", "ㄶ", "ㄷ", "ㄹ", "ㄺ", "ㄻ", "ㄼ", "ㄽ", "ㄾ", "ㄿ", "ㅀ", "ㅁ", "ㅂ", "ㅄ", "ㅅ", "ㅆ", "ㅇ", "ㅈ", "ㅊ", "ㅋ", "ㅌ", "ㅍ", "ㅎ"];
	
    private $author_symbol;
	private $lastauthor_exist;
	
    public function __construct(String $author, bool $bool){
        $this->lastauthor_exist = $bool;
		$author_array = mb_str_split($author, $split_length = 1, $encoding = "utf-8");
		$this->inital($author_array);
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
		return preg_match("^[ㄱ-ㅎ가-힣]*$", $str);
	}
	
	private function english_check(String $str) {
		$character = explode( '.', $str );
		
		if(sizeof($character) > 0) {
			return preg_match("^[a-zA-Z]*$", $character[0]);
		}
		else {
			return preg_match("^[a-zA-Z]*$", $str);
		}
	}
	
	private function sequence_change(array $str) {
		$temp = $str[sizeof($str)];
		$str[sizeof($str)-1] = $str[0];
		$str[0] = $temp;
		
		return $str;
	}
	
	private function englishTokorean(String $str) {
		$result = "";
		$result_array = [];
		$array = explode( '', $str );
		
		for($i = 0; $i < sizeof($array); $i++) {
			switch($array[$i]) {
			case 'a':
			case 'A':
				if($i == sizeof($array) - 1) {
					$result += "ㅏ";
				}
				else {
					$i++;
					if($array[$i] == 'e') {
						$result += "ㅐ";
					}
					else {
						$i--;
						$result += "ㅏ";
					}
				}
				break;
			case 'b':
			case 'B':
				$result += "ㅂ";
				break;
			case 'c':
			case 'C':
				if($i == sizeof($array) - 1) {
					$result += "ㅋ";
				}
				else {
					$i++;
					if($array[$i] == 'h') {
						$result += "ㅊ";
					}
					else {
						$i--;
						$result += "ㅋ";
					}
				}
				break;
			case 'd':
			case 'D':
				$result += "ㄷ";
				break;
			case 'e':
			case 'E':
				if($i == sizeof($array) - 1) {
					$result += "ㅔ";
				}
				else {
					$i++;
					if($array[$i] == 'o') {
						$result += "ㅓ";
					}
					else if($array[$i] == 'u') {
						$result += "ㅡ";
					}
					else if($array[$i] == 'e') {
						$result += "ㅣ";
					}
					else {
						$i--;
						$result += "ㅔ";
					}
				}
				break;
			case 'f':
			case 'F':
				$result += "ㅍ";
				break;
			case 'G':
			case 'g':
				$result += "ㄱ";
				break;
			case 'H':
			case 'h':
				$result += "ㅎ";
				break;
			case 'I':
			case 'i':
				$result += "ㅣ";
				break;
			case 'J':
			case 'j':
				if($i == sizeof($array) - 1) {
					$result += "ㅈ";
				}
				else {
					$i++;
					if($array[$i] == 'j') {
						$result += "ㅉ";
					}
					else {
						$i--;
						$result += "ㅈ";
					}
				}
				break;
			case 'K':
			case 'k':
				if($i == sizeof($array) - 1) {
					$result += "ㅋ";
				}
				else {
					$i++;
					if($array[$i] == 'k') {
						$result += "ㄲ";
					}
					else {
						$i--;
						$result += "ㅋ";
					}
				}
				break;
			case 'L':
			case 'l':
				$result += "ㄹ";
				break;
			case 'M':
			case 'm':
				$result += "ㅁ";
				break;
			case 'N':
			case 'n':
				if($i == sizeof($array) - 1) {
					$result += "ㄴ";
				}
				else {
					$i++;
					if($array[$i] == 'g') {
						$result += "ㅇ";
					}
					else {
						$i--;
						$result += "ㄴ";
					}
				}
				break;
			case 'O':
			case 'o':
				if($i == sizeof($array) - 1) {
					$result += "ㅗ";
				}
				else {
					$i++;
					if($array[$i] == 'e') {
						$result += "ㅚ";
					}
					else if($array[$i] == 'o') {
						$result += "ㅜ";
					}
					else {
						$i--;
						$result += "ㅗ";
					}
				}
				break;
			case 'P':
			case 'p':
				if($i == sizeof($array) - 1) {
					$result += "ㅍ";
				}
				else {
					$i++;
					if($array[$i] == 'p') {
						$result += "ㅃ";
					}
					else {
						$i--;
						$result += "ㅍ";
					}
				}
				break;
			case 'Q':
			case 'q':
				$result += "ㅋ";
				break;
			case 'R':
			case 'r':
				$result += "ㄹ";
				break;
			case 'S':
			case 's':
				if($i == sizeof($array) - 1) {
					$result += "ㅅ";
				}
				else {
					$i++;
					if($array[$i] == 's') {
						$result += "ㅆ";
					}
					else {
						$i--;
						$result += "ㅅ";
					}
				}
				break;
			case 'T':
			case 't':
				if($i == sizeof($array) - 1) {
					$result += "ㅌ";
				}
				else {
					$i++;
					if($array[$i] == 't') {
						$result += "ㄸ";
					}
					else {
						$i--;
						$result += "ㅌ";
					}
				}
				break;
			case 'U':
			case 'u':
				if($i == sizeof($array) - 1) {
					$result += "ㅜ";
				}
				else {
					$i++;
					if($array[$i] == 'i') {
						$result += "ㅢ";
					}
					else {
						$i--;
						$result += "ㅜ";
					}
				}
				break;
			case 'V':
			case 'v':
				$result += "ㅂ";
				break;
			case 'W':
			case 'w':
				if($i == sizeof($array) - 1) {
					$result += "ㅝ";
				}
				else {
					$i++;
					if($array[$i] == 'a') {
						if($i == sizeof($array) - 1) {
							$result += "ㅘ";
						}
						else {
							$i++;
							if($array[$i] == 'e') {
								$result += "ㅙ";
							}
							else {
								$i--;
								$result += "ㅘ";
							}
						}
					}
					else if($array[$i] == 'e') {
						$result += "ㅞ";
					}
					else if($array[$i] == 'i') {
						$result += "ㅟ";
					}
					else if($array[$i] == 'o') {
						$result += "ㅝ";
					}
					else {
						$i--;
						$result += "ㅝ";
					}
				}
				break;
			case 'X':
			case 'x':
				$result += "ㅋ";
				$result += "ㅡ";
				$result += "ㅅ";
				$result += "ㅡ";
				break;
			case 'Y':
			case 'y':
				if($i == sizeof($array) - 1) {
					$result += "ㅏ";
					$result += "ㅇ";
					$result += "ㅣ";
				}
				else {
					$i++;
					if($array[$i] == 'a') {
						if($i == sizeof($array) - 1) {
							$result += "ㅒ";
						}
						else {
							$i++;
							if($array[$i] == 'e') {
								$result += "ㅑ";
							}
							else {
								$i--;
								$result += "ㅒ";
							}
						}
					}
					else if($array[$i] == 'e') {
						if($i == sizeof($array) - 1) {
							$result += "ㅖ";
						}
						else {
							$i++;
							if($array[$i] == 'o') {
								$result += "ㅕ";
							}
							else {
								$i--;
								$result += "ㅖ";
							}
						}
					}
					else if($array[$i] == 'o') {
						$result += "ㅛ";
					}
					else if($array[$i] == 'u') {
						$result += "ㅠ";
					}
					else {
						$i--;
						$result += "ㅣ";
					}
				}
				break;
			case 'Z':
			case 'z':
				$result += "ㅅ";
				break;
			}
		}
		//echo 'englishTokorean함수의 $result: '.$result;
		$result_array = explode('', $result);
		
		return $result_array;
	}
	
	private function first_word(array $str) {
		$num = 0;
		$cho_num = 99;
		$joong_num = 99;
		$jong_num = 0;
		$result_array = [];
		
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
		
		$unicode = ($cho_num * 21 + $joong_num) * 28 + $jong_num + 0xAC00;
		//echo 'unicode = '.$unicode;
		
		$result = $unicode;
		for($i = $num; $i < sizeof($str); $i++) {
			$result += $str[$i];
		}
		
		$result_array = mb_str_split($result, $split_length = 1, $encoding = "utf-8");
		return $result_array;
	}
	
	private function stringTochar(String $str) {
		$array = mb_str_split($str, $split_length = 1, $encoding = "utf-8");
		$result_array = [];
		
		$str_result = $array[0];
		$uniVal = $array[1];
		$str_result += $this->separate_character($uniVal);
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
			$this->author_symbol += "1";
			break;
		case 'ㄴ':
			$this->author_symbol += "19";
			break;
		case 'ㄷ':
		case 'ㄸ':
			$this->author_symbol += "2";
			break;
		case 'ㄹ':
			$this->author_symbol += "29";
			break;
		case 'ㅁ':
			$this->author_symbol += "3";
			break;
		case 'ㅂ':
		case 'ㅃ':
			$this->author_symbol += "4";
			break;
		case 'ㅅ':
		case 'ㅆ':
			$this->author_symbol += "5";
			break;
		case 'ㅇ':
			$this->author_symbol += "6";
			break;
		case 'ㅈ':
		case 'ㅉ':
			$this->author_symbol += "7";
			break;
		case 'ㅊ':
			$this->author_symbol += "8";
			break;
		case 'ㅋ':
			$this->author_symbol += "87";
			break;
		case 'ㅌ':
			$this->author_symbol += "88";
			break;
		case 'ㅍ':
			$this->author_symbol += "89";
			break;
		case 'ㅎ':
			$this->author_symbol += "9";
			break;
		}
		
		if($this->author_symbol == $author_char_array[0]) {
			$this->author_symbol += "6";
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
				$this->author_symbol += "2";
				break;
			case 'ㅓ':
			case 'ㅔ':
			case 'ㅕ':
			case 'ㅖ':
				$this->author_symbol += "3";
				break;
			case 'ㅗ':
			case 'ㅘ':
			case 'ㅙ':
			case 'ㅚ':
			case 'ㅛ':
				$this->author_symbol += "4";
				break;
			case 'ㅜ':
			case 'ㅝ':
			case 'ㅞ':
			case 'ㅟ':
			case 'ㅠ':
			case 'ㅡ':
			case 'ㅢ':
				$this->author_symbol += "5";
				break;
			case 'ㅣ':
				$this->author_symbol += "6";
				break;
			}
		}
		else {
			switch($author_char_array[$num]) {
			case 'ㅏ':
				$this->author_symbol += "2";
				break;
			case 'ㅐ':
			case 'ㅑ':
			case 'ㅒ':
				$this->author_symbol += "3";
				break;
			case 'ㅓ':
			case 'ㅔ':
			case 'ㅕ':
			case 'ㅖ':
				$this->author_symbol += "4";
				break;
			case 'ㅗ':
			case 'ㅘ':
			case 'ㅙ':
			case 'ㅚ':
			case 'ㅛ':
				$this->author_symbol += "5";
				break;
			case 'ㅜ':
			case 'ㅝ':
			case 'ㅞ':
			case 'ㅟ':
			case 'ㅠ':
				$this->author_symbol += "6";
				break;
			case 'ㅡ':
			case 'ㅢ':
				$this->author_symbol += "7";
				break;	
			case 'ㅣ':
				$this->author_symbol += "8";
				break;
			}
		}
	}
	
	public function separate_character($uniVal) {
		$result = "";
		
		$num_cho = ($uniVal-0xAC00)/28/21;
		$num_joong = ($uniVal - 0xAC00)/28%21;
		$num_jong = ($uniVal - 0xAC00)%28;
		
		$result += $this->cho[$num_cho];
		$result += $this->joong[$num_joong];
		$result += $this->jong[$num_jong];
		trim($result);
		
		return $result;
	}
	
	public function call_symbol() {
		return $this->author_symbol;
	}
}
?>