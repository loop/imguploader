<?php

/* this function creates a randon alpha code */
function randomStr($min_chars = 4, $max_chars = 15)
{
	$use_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $num_chars  = rand($min_chars, $max_chars);
    $num_usable = strlen($use_chars) - 1;
    $string     = '';

    for($i = 0; $i < $num_chars; $i++)
    {
        $rand_char = rand(0, $num_usable);

        $string .= $use_chars{$rand_char};
    }

    return $string;
}


/* this function checks for a valid email address */
function check_email($email)
{
	$valid = true;
	
	if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email))
	{
		$valid = false;
	}
	
	return $valid;
}


/* this function checks for a valid username */
function check_username($user)
{
	$valid = true;
	
	if(!eregi("^([a-zA-Z0-9_]+)$", $user))
	{
		$valid = false;
	}
	
	return $valid;
}


/* this function formats file size */
function format_size($bytes, $format=99)
{
    $byte_size = 1024;
	$byte_type = array(" KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");

	$bytes /= $byte_size;
	$i = 0;

	if($format == 99 || $format > 7){
		while($bytes > $byte_size){
			$bytes /= $byte_size;
			$i++;
		}
	}
	else{
		while($i < $format){
			$bytes /= $byte_size;
			$i++;
		}
	}

	$bytes = sprintf("%1.2f", $bytes);
	$bytes .= $byte_type[$i];

	return $bytes;
}


/* this function converts days to months for use with premium accounts */
function days_to_months($days)
{
    // if days are below one month
	if($days < 30){ return $days . " days"; }
	
	// calculate days in month
	$months = $days / 30;
	
	// set lang
	if($months < 2){ $lang = "month"; }else{ $lang = "months"; }
	
	// return output
	return "$months $lang";
}


/* this function cuts text to a certain length */
function truncate($string, $limit, $break = '.', $pad = '..')
{
    // return with no change if string is shorter than $limit
    if(strlen($string) <= $limit) return $string;

    // is $break present between $limit and the end of the string?
    if(false !== ($breakpoint = strpos($string, $break, $limit)))
    {
        if($breakpoint < strlen($string) - 1)
        {
            $string = substr($string, 0, $breakpoint) . $pad;
        }
    }

    return $string;
}


/* log admin action */
function admin_log($action, $action_text)
{
    // build query
	$q = "INSERT INTO site_logs (action,
								 action_text,
								 action_date
								 ) VALUES (
								 '".$action."',
								 '".$action_text."',
								 '".time()."')";
	
	// run query
	mysql_query($q);
}

?>