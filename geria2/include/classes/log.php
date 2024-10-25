<?php

class paginate
{
	private $db;
	
	public function __construct()
	{
		global $host, $user, $password;
		$database = new Database();
		$db = $database->dbConnection($host, "log", $user, $password);
		$this->db = $db;
    }
	
	public function dataview($query, $columns)
	{
		global $site_url;
		
		$stmt = $this->db->prepare($query);
		$stmt->execute();

		$rowCount = count($stmt->fetchAll());
		
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		
		$number=0;
		if(isset($_GET["page_no"]))
		{
			if(is_numeric($_GET["page_no"]))
			{
				if($_GET["page_no"]>1)
					$number = ($_GET["page_no"]-1)*10;
			}
		}
		if($rowCount>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{	$number++;
				
				?>
			<tr>
				<?php
					foreach($columns as $column)
						print '<td style="word-wrap:break-word; word-break:break-all;">'. $row[$column] .'</td>';
				?>
			</tr>
                <?php
			}
		}
		else
		{
			?>
            <tr>
            <td>Nothing here...</td>
            </tr>
            <?php
		}
		
	}
	
	public function paging($query,$records_per_page)
	{
		$starting_position=0;
		if(isset($_GET["page_no"]))
		{
			if(is_numeric($_GET["page_no"]))
				if($_GET["page_no"]>1)
					$starting_position=($_GET["page_no"]-1)*$records_per_page;
		}
		$query2=$query." limit $starting_position,$records_per_page";
		return $query2;
	}
	
	public function paginglink($query,$records_per_page,$first,$last,$self,$current_log)
	{		
		$self = $self.'admin/log/'.$current_log.'/';
		
		$sql = "SELECT count(*) ".strstr($query, 'FROM');
		
		$stmt = $this->db->prepare($sql);
		$stmt->execute(); 
		
		$total_no_of_records = $stmt->fetchColumn();
		
		if($total_no_of_records > 0)
		{
			?><center><ul class="pagination pagination-sm"><?php
			$total_no_of_pages=ceil($total_no_of_records/$records_per_page);
			$current_page=1;
			if(isset($_GET["page_no"]))
			{
				if(is_numeric($_GET["page_no"]))
				{
					$current_page=$_GET["page_no"];
					
					if($_GET["page_no"]<1)
						print "<script>top.location='".$self."'</script>";
					else if($_GET["page_no"]>$total_no_of_pages)
						print "<script>top.location='".$self."'</script>";
				}
			}
			if($current_page!=1)
			{
				$previous = $current_page-1;
				print "<li><a href='".$self.$previous."'>&laquo;</a></li>";
			}
			
			$x=$current_page;
			
			if($current_page+3>$total_no_of_pages)
				if($total_no_of_pages-3>0)
					$x=$total_no_of_pages-3;
				else if($total_no_of_pages-2>0)
					$x=$total_no_of_pages-2;
				else if($total_no_of_pages-1>0)
					$x=$total_no_of_pages-1;
			
			for($i=$x;$i<=$x+3;$i++)
			{
				if($i==$current_page)
					print "<li class='active'><a href='".$self.$i."'>".$i."</a></li>";
				else if($i>$total_no_of_pages)
					break;
				else
					print "<li><a href='".$self.$i."'>".$i."</a></li>";
			}
			if($current_page!=$total_no_of_pages)
			{
				$next=$current_page+1;
				print "<li><a href='".$self.$next."'>&raquo;</a></li>";
				//echo "<a class='last' href='".$self.$total_no_of_pages."'>".$last."</a>&nbsp;&nbsp;";
			}
			?></ul></center><?php
		}
	}
}