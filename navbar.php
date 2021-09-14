
<style>
	.collapse a{
		text-indent:10px;
	}
	nav#sidebar{
		background: url(includes/uploads/<?php echo $_SESSION['system']['cover_img'] ?>) !important
	}
</style>

<nav id="sidebar" class='mx-lt-5 bg-dark' >
		
		<div class="sidebar-list">
				<a href="index.php?page=dashboard" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Dashboard</a>
				<a href="index.php?page=questions" class="nav-item nav-topics"><span class='icon-field'><i class="fa fa-comment"></i></span> Ask Question</a>
				<a href="index.php?page=answers" class="nav-item nav-categories"><span class='icon-field'><i class="fa fa-tags"></i></span> Answer Question</a>
				<?php if($_SESSION['login_type'] == 1): ?>
				<a href="index.php?page=categories" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-comment"></i></span> Question Categories</a>
				<?php endif; ?>
				<a href="ajax_call.php?action=logout" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Log out</a>
		</div>

</nav>
<script>
	$('.nav_collapse').click(function(){
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
