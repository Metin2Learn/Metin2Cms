<div class="container">
	<div class="page-hd">
		<div class="bd-c">
			<h2 class="pre-social"><?php print $lang['download']; ?></h2>
		</div>
	</div>
	<div class="padding-container">
		<?php if(count($jsondataDownload)) { ?>
		<table class="table table-dark table-striped">
			<thead class="thead-inverse">
				<tr>
					<th class="center" style="width: 15%">#</th>
					<th class="center" style="width: 60%">Server</th>
					<th class="center"><?php print $lang['download']; ?></th>
				</tr>
			</thead>
			<tbody>
			<?php $i=1; foreach($jsondataDownload as $key => $download) { ?>
				<tr>
					<th class="center" scope="row"><?php print $i++; ?></th>
					<td class="center"><?php print $download['name']; ?></td>
					<td class="center"><a href="<?php print $download['link']; ?>" class="btn btn-danger btn-sm"><?php print $lang['download']; ?></a></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<?php } else { ?>
		<div class="alert alert-info" role="alert">
			<strong>Info!</strong> <?php print $lang['no-download-links']; ?>
		</div>
		<?php } ?>
	</div>
</div>