<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Excerpt {

    var $return_data;


	function __construct()
    {
        $this->EE =& get_instance();

    	$this->indicator  = $this->EE->TMPL->fetch_param('indicator', '');
    	$this->limit      = $this->EE->TMPL->fetch_param('limit', 500);
    	$this->limit_type = $this->EE->TMPL->fetch_param('limit_type', 'words');
    	
		// cleanup limit parameter
    	if (!is_numeric($this->limit))
    	{
			$this->EE->TMPL->log_item('Excerpt: Error - limit parameter not numeric');
    		$this->limit = 500;
    	}

		// cleanup limit_type parameter
		if (in_array($this->limit_type, array('words','chars'))==FALSE)
		{
			$this->EE->TMPL->log_item('Excerpt: Error - unknown limit_type');
			$this->limit_type = 'words';
		}

		$this->return_data = $this->clean($this->EE->TMPL->tagdata);
    }


    
    function clean($str)
    {
		$str = strip_tags($str);
        $str = str_replace("\n", ' ', $str);
        $str = preg_replace("/\s+/", ' ', $str);
        $str = trim($str);
        
        $words = explode(' ', $str);
        $count = count($words);


		// limit by words
        if ($this->limit_type=='words')
        {
        	if ($count <= $this->limit)
        	{
				$this->EE->TMPL->log_item('Excerpt: '.count($words).' words, within word limit of '.$this->limit);

				return $str;
        	}
        	else
        	{
				$this->EE->TMPL->log_item('Excerpt: '.count($words).' words, words limited to '.$this->limit);

				$str = trim(implode(' ', array_slice($words, 0, $this->limit)));

				return $str . (count($words) > $this->limit ? $this->indicator : '');
			}
		}
		
		// limit by chars
		if ($this->limit_type == 'chars')
		{
			$output = "";
			
			foreach($words as $word)
			{
				$output .= $word;

				// break if longer than limit
				if (strlen($output) > $this->limit) break;
			
				$output .= ' ';
        	}

			if (strlen($output) > $this->limit)
			{
				$this->EE->TMPL->log_item('Excerpt: '.count($words).' words, chars limited to '.$this->limit);
		        return $output . $this->indicator;
			}
			else
			{
				$this->EE->TMPL->log_item('Excerpt: '.count($words).' words, withing chars limit of '.$this->limit);
		        return $output;
			}
		}

    }


	/**
	 * Usage
	 *
	 * Plugin Usage
	 *
	 * @access	public
	 * @return	string
	 */
	function usage()
	{
		ob_start(); 

		$buffer = ob_get_contents();
	
		ob_end_clean(); 

		return $buffer;
	}
}
?>
