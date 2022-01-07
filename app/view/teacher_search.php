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
						<label class="label"><?php echo "Chuyên ngành"?></label>
					</div>
					<select class="select_box" name="subject_id">
						<?php
							$chose = "";
							foreach ($subjects as $key => $value) {
								if (isset($subject) && ($subject == $key)) {
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
				$_subject = "";
				$_keyword = "";
				if (isset($_GET["search"])) {
					if ($_GET["subject_id"] != 0) {
						$_subject = $subjects[$_GET["subject_id"]];
					}
					if (!empty($_GET["keyword"])) {
						$_keyword = $_GET["keyword"];
					}
				}
				$data = getTeachers($_subject, $_keyword);
				$count = $data[0];
				$teachers = $data[1];
			?>
			<div class="information">
				<span><?php echo "Số giáo viên tìm thấy: " . $count . ""?></span>
			</div>
			<div class="details">
				<table>
					<tr>
						<th><?php echo "No."?></th>
						<th class="th_avatar"><?php echo "Ảnh đại diện"?></th>
						<th><?php echo "Tên giáo viên"?></th>
						<th><?php echo "Học vị"?></th>
						<th><?php echo "Chuyên ngành"?></th>
						<th><?php echo "Mô tả chi tiết"?></th>
						<th><?php echo "Hành động"?></th>
					</tr>
					<?php
						if ($count > 0) {
							for ($i = 0; $i < $count; $i++) {
								$teacher = $teachers[$i];
								echo "<tr>";
								echo "<td>" . $i+1 . "</td>";
								echo "<td class='td_avatar'><img src='../../web/avatar/teacher/" . $teacher["avatar"] . "''></td>";
								echo "<td>" . $teacher["name"] . "</td>";
								echo "<td>" . $teacher["degree"] . "</td>";
								echo "<td>" . getSubjectName($teacher["subject_id"]) . "</td>";
								echo "<td>" . $teacher["description"] . "</td>";
								echo "<td><div class='buttons2'><button class='button' name='delete_" . $i . "' type='submit' value='Xóa' onclick='return confirm(`Bạn chắc chắn muốn xóa thông tin giáo viên " . $teacher["name"] . "?`)'>Xóa</button><button class='button' name='edit_" . $i . "' type='submit' value='Sửa'>Sửa</button></div></td>"; 
								echo "</tr>";
							}
						} else {
							echo "<tr>";
							echo "<td>&nbsp;</td>";
							echo "<td>&nbsp;</td>";
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
				<input class="button" name="home" type="submit" value="Trở về trang chủ">
			</div>
		</form>
	</div>
</body>