<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>TTB</title>
	<style type="text/css">
		<?php include '../../web/css/style.css'; ?>
		@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap');
	</style>
</head>

<body>
	<div class="container">
		<form action="" method="POST">
			<div class="logout">
				<input class="button_logout" name="logout" type="submit" value="Đăng xuất">
			</div>
		</form>
		<form action="" method="GET">
			<div class="form">
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Năm học"?></label>
					</div>
					<select class="select_box" name="school_year">
						<?php
							$years = array("--Chọn năm học--", "Năm 1", "Năm 2", "Năm 3", "Năm 4");
							$chose = "";
							foreach ($years as $key => $value) {
								if (isset($year) && ($year == $key)) {
									$chose = "Selected";
								} else {
									$chose = "";
								}
								echo '<option value=' . $key . ' ' . $chose . '>' . $value . '</option>';
							}
						?>
					</select>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Từ khóa"?></label>
					</div>
					<input type="text" class="form_item_input" name="keyword" placeholder="Nhập từ khóa">
				</div>
				<div class="form_item">
					<button class="button" name="search" type="submit" value="true"><?php echo "Tìm kiếm"?></button>
				</div>
			</div>
		</form>
		<form action="" method="POST">
			<?php
				$_school_year = "";
				$_keyword = "";
				if (isset($_GET["search"])) {
					if ($_GET["school_year"] != 0) {
						$_school_year = $years[$_GET["school_year"]];
					}
					if (!empty($_GET["keyword"])) {
						$_keyword = $_GET["keyword"];
					}
				}
				$data = getSubjects($_school_year, $_keyword);
				$count = $data[0];
				$subjects = $data[1];
			?>
			<div class="information">
				<span><?php echo "Số môn học tìm thấy: " . $count . ""?></span>
			</div>
			<div class="details">
				<table>
					<tr>
						<th><?php echo "No."?></th>
						<th><?php echo "Tên môn học"?></th>
						<th><?php echo "Năm học"?></th>
						<th><?php echo "Mô tả chi tiết"?></th>
						<th class="action"><?php echo "Hành động"?></th>
					</tr>
					<?php
						if ($count > 0) {
							for ($i = 0; $i < $count; $i++) {
								$subject = $subjects[$i];
								echo "<tr>";
								echo "<td>" . $i+1 . "</td>";
								echo "<td>" . $subject["name"] . "</td>";
								echo "<td>" . $subject["school_year"] . "</td>";
								echo "<td>" . $subject["description"] . "</td>";
								echo "<td><div class='buttons'><button class='button' name='delete_" . $i . "' type='submit' value='Xóa' onclick='return confirm(`Bạn chắc chắn muốn xóa môn " . $subject["name"] . "?`)'>Xóa</button><button class='button' name='edit_" . $i . "' type='submit' value='Sửa'>Sửa</button></div></td>"; 
								echo "</tr>";
							}
						} else {
							echo "<tr>";
							echo "<td>&nbsp;</td>";
							echo "<td>&nbsp;</td>";
							echo "<td>&nbsp;</td>";
							echo "<td>&nbsp;</td>";
							echo "<td>&nbsp;</td>";
							echo "</tr>";
						}
					?>
				</table>
			</div>
			<div class="form_item">
				<button class="button" name="home" type="submit" value="Trở về trang chủ"><?php echo "Trở về trang chủ"?></button>
			</div>
		</form>
	</div>
</body>