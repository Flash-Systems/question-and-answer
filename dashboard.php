<?php include('./includes/db_connect.php');?>

<div class="container-fluid">
<style>
	input[type=checkbox]
{
  /* Double-sized Checkboxes */
  -ms-transform: scale(1.5); /* IE */
  -moz-transform: scale(1.5); /* FF */
  -webkit-transform: scale(1.5); /* Safari and Chrome */
  -o-transform: scale(1.5); /* Opera */
  transform: scale(1.5);
  padding: 10px;
}
.list-group-item +  .list-group-item {
    border-top-width: 1px !important;
}
</style>

	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Dashboard</b><br />
						<span class=""><br />
						<span class="badge badge-success text-white"><?php echo "Welcome back ". $_SESSION['login_name']."!"  ?></span>
				</span>
					</div>
					<div class="card-body">
						<ul class="w-100 list-group" id="topic-list">
							<?php
							$tag = $conn->query("SELECT * FROM categories order by name asc");
							while($row= $tag->fetch_assoc()):
								$tags[$row['id']] = $row['name'];
							endwhile;
							$topic = $conn->query("SELECT t.*,u.name FROM questions t inner join users u on u.id = t.user_id order by unix_timestamp(date_created) desc");
							while($row= $topic->fetch_assoc()):
								$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
						        unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
						        $desc = strtr(html_entity_decode($row['content']),$trans);
						        $desc=str_replace(array("<li>","</li>"), array("",","), $desc);
						        $view = $conn->query("SELECT * FROM question_views where topic_id=".$row['id'])->num_rows;
						        $comments = $conn->query("SELECT * FROM comments where topic_id=".$row['id'])->num_rows;
						        $replies = $conn->query("SELECT * FROM replies where comment_id in (SELECT id FROM comments where topic_id=".$row['id'].")")->num_rows;
							?>
							<li class="list-group-item mb-4">
								<div>
									<?php if($_SESSION['login_id'] == $row['user_id'] || $_SESSION['login_type'] == 1): ?>
					                    
				                    <?php endif; ?>
				                    <span class="float-right mr-4"><small><i>Created: <?php echo date('M d, Y h:i A',strtotime($row['date_created'])) ?></i></small></span>
									<?php echo $row['title'] ?></a>

								</div>
								<hr>
								<p class="truncate filter-text"><?php echo strip_tags($desc) ?></p>
								<p class="row justify-content-left"><span class="badge badge-success text-white"><i>Posted By: <?php echo $row['name'] ?></i></span></p>
								<hr>
								
								
								<span class="float-right">
									<span><small>Question Category: </small></span>
								<?php 
								foreach(explode(",",$row['category_ids']) as $cat):
								?>
								<span class="badge badge-info text-white ml-2"><?php echo $tags[$cat] ?></span>
							<?php endforeach; ?>
								</span>
							</li>
						<?php endwhile; ?>
						</ul>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height: :150px;
	}
</style>
<script>
	$(document).ready(function(){
		$('table').dataTable()
	})
	$('#topic-list').JPaging({
	    pageSize: 15,
	    visiblePageSize: 10

	  });

	$('#new_topic').click(function(){
		uni_modal("New Question","manage_topic.php",'mid-large')
	})
	
	$('.edit_topic').click(function(){
		uni_modal("Edit Topic","manage_topic.php?id="+$(this).attr('data-id'),'mid-large')
		
	})
	$('.delete_topic').click(function(){
		_conf("Are you sure to delete this topic?","delete_topic",[$(this).attr('data-id')],'mid-large')
	})

	function delete_topic($id){
		start_load()
		$.ajax({
			url:'ajax_call.php?action=delete_topic',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>