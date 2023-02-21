<?php
include("langselect.php");
$maindir = "your_files";
	if(is_dir($maindir)) {
		chdir('your_files');
	} else {
		mkdir('your_files');
		chdir('your_files');
		}
include("configuration.php");
if ($accessdenied == true){
	header('Location: accessdenied.php');
}
else{
  
}

chdir('../');
$file = 'log.txt';

if(!is_file($file)){
    $contents = '';       
    file_put_contents($file, $contents);   
}
chdir('your_files');



//Disable error report for undefined superglobals
error_reporting(E_ERROR | E_PARSE);
error_reporting( error_reporting() & ~E_NOTICE );

if($PASSWORD) {

	session_start();
	if(!$_SESSION['_sfm_allowed']) {
		// sha1, and random bytes to thwart timing attacks.  Not meant as secure hashing.
		$t = bin2hex(openssl_random_pseudo_bytes(10));
		if($_POST['p'] && sha1($t.$_POST['p']) === sha1($t.$PASSWORD)) {
			$_SESSION['_sfm_allowed'] = true;
			header('Location: ?');
		}
		echo '<title>';
		echo ($linelogin);
		echo '</title>';
		echo '
		<html><body>
		<link rel="stylesheet" href="maincssfilepartforfmaccess.css"> 
		<style>
		p{
			margin-bottom:5px;
				margin-top:5px;
				font-size: 20px;
			  background:
			  linear-gradient(to right,
			  #00e6e6,
			  #1ac6ff);
			  display: inline-block;
			
			
			  -webkit-background-clip: text;
			  background-clip: text;
			  color: transparent;
		}
		body{
			background-color:#242424;
			font-family: "lucida grande","Segoe UI",Arial, sans-serif;
		}
		.centeredlogin{
			position: fixed;
			left: 50%;
			top: 50%;
			transform: translate(-50%, -50%);
			background-color: white;
			padding:30px;
			box-shadow: 0 2px 6px rgb(0 0 0 / 20%);
			width: 400px;
			height: auto;
			}
			input[type=password] {
				width: 100%;
				padding: 12px 0px;
				margin: 8px 0;
				box-sizing: border-box;
				border-bottom: 1px solid black;
				border-top:none;
				border-left:none;
				border-right:none;
				outline: none !important;
			  }
			  .logo{
				color:black;
				font-family: Segoe UI;
				font-size:50px;
			  }
			  
			  .logodiv{
				text-align: center;
			  }
			  .text{
				margin-bottom:5px;
				margin-top:5px;
				font-size: 46px;
			  background:
			  linear-gradient(to right,
			  #00e6e6,
			  #1ac6ff);
			  display: inline-block;
			
			
			  -webkit-background-clip: text;
			  background-clip: text;
			  color: transparent;
			}
			</style>
			<div class="centeredlogin">
			<div class="logodiv">
			<h1 class="text">NEQULOS FILEOP</h1>
			<br>
			<p>';
			echo ($linetypepassword);
			echo '</p>
            </div>
			<form action=? method=post><input type=password name=p autofocus placeholder="';
			echo ($lineyourpassword);
			echo '"/>
			</form>
			</div>
			</body>
			</html>';
			
		exit;
	}
}


// must be in UTF-8 or `basename` doesn't work
setlocale(LC_ALL,'UTF-8');

$tmp_dir = dirname($_SERVER['SCRIPT_FILENAME']);
if(DIRECTORY_SEPARATOR==='\\') $tmp_dir = str_replace('/',DIRECTORY_SEPARATOR,$tmp_dir);
$tmp = get_absolute_path($tmp_dir . '/' .$_REQUEST['file']);

if($tmp === false)
	err(404,'404');
if(substr($tmp, 0,strlen($tmp_dir)) !== $tmp_dir)
	err(403,"403");
if(strpos($_REQUEST['file'], DIRECTORY_SEPARATOR) === 0)
	err(403,"403");
if(preg_match('@^.+://@',$_REQUEST['file'])) {
	err(403,"403");
}


if(!$_COOKIE['_sfm_xsrf'])
	setcookie('_sfm_xsrf',bin2hex(openssl_random_pseudo_bytes(16)));
if($_POST) {
	if($_COOKIE['_sfm_xsrf'] !== $_POST['xsrf'] || !$_POST['xsrf'])
		err(403,"XSRF Failure");
}

$file = $_REQUEST['file'] ?: '.';

if($_GET['do'] == 'list') {
	if (is_dir($file)) {
		$directory = $file;
		$result = [];
		$files = array_diff(scandir($directory), ['.','..']);
		foreach ($files as $entry) if (!is_entry_ignored($entry, $allow_show_folders, $hidden_patterns)) {
			$i = $directory . '/' . $entry;
			$stat = stat($i);
			$result[] = [
				'mtime' => $stat['mtime'],
				'size' => $stat['size'],
				'name' => basename($i),
				'path' => preg_replace('@^\./@', '', $i),
				'is_dir' => is_dir($i),
				'is_deleteable' => $allow_delete && ((!is_dir($i) && is_writable($directory)) ||
														(is_dir($i) && is_writable($directory) && is_recursively_deleteable($i))),
				'is_readable' => is_readable($i),
				'is_writable' => is_writable($i),
				'is_executable' => is_executable($i),
			];
		}
		usort($result,function($f1,$f2){
			$f1_key = ($f1['is_dir']?:2) . $f1['name'];
			$f2_key = ($f2['is_dir']?:2) . $f2['name'];
			return $f1_key > $f2_key;
		});
	} else {
		err(412,"412");
	}
	echo json_encode(['success' => true, 'is_writable' => is_writable($file), 'results' =>$result]);
	exit;
} elseif ($_POST['do'] == 'delete') {
	if($allow_delete) {
		rmrf($file);
	}
	exit;
} elseif ($_POST['do'] == 'mkdir' && $allow_create_folder) {
	// don't allow actions outside root. we also filter out slashes to catch args like './../outside'
	$dir = $_POST['name'];
	$dir = str_replace('/', '', $dir);
	if(substr($dir, 0, 2) === '..')
	    exit;
	chdir($file);
	@mkdir($_POST['name']);
	exit;
} elseif ($_POST['do'] == 'upload' && $allow_upload) {
	foreach($disallowed_patterns as $pattern)
		if(fnmatch($pattern, $_FILES['file_data']['name']))
			err(403,"403");

	$res = move_uploaded_file($_FILES['file_data']['tmp_name'], $file.'/'.$_FILES['file_data']['name']);
	exit;
} elseif ($_GET['do'] == 'download') {
	foreach($disallowed_patterns as $pattern)
		if(fnmatch($pattern, $file))
			err(403,"403");

	$filename = basename($file);
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	header('Content-Type: ' . finfo_file($finfo, $file));
	header('Content-Length: '. filesize($file));
    header("Content-Disposition: attachment; filename=".$filename);
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header("Content-Transfer-Encoding: binary");
while (ob_get_level()) {
    ob_end_clean();
}
readfile($file);
	header(sprintf('Content-Disposition: attachment; filename=%s',
		strpos('MSIE',$_SERVER['HTTP_REFERER']) ? rawurlencode($filename) : "\"$filename\"" ));
	ob_flush();
	readfile($file);
	exit;
}

function is_entry_ignored($entry, $allow_show_folders, $hidden_patterns) {
	if ($entry === basename(__FILE__)) {
		return true;
	}

	if (is_dir($entry) && !$allow_show_folders) {
		return true;
	}
	foreach($hidden_patterns as $pattern) {
		if(fnmatch($pattern,$entry)) {
			return true;
		}
	}
	return false;
}

function rmrf($dir) {
	if(is_dir($dir)) {
		$files = array_diff(scandir($dir), ['.','..']);
		foreach ($files as $file)
			rmrf("$dir/$file");
		rmdir($dir);
	} else {
		unlink($dir);
	}
}
function is_recursively_deleteable($d) {
	$stack = [$d];
	while($dir = array_pop($stack)) {
		if(!is_readable($dir) || !is_writable($dir))
			return false;
		$files = array_diff(scandir($dir), ['.','..']);
		foreach($files as $file) if(is_dir($file)) {
			$stack[] = "$dir/$file";
		}
	}
	return true;
}

// from: http://php.net/manual/en/function.realpath.php#84012
function get_absolute_path($path) {
        $path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
        $parts = explode(DIRECTORY_SEPARATOR, $path);
        $absolutes = [];
        foreach ($parts as $part) {
            if ('.' == $part) continue;
            if ('..' == $part) {
                array_pop($absolutes);
            } else {
                $absolutes[] = $part;
            }
        }
        return implode(DIRECTORY_SEPARATOR, $absolutes);
    }

function err($code,$msg) {
	http_response_code($code);
	header("Content-Type: application/json");
	echo json_encode(['error' => ['code'=>intval($code), 'msg' => $msg]]);
	exit;
}

function asBytes($ini_v) {
	$ini_v = trim($ini_v);
	$s = ['g'=> 1<<30, 'm' => 1<<20, 'k' => 1<<10];
	return intval($ini_v) * ($s[strtolower(substr($ini_v,-1))] ?: 1);
}
$MAX_UPLOAD_SIZE = min(asBytes(ini_get('post_max_size')), asBytes(ini_get('upload_max_filesize')));

?>
<!DOCTYPE html>
<link rel="stylesheet" href="maincssfilepartforfmaccess.css">  
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<html lang="en">
	<title><?php if ($servername){echo $servername;} else{echo "NEQULOS FILEOP";}?></title>
	<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<div class="vulcloud">
	
	<?php
	
if ($security_warnings == 'false'){

}
if ($security_warnings == 'true'){
	include 'vulpasslist.php';
}

	?>
</div>
<div class="header">

	<div class='parent'>
  <div class='child1'><h1 class="text">NEQULOS FILEOP</h1>
  <br>
  <p class="logoslogan"><?php echo($wordversionn1);?> 2.0S</p></div>
  <div class='child3'><div class="textright">
  <p class="namesr"><?php if ($servername){echo $servername;} else{echo $wordservern1;}?>
	</p>
	<p><?php if ($description){echo $description;} else{echo "NEQULOS FILEOP";}?>
	</p>
  <?php
    echo("<a href='settings.php'>" . $wordsettings . "</a><br>");
  if($PASSWORD){
    echo("<a href='logoutadmin.php'>" . $wordlogout . "</a>");
  }

  ?>
  
</div>
</div>
  <div class='child2'><div class="textright">
  <p class="namesr"><?php echo($wordservern1);?>
	</p>
	<p><?php echo($worddescription);?>
	</p>
	<p><?php echo ($wordlinks);?>
	</p>
</div>
</div>
</div>
<div class="headermini">
<b class="namesr" style="color:black;border-bottom:2px black solid"><?php echo($worddashboard);?>
</b>
</div>

</div>

<script src="./jquery.min.js"></script>
<!-- jquery not in use -->
<script>
(function($){
	$.fn.tablesorter = function() {
		var $table = this;
		this.find('th').click(function() {
			var idx = $(this).index();
			var direction = $(this).hasClass('sort_asc');
			$table.tablesortby(idx,direction);
		});
		return this;
	};
	$.fn.tablesortby = function(idx,direction) {
		var $rows = this.find('tbody tr');
		function elementToVal(a) {
			var $a_elem = $(a).find('td:nth-child('+(idx+1)+')');
			var a_val = $a_elem.attr('data-sort') || $a_elem.text();
			return (a_val == parseInt(a_val) ? parseInt(a_val) : a_val);
		}
		$rows.sort(function(a,b){
			var a_val = elementToVal(a), b_val = elementToVal(b);
			return (a_val > b_val ? 1 : (a_val == b_val ? 0 : -1)) * (direction ? 1 : -1);
		})
		this.find('th').removeClass('sort_asc sort_desc');
		$(this).find('thead th:nth-child('+(idx+1)+')').addClass(direction ? 'sort_desc' : 'sort_asc');
		for(var i =0;i<$rows.length;i++)
			this.append($rows[i]);
		this.settablesortmarkers();
		return this;
	}
	$.fn.retablesort = function() {
		var $e = this.find('thead th.sort_asc, thead th.sort_desc');
		if($e.length)
			this.tablesortby($e.index(), $e.hasClass('sort_desc') );

		return this;
	}
	$.fn.settablesortmarkers = function() {
		this.find('thead th span.indicator').remove();
		this.find('thead th.sort_asc').append('<span class="indicator">&darr;<span>');
		this.find('thead th.sort_desc').append('<span class="indicator">&uarr;<span>');
		return this;
	}
})(jQuery);
$(function(){
	var XSRF = (document.cookie.match('(^|; )_sfm_xsrf=([^;]*)')||0)[2];
	var MAX_UPLOAD_SIZE = <?php echo $MAX_UPLOAD_SIZE ?>;
	var $tbody = $('#list');
	$(window).on('hashchange',list).trigger('hashchange');
	$('#table').tablesorter();

	$('#table').on('click','.delete',function(data) {
		$.post("",{'do':'delete',file:$(this).attr('data-file'),xsrf:XSRF},function(response){
			list();
		},'json');
		return false;
	});

	$('#mkdir').submit(function(e) {
		var hashval = decodeURIComponent(window.location.hash.substr(1)),
			$dir = $(this).find('[name=name]');
		e.preventDefault();
		$dir.val().length && $.post('?',{'do':'mkdir',name:$dir.val(),xsrf:XSRF,file:hashval},function(data){
			list();
		},'json');
		$dir.val('');
		return false;
	});
<?php if($allow_upload): ?>
	// file upload stuff
	$('#file_drop_target').on('dragover',function(){
		$(this).addClass('drag_over');
		return false;
	}).on('dragend',function(){
		$(this).removeClass('drag_over');
		return false;
	}).on('drop',function(e){
		e.preventDefault();
		var files = e.originalEvent.dataTransfer.files;
		$.each(files,function(k,file) {
			uploadFile(file);
		});
		$(this).removeClass('drag_over');
	});
	$('input[type=file]').change(function(e) {
		e.preventDefault();
		$.each(this.files,function(k,file) {
			uploadFile(file);
		});
	});
	


	function uploadFile(file) {
		var folder = decodeURIComponent(window.location.hash.substr(1));

		if(file.size > MAX_UPLOAD_SIZE) {
			var $error_row = renderFileSizeErrorRow(file,folder);
			$('#upload_progress').append($error_row);
			window.setTimeout(function(){$error_row.fadeOut();},5000);
			return false;
		}

		var $row = renderFileUploadRow(file,folder);
		$('#upload_progress').append($row);
		var fd = new FormData();
		fd.append('file_data',file);
		fd.append('file',folder);
		fd.append('xsrf',XSRF);
		fd.append('do','upload');
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '?');
		xhr.onload = function() {
			$row.remove();
    		list();
  		};
		xhr.upload.onprogress = function(e){
			if(e.lengthComputable) {
				$row.find('.progress').css('width',(e.loaded/e.total*100 | 0)+'%' );
			}
		};
	    xhr.send(fd);
		
	}
	function renderFileUploadRow(file,folder) {
		return $row = $('<div/>')
			.append( $('<span class="fileuploadname" />').text( (folder ? folder+'/':'')+file.name))
			.append( $('<div class="progress_track"><div class="progress"></div></div>')  )
			.append( $('<span class="size" />').text(formatFileSize(file.size)) )
	};
	function renderFileSizeErrorRow(file,folder) {
		return $row = $('<div class="error" />')
			.append( $('<span class="fileuploadname" />').text( 'Error: ' + (folder ? folder+'/':'')+file.name))
			.append( $('<span/>').html(' file size - <b>' + formatFileSize(file.size) + '</b>'
				+' exceeds max upload size of <b>' + formatFileSize(MAX_UPLOAD_SIZE) + '</b>')  );
	}
<?php endif; ?>
	function list() {
		var hashval = window.location.hash.substr(1);
		$.get('?do=list&file='+ hashval,function(data) {
			$tbody.empty();
			$('#breadcrumb').empty().html(renderBreadcrumbs(hashval));
			if(data.success) {
				$.each(data.results,function(k,v){
					$tbody.append(renderFileRow(v));
				});
				!data.results.length && $tbody.append('<tr><td class="empty" colspan=5>∅</td></tr>')
				data.is_writable ? $('body').removeClass('no_write') : $('body').addClass('no_write');
			} else {
				console.warn(data.error.msg);
			}
			$('#table').retablesort();
		},'json');
	}
	function renderFileRow(data) {
		var $link = $('<a class="name" />')
			.attr('href', data.is_dir ? '#' + encodeURIComponent(data.path) : './your_files/' + data.path)
			.text(data.name);
		var allow_direct_link = <?php echo $allow_direct_link?'true':'false'; ?>;
        	if (!data.is_dir && !allow_direct_link)  $link.css('pointer-events','none');
		var $dl_link = $('<a/>').attr('href','?do=download&file='+ encodeURIComponent(data.path))
			.addClass('download').text('↓');
		var $delete_link = $('<a href="#" />').attr('data-file',data.path).addClass('delete').text('✕');
		var perms = [];
		if(data.is_readable) perms.push('r');
		if(data.is_writable) perms.push('w');
		if(data.is_executable) perms.push('e');
		var $html = $('<tr />')
			.addClass(data.is_dir ? 'is_dir' : '')
			.append( $('<td class="first" />').append($link) )
			.append( $('<td/>').attr('data-sort',data.is_dir ? -1 : data.size)
				.html($('<span class="size" />').text(formatFileSize(data.size))) )
			.append( $('<td/>').attr('data-sort',data.mtime).text(formatTimestamp(data.mtime)) )
			.append( $('<td/>').text(perms.join('+')) )
			.append( $('<td/>').append($dl_link).append( data.is_deleteable ? $delete_link : '') )
		return $html;
	}
	function renderBreadcrumbs(path) {
		var base = "",
			$html = $('<div/>').append( $('<a href=#>~</a></div>') );
		$.each(path.split('%2F'),function(k,v){
			if(v) {
				var v_as_text = decodeURIComponent(v);
				$html.append( $('<span/>').text(' ▸ ') )
					.append( $('<a/>').attr('href','#'+base+v).text(v_as_text) );
				base += v + '%2F';
			}
		});
		return $html;
	}
	function formatTimestamp(unix_timestamp) {
		var m = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
		var d = new Date(unix_timestamp*1000);
		return [m[d.getMonth()],'/',d.getDate(),'/',d.getFullYear()," ",
			(d.getHours() % 12 || 12),":",(d.getMinutes() < 10 ? '0' : '')+d.getMinutes(),
			" ",d.getHours() >= 12 ? 'PM' : 'AM'].join('');
	}
	function formatFileSize(bytes) {
		var s = ['B','KB','MB','GB','TB','PB','EB'];
		for(var pos = 0;bytes >= 1000; pos++,bytes /= 1024);
		var d = Math.round(bytes*10);
		return pos ? [parseInt(d/10),".",d%10," ",s[pos]].join('') : bytes + ' B';
	}
})

</script>

</head>
<body>
	
<div class='parent1'>
<h2 style='text-align:left;padding-left:10px;'><?php echo($lineimportsandfoldercreation);?></h2>
<div class='child'>	
<div id="top">
	
   <?php if($allow_create_folder): ?>
	<form action="?" method="post" id="mkdir">
	<div class='parent2'>
	<div class='childp2'>
		<label for=dirname><?php echo($linecreatenewfolder);?></label><input id=dirname type=text name=name value="" required/>
   </div>
   <div class='childp2'>
		<input type="submit" value="<?php echo($wordcreate);?>" />
   </div>
   </div>
		
	</form>
	<br>
   <?php endif; ?>
   </div>
   <?php if($allow_upload): ?>
	<br>
	<div id="file_drop_target">
	<?php echo($linedragfileshere);?>
		<b><?php echo($wordor)?></b>
		<button style="cursor:pointer" onclick="$('#input').click()"><?php echo($linechoosefiles);?></button>
<input type="file" multiple id="input" style="display:none;">
		  
	</div>
	<br>
   
   <?php endif; ?>
   </div>
   </div>
 

<div class='parent1'>
<h2 style='text-align:left;padding-left:10px;'><?php echo($wordfiles);?></h2>
<div class='child'>
	<br>
	<h2 style="font-size:20px;">
<div id="breadcrumb">&nbsp;</div>
   </h2>
<div class="container">
<table id="table">

<thead>
<tr>

	<th><?php echo($wordtablename);?></th>
	<th><?php echo($wordtablesize);?></th>
	<th><?php echo($wordtablemodified);?></th>
	<th><?php echo($wordtablepermissions);?></th>
	<th><?php echo($wordtableactions);?></th>
</tr></thead><tbody id="list">
  
</tbody></table>
<br>
</div>
</div>
</div>
   </div>
   </div>
 <div class='parent1'>
   <h2 style='text-align:left;padding-left:10px;'><?php echo($lineuploadprogress);?></h2>
   <div class='child'>
   <?php echo($lineoverallprogress);?>
<div id="upload_progress"></div>
   </div>
   </div>
	<?php
if ($filetest){
if ($filetest == true){
	include("mainfiletest.php");
}
else {
   
}
}
else{
	
}
?>
<div class='parent1'>

<div class="child">
<h2><?php echo($linehelpguide);?></h2>
<hr>
<?php
include('nqshelpguide.php');
?>
<br>
</div>
<style>
.footer {
   position: static;
   left: 0;
   bottom: 0;
   width: 100%;
   color: white;
   text-align: center;
}
</style>
<div class="footer">
  <p>NEQULOS &copy; <?php echo($lineallrightsreservedn1);?></p>
</div>

</body></html>