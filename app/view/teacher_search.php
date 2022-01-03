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
				<div>
					<input class="button" name="search" type="submit" value="Tìm kiếm">
				</div>
			</div>
		
			<div class="information">
				<span><?php echo "Số giáo viên tìm thấy: " . count($teachers) . ""?></span>
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
								echo "<td class='td_avatar'><img src='../../web/avatar/" . $teacher["avatar"] . "''></td>";
								echo "<td>" . $teacher["name"] . "</td>";
								echo "<td>" . $teacher["degree"] . "</td>";
								echo "<td>" . getSubjectName($teacher["subject_id"]) . "</td>";
								echo "<td>" . $teacher["description"] . "</td>";
								echo "<td><div><input class='button' name='delete_" . $i . "' type='submit' value='Xóa'><input class='button' name='edit_" . $i . "' type='submit' value='Sửa'></div></td>"; 
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
			<div>
				<input class="button" name="home" type="submit" value="Trở về trang chủ">
			</div>
		</form>
	</div>
</body>