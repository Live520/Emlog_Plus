<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  dir="<?php echo  EMLOG_LANGUAGE_DIR ?>" lang="<?php echo EMLOG_LANGUAGES?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>upload</title>
<link href="./views/css/css-att.css?v=<?php echo Option::EMLOG_VERSION; ?>" type=text/css rel=stylesheet>
 <script src="<?php echo BLOG_URL ?>lang/<?php echo EMLOG_LANGUAGES ?>/lang_js.js"></script>
<script type="text/javascript" src="./views/js/common.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
</head>
<script>
function showupload(multi){
	var as_logid = parent.document.getElementById('as_logid').value
	window.location.href="attachment.php?action=selectFile&logid="+as_logid+"&multi="+multi;	
}
function showattlib(){
	var as_logid = parent.document.getElementById('as_logid').value
	window.location.href="attachment.php?action=attlib&logid="+as_logid;	
}
</script>
<body>
<div id="media-upload-header">
	<span><a href="javascript:showupload(0);"><?php echo langs('attachment_upload')?></a></span>
	<span><a href="javascript:showupload(1);"><?php echo langs('bulk_upload')?></a></span>
	<span id="curtab"><a href="javascript:showattlib();"><?php echo langs('attachment_library')?>（<?php echo $attachnum; ?>）</a></span>
</div>
<div id="media-upload-body">
<?php if(!$attach): ?>
<p id="attmsg"><?php echo langs('no_attachments')?></p>
<?php else:
foreach($attach as $key=>$value):
	$extension  = strtolower(substr(strrchr($value['filepath'], "."),1));
	$atturl = BLOG_URL.substr($value['filepath'], 3);
	if ($extension == 'zip' || $extension == 'rar'){
		$imgpath = "./views/images/tar.gif";
		$embedlink = "<a href=\"javascript: parent.addattach_file('$atturl', '{$value['filename']}', {$value['aid']});\">".langs('insert')." </a>";
	} elseif (in_array($extension, array('gif', 'jpg', 'jpeg', 'png', 'bmp'))) {
		$imgpath = $value['filepath'];
		$ed_imgpath = BLOG_URL.substr($imgpath,3);
		$embedlink = "<a href=\"javascript: parent.addattach_img('$atturl', '$ed_imgpath',{$value['aid']}, '{$value['width']}', '{$value['height']}', '{$value['filename']}');\" title=\"".langs('insert_full_size')."\">".langs('full_size')."</a>";
		
	if (isset($value['thum_filepath'])) {
			$thum_url = BLOG_URL.substr($value['thum_filepath'], 3);
			$embedlink .= " <a href=\"javascript: parent.addattach_img('$atturl', '$thum_url',{$value['aid']}, '{$value['thum_width']}', '{$value['thum_height']}', '{$value['filename']}');\" title=\"".langs('insert_thumbnail')."\">".langs('thumbnails')."</a>";
		}
	} else {
		$imgpath = "./views/images/fnone.gif";
		$embedlink = "<a href=\"javascript: parent.addattach_file('$atturl', '{$value['filename']}', {$value['aid']});\">".langs('insert')."</a>";
	}
?>
	<li id="attlist"><a href="<?php echo $atturl; ?>" target="_blank" title="<?php echo $value['filename']; ?>"><img src="<?php echo $imgpath; ?>" width="90" height="90" border="0" align="absmiddle"/></a>
	<?php if ($value['width'] && $value['height']): ?>
	<br />
	<?php echo $value['width']?>x<?php echo $value['height']?>
	<?php else:?>
	<br />
	<?php echo subString($value['filename'], 0, 6) ?>
	<?php endif;?>
	<br /><a href="javascript: em_confirm(<?php echo $value['aid']; ?>, 'attachment', '<?php echo LoginAuth::genToken(); ?>');"><?php echo langs('delete')?></a> <?php echo $embedlink; ?></li>
<?php endforeach; endif; ?>
</div>
</body>
</html>
