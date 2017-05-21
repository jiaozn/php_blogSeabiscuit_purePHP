<div id="footer">
	<div id="fcontent">
	<p>Copyright<i class="fa fa-copyright fa-fw"></i>2017  <i class="fa fa-link fa-fw"></i><a href="http://www.dengnihuilai.com/about.php" rel="AboutMe">奔腾年代</a>
	版权所有，保留一切权利！<i class="fa fa-link fa-fw"></i><a href="http://www.dengnihuilai.com" rel="www.dengnihuilai.com">Theme bentengniandai</a></p>
<script type="text/javascript">
	function smenu(e){
		var nav=document.getElementById("nav");
		nav.style.display=(nav.style.display=="block"?"none":"block");
		stopBubble(e);
	}
	function ssearch(e){
		var searchbar=document.getElementById("sidebarsearch");
		searchbar.style.display=(searchbar.style.display=="block"?"none":"block");
		stopBubble(e);
	}
	//阻止事件冒泡函数
function stopBubble(e)
{
    if (e && e.stopPropagation){
		e.stopPropagation();
	}
    else{
		window.event.cancelBubble=true;
	}
        
}
function hMS(){
	var nav=document.getElementById("nav");
	nav.style.display="none";
	var searchbar=document.getElementById("sidebarsearch");
	searchbar.style.display="none";
}
</script>
	<?php
				$sql="select count(log_id) from log";
				$rowv=$mysqli->query($sql)->fetch_row();
				$vs=$rowv[0];
				
				$mysqli->close();
				//var_dump($a_array);
	$diff =microtime() - $start;
	print "<p>本页面加载用时<span id='ctime'>$diff </span>秒！<i class='fa fa-smile-o fa-fw'></i></p>";
	print "<p><i class='fa fa-hand-o-right fa-fw'></i>$vs";
	// if you want a more exact value, you could use the 
	// microtime function
	?>
	</div>
</div>

</body>

</html>


