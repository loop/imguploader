<?php

/* check if GD is available */
if(!function_exists('gd_info')){ exit(); }

/* start sessions */
@session_start();

/* set header content type */
header("Content-type: image/png");

/* set image size */
$img_handle = @ImageCreate(67, 20);

/* set bg colour */
$back_color = @ImageColorAllocate($img_handle, 255, 255, 255);

/* make bg transparent */
$transparent_bg = @ImageColorTransparent($img_handle, $back_color);

/* reset vars */
$count = 0;
$code = "";

/* create captcha */
while($count < 6)
{
    $count++;
	$x_axis = -5 + ($count * 10);
	$y_axis = rand(0, 7);
	$color1 = rand(101, 160);
	$color2 = rand(021, 170);
	$color3 = rand(031, 190);
	$txt_color[$count] = @ImageColorAllocate($img_handle, $color1, $color2, $color3);
	$size = rand(3, 5);
	$number = rand(0, 9);
	$code .= "$number";
	@ImageString($img_handle, $size, $x_axis, $y_axis, "$number", $txt_color[$count]);
}

/* set pix colour */
$pixel_color = @ImageColorAllocate($img_handle, 100, 100, 100);

/* set session containing the code */
$_SESSION['code'] = $code;

/* display captcha */
@ImagePng($img_handle);

/* stop any further scripting */
exit();

?>