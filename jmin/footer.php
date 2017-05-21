<?php
	$mysqli->close();
?>

	 <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="bootstrap/assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="bootstrap/assets/js/ie10-viewport-bug-workaround.js"></script>
<div id="footer">
奔腾年代 荣誉出品
</div>
<span id="utime">
<?php
	$diff =microtime() - $start;
	print "<p>本页面加载用时<span id='ctime'>$diff </span>秒！<i class='fa fa-smile-o fa-fw'></i></p>";
?>
</span>
</body>

</html>
