<div class="xy-news-header">
  <div class="left">
    <h3 class="mb-0"><?php print $lang['ranking']; ?></h3>
  </div>
  <div class="right">
    <ul class="xy-nh-ul">
		<li><a href="#" class="active"><?php print $lang['players']; ?></a></li>
		<li><a href="<?php print $site_url; ?>ranking/guilds"><?php print $lang['guilds']; ?></a></li>
    </ul>
  </div>
</div>
<div class="ranking-page">
	<div class="padding-container">
		<div class="jumbotron jumbotron-fluid" style="padding: 1rem 2rem;">
			<form action="" method="POST">
				<div class="row">
					<div class="col-lg-7">
						<input type="text" name="search" class="form-control" placeholder="<?php print $lang['name']; ?>" value="<?php if(isset($search)) print htmlentities($search); ?>">
					</div>
					<div class="col-lg-5">
						<button type="submit" class="btn btn-danger"><i class="fa fa-search fa-1" aria-hidden="true"></i> <?php print $lang['search']; ?></button>
					</div>
				</div>
			</form>
		</div>
	
	<table class="table table-dark table-striped">
		<thead class="thead-inverse">
			<tr>
				<th>#</th>
				<th><?php print $lang['name']; ?></th>
				<th><?php print $lang['empire']; ?></th>
				<th class="level-table"><?php print $lang['level']; ?></th>
				<th class="exp-table">EXP</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$records_per_page=20;
				
				if(isset($search))
				{
					$query = "SELECT id, name, account_id, level, exp FROM player WHERE name NOT LIKE '[%]%' AND name LIKE :search ORDER BY level DESC, exp DESC, playtime DESC, name ASC";
					$newquery = $paginate->paging($query,$records_per_page);
					$paginate->dataview($newquery, $search);
				} else {
					$query = "SELECT id, name, account_id, level, exp FROM player WHERE name NOT LIKE '[%]%' ORDER BY level DESC, exp DESC, playtime DESC, name ASC";
					$newquery = $paginate->paging($query,$records_per_page);
					$paginate->dataview($newquery);
				}
			?>
			</tbody>
		</table>
		<?php
			if(isset($search))
				$paginate->paginglink($query,$records_per_page,$lang['first-page'],$lang['last-page'],$site_url,$search);
			else
				$paginate->paginglink($query,$records_per_page,$lang['first-page'],$lang['last-page'],$site_url);
		?>
	</div>
</div>