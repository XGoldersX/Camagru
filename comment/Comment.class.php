<?php
require("config/database.php");

class Comment
{
	private $data = array();

	public function __construct($row)
	{
		$this->data = $row;
	}

	public function date()
	{
		$this->data['creation_date'] = strtotime($this->data['creation_date']);
		return '
			<DIV class="comment">
				<DIV class="date" title="Added at '.date('H:i \o\n d M Y',$this->data['creation_date']).'">'.date('d M Y H:i  ',$this->data['creation_date']).'</DIV>
				<P>'.$this->data['body'].'</P>
			</DIV>
		';
	}

	public static function valid(&$arr)
	{
		$errors = array();
		$data	= array();


		if(!($data['body'] = filter_input(INPUT_POST,'body',FILTER_CALLBACK,array('options'=>'Comment::valid_text'))))
			$errors['body'] = 'Please enter a comment body.';

		if(!empty($errors))
		{
			$arr = $errors;
			return false;
		}
		return true;
	}

	private static function valid_text($str)
	{
		if(mb_strlen($str,'utf8') < 1)
			return false;
		$str = nl2br(htmlspecialchars($str));
		$str = str_replace(array(chr(10),chr(13)),'',$str);
		return $str;
	}
}
?>
