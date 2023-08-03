<?php
class BookSymbol{
    private $cho = array("ㄱ", "ㄲ", "ㄴ", "ㄷ", "ㄸ", "ㄹ", "ㅁ", "ㅂ", "ㅃ", "ㅅ", "ㅆ", "ㅇ", "ㅈ", "ㅉ", "ㅊ", "ㅋ", "ㅌ", "ㅍ", "ㅎ");
	private $joong = array("ㅏ", "ㅐ", "ㅑ", "ㅒ", "ㅓ", "ㅔ", "ㅕ", "ㅖ", "ㅗ", "ㅘ", "ㅙ", "ㅚ", "ㅛ", "ㅜ", "ㅝ", "ㅞ", "ㅟ", "ㅠ", "ㅡ", "ㅢ", "ㅣ");
	private $jong = ["", "ㄱ", "ㄲ", "ㄳ", "ㄴ", "ㄵ", "ㄶ", "ㄷ", "ㄹ", "ㄺ", "ㄻ", "ㄼ", "ㄽ", "ㄾ", "ㄿ", "ㅀ", "ㅁ", "ㅂ", "ㅄ", "ㅅ", "ㅆ", "ㅇ", "ㅈ", "ㅊ", "ㅋ", "ㅌ", "ㅍ", "ㅎ"];
	
	private $author_array = [];
    private $author_symbol;
	private $author_char_array = [];
	private $lastauthor_exist;
	
    public function __construct(String $author, boolean $bool){
        $lastauthor_exist = bool;
		$author_array = $author.split(" ");
		$this->inital();
    }
	
	private function inital() {
		$num = 0;
		
		while(english_check(author_array[$num])) {
			if(sizeof(author_array)-1 == $num) {
				break;
			}
			$num++;
		}
		
		if($num > 0) {
			if(korean_check(author_array[$num])) {
				author_char_array = stringTochar(author_array[$num]);
			}
			else {
				if(lastauthor_exist) {
					author_array = sequence_change(author_array);
				}
				author_array = englishTokorean(author_array[0]);
				author_char_array = first_word(author_array);
			}
		}
		else if(author_array.length > 1) {
			if(lastauthor_exist) {
				author_array = sequence_change(author_array);
			}
			author_char_array = stringTochar(author_array[0]);
		}
		else {
			if(korean_check(author_array[0])) {
				author_char_array = stringTochar(author_array[0]);
			}
		}
		
		if(author_char_array != null) {
			finish_symbol();
		}
	}
	
	private function korean_check(String $str) {
		return Pattern.matches("^[ㄱ-ㅎ가-힣]*$", $str);
	}
	
	private function english_check(String $str) {
		$character = [];
		
		character = $str.split(".");
		
		if(character.length > 0) {
			return Pattern.matches("^[a-zA-Z]*$", $character[0]);
		}
		else {
			return Pattern.matches("^[a-zA-Z]*$", $str);
		}
	}
	
	private function sequence_change(String $str) {
		$temp;
		
		$temp = $str[str.length-1];
		$str[sizeof($str)-1] = $str[0];
		$str[0] = $temp;
		
		return $str;
	}
	
	private function englishTokorean(String $str) {
		$result = "";
		$result_array = [];
		
		for($i = 0; $i < sizeof($str); $i++) {
			switch(str.charAt($i)) {
			case 'a':
			case 'A':
				if($i == sizeof($str) - 1) {
					$result += "ㅏ";
				}
				else {
					$i++;
					if(str.charAt($i) == 'e') {
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
				if($i == sizeof($str) - 1) {
					$result += "ㅋ";
				}
				else {
					$i++;
					if(str.charAt($i) == 'h') {
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
				if(i == sizeof($str) - 1) {
					$result += "ㅔ";
				}
				else {
					$i++;
					if(str.charAt($i) == 'o') {
						$result += "ㅓ";
					}
					else if(str.charAt($i) == 'u') {
						$result += "ㅡ";
					}
					else if(str.charAt($i) == 'e') {
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
				if($i == str.length() - 1) {
					$result += "ㅈ";
				}
				else {
					$i++;
					if(str.charAt(i) == 'j') {
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
				if($i == str.length() - 1) {
					$result += "ㅋ";
				}
				else {
					$i++;
					if(str.charAt(i) == 'k') {
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
				if($i == sizeof($str) - 1) {
					$result += "ㄴ";
				}
				else {
					$i++;
					if(str.charAt(i) == 'g') {
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
				if($i == sizeof($str) - 1) {
					$result += "ㅗ";
				}
				else {
					$i++;
					if(str.charAt(i) == 'e') {
						$result += "ㅚ";
					}
					else if(str.charAt(i) == 'o') {
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
				if($i == sizeof($str) - 1) {
					$result += "ㅍ";
				}
				else {
					$i++;
					if(str.charAt(i) == 'p') {
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
			case 's'://여기까지
				if(i == str.length() - 1) {
					$result += "ㅅ";
				}
				else {
					i++;
					if(str.charAt(i) == 's') {
						$result += "ㅆ";
					}
					else {
						i--;
						$result += "ㅅ";
					}
				}
				break;
			case 'T':
			case 't':
				if(i == str.length() - 1) {
					$result += "ㅌ";
				}
				else {
					i++;
					if(str.charAt(i) == 't') {
						$result += "ㄸ";
					}
					else {
						i--;
						$result += "ㅌ";
					}
				}
				break;
			case 'U':
			case 'u':
				if(i == str.length() - 1) {
					$result += "ㅜ";
				}
				else {
					i++;
					if(str.charAt(i) == 'i') {
						$result += "ㅢ";
					}
					else {
						i--;
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
				if(i == str.length() - 1) {
					$result += "ㅝ";
				}
				else {
					i++;
					if(str.charAt(i) == 'a') {
						if(i == str.length() - 1) {
							$result += "ㅘ";
						}
						else {
							i++;
							if(str.charAt(i) == 'e') {
								$result += "ㅙ";
							}
							else {
								i--;
								$result += "ㅘ";
							}
						}
					}
					else if(str.charAt(i) == 'e') {
						$result += "ㅞ";
					}
					else if(str.charAt(i) == 'i') {
						$result += "ㅟ";
					}
					else if(str.charAt(i) == 'o') {
						$result += "ㅝ";
					}
					else {
						i--;
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
				if(i == str.length() - 1) {
					$result += "ㅏ";
					$result += "ㅇ";
					$result += "ㅣ";
				}
				else {
					i++;
					if(str.charAt(i) == 'a') {
						if(i == str.length() - 1) {
							$result += "ㅒ";
						}
						else {
							i++;
							if(str.charAt(i) == 'e') {
								$result += "ㅑ";
							}
							else {
								i--;
								$result += "ㅒ";
							}
						}
					}
					else if(str.charAt(i) == 'e') {
						if(i == str.length() - 1) {
							$result += "ㅖ";
						}
						else {
							i++;
							if(str.charAt(i) == 'o') {
								$result += "ㅕ";
							}
							else {
								i--;
								$result += "ㅖ";
							}
						}
					}
					else if(str.charAt(i) == 'o') {
						$result += "ㅛ";
					}
					else if(str.charAt(i) == 'u') {
						$result += "ㅠ";
					}
					else {
						i--;
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
		System.out.println("englishTokorean함수의 $result: " + $result);
		$result_array = $result.split("");
		
		return $result_array;
	}
	
	private char[] first_word(String[] str) {
		int $num = 0, cho_$num = 99, joong_$num = 99, jong_$num = 0;
		String $result;
		char unicode, $result_array[] = null;
		
		for(int i = 0; i < cho.length; i++) {
			if(str[$num].equals(cho[i])) {
				cho_$num = i;
			}
		}
		
		if(cho_$num == 99) {
			cho_$num = 11;
		}
		
		System.out.println("cho_$num: " + cho_$num);
		
		$num++;
		
		for(int i = 0; i < joong.length; i++) {
			if(str[$num].equals(joong[i])) {
				joong_$num = i;
			}
		}
		
		System.out.println("joong_$num: " + joong_$num);
		
		$num++;
		
		for(int i = 0; i < jong.length; i++) {
			if(str[$num].equals(jong[i])) {
				jong_$num = i;
			}
		}
		
		System.out.println("jong_$num: " + jong_$num);
		
		if(jong_$num == 0) {
			$num--;
		}
		
		if(joong_$num == 99) {
			return $result_array;
		}
		
		$num++;
		
		unicode = (char)((cho_$num * 21 + joong_$num) * 28 + jong_$num + 0xAC00);
		System.out.println("unicode = " + unicode);
		
		$result = String.valueOf(unicode);
		for(int i = $num; i < str.length; i++) {
			$result += str[i];
		}
		
		$result_array = new char[$result.length()];
		
		for(int i = 0; i < $result.length(); i++) {
			$result_array[i] = $result.charAt(i);
		}
		
		return $result_array;
	}
	
	private char[] stringTochar(String str) {
		String str_$result;
		char uniVal, $result_array[];
		
		str_$result = String.valueOf(str.charAt(0));
		uniVal = str.charAt(1);
		
		str_$result += separate_character(uniVal);
		
		$result_array = new char[str_$result.length()];
		
		for(int i = 0; i < str_$result.length(); i++) {
			$result_array[i] = str_$result.charAt(i);
		}
		
		return $result_array;
	}
	
	private void finish_symbol() {
		int $num = 0;
		
		author_symbol = String.valueOf(author_char_array[$num]);
		
		$num++;
		
		switch(author_char_array[$num]) {
		case 'ㄱ':
		case 'ㄲ':
			author_symbol += "1";
			break;
		case 'ㄴ':
			author_symbol += "19";
			break;
		case 'ㄷ':
		case 'ㄸ':
			author_symbol += "2";
			break;
		case 'ㄹ':
			author_symbol += "29";
			break;
		case 'ㅁ':
			author_symbol += "3";
			break;
		case 'ㅂ':
		case 'ㅃ':
			author_symbol += "4";
			break;
		case 'ㅅ':
		case 'ㅆ':
			author_symbol += "5";
			break;
		case 'ㅇ':
			author_symbol += "6";
			break;
		case 'ㅈ':
		case 'ㅉ':
			author_symbol += "7";
			break;
		case 'ㅊ':
			author_symbol += "8";
			break;
		case 'ㅋ':
			author_symbol += "87";
			break;
		case 'ㅌ':
			author_symbol += "88";
			break;
		case 'ㅍ':
			author_symbol += "89";
			break;
		case 'ㅎ':
			author_symbol += "9";
			break;
		}
		
		if(author_symbol.equals(String.valueOf(author_char_array[0]))) {
			author_symbol += "6";
		}
		else {
			$num++;
		}
		
		if(author_char_array[$num-1] == 'ㅊ') {
			switch(author_char_array[$num]) {
			case 'ㅏ':
			case 'ㅐ':
			case 'ㅑ':
			case 'ㅒ':
				author_symbol += "2";
				break;
			case 'ㅓ':
			case 'ㅔ':
			case 'ㅕ':
			case 'ㅖ':
				author_symbol += "3";
				break;
			case 'ㅗ':
			case 'ㅘ':
			case 'ㅙ':
			case 'ㅚ':
			case 'ㅛ':
				author_symbol += "4";
				break;
			case 'ㅜ':
			case 'ㅝ':
			case 'ㅞ':
			case 'ㅟ':
			case 'ㅠ':
			case 'ㅡ':
			case 'ㅢ':
				author_symbol += "5";
				break;
			case 'ㅣ':
				author_symbol += "6";
				break;
			}
		}
		else {
			switch(author_char_array[$num]) {
			case 'ㅏ':
				author_symbol += "2";
				break;
			case 'ㅐ':
			case 'ㅑ':
			case 'ㅒ':
				author_symbol += "3";
				break;
			case 'ㅓ':
			case 'ㅔ':
			case 'ㅕ':
			case 'ㅖ':
				author_symbol += "4";
				break;
			case 'ㅗ':
			case 'ㅘ':
			case 'ㅙ':
			case 'ㅚ':
			case 'ㅛ':
				author_symbol += "5";
				break;
			case 'ㅜ':
			case 'ㅝ':
			case 'ㅞ':
			case 'ㅟ':
			case 'ㅠ':
				author_symbol += "6";
				break;
			case 'ㅡ':
			case 'ㅢ':
				author_symbol += "7";
				break;	
			case 'ㅣ':
				author_symbol += "8";
				break;
			}
		}
	}
	
	public String separate_character(char uniVal) {
		String $result = "";
		int $num_cho, $num_joong, $num_jong;
		
		$num_cho = (uniVal-0xAC00)/28/21;
		$num_joong = (uniVal - 0xAC00)/28%21;
		$num_jong = (uniVal - 0xAC00)%28;
		
		$result += cho[$num_cho];
		$result += joong[$num_joong];
		$result += jong[$num_jong];
		$result.trim();
		
		return $result;
	}
	
	public String call_symbol() {
		return author_symbol;
	}
}

?>