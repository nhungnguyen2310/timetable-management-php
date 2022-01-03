<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home</title>
	<style type="text/css">
		<?php include 'web/css/home.css'; ?>
		@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap');
	</style>
</head>

<?php
	session_start();
	require_once 'app/common/db.php';
	require_once 'app/common/functions.php';

	if($_SESSION['authen'] == false) {
		redirect("login.php");
	}

	$date = $_SESSION["date_login"];
	$username = $_SESSION['currentuser'];

	if (isset($_POST["logout"])) {
		$_SESSION['authen'] = false;
		unset($_SESSION['currentuser']);
		unset($_SESSION['date_login']);
		redirect("login.php");
	}

	if (isset($_POST["search_teacher"])) {
		redirect("app/controller/teacher.php");
	} elseif (isset($_POST["search_subject"])) {
		redirect("app/controller/subject.php");
	} elseif (isset($_POST["search_schedule"])) {
		redirect("app/controller/schedule.php");
	} elseif (isset($_POST["add_teacher"])) {
		$_SESSION['add_teacher'] = true;
		redirect("app/controller/teacher.php");
	} elseif (isset($_POST["add_subject"])) {
		$_SESSION['add_subject'] = true;
		redirect("app/controller/subject.php");
	} elseif (isset($_POST["add_schedule"])) {
		$_SESSION['add_schedule'] = true;
		redirect("app/controller/schedule.php");
	}
?>

<body>
	<div class="container">
		<form action="" method="POST">
			<div class="information">
				<span class="information_span">
					<?php echo "Tên tài khoản: $username" ?>
					<br>
					<?php echo "Thời gian đăng nhập: $date" ?>
				</span>
				<input class="button" name="logout" type="submit" value="Đăng xuất">
			</div>

			<div class="information_table">
				<table>
					<tr>
						<th>Giáo viên</th>
						<th>Môn học</th>
						<th>Thời khóa biểu</th>
					</tr>
					<tr>
						<td>
							<div class="func">
								<input class="button" name="search_teacher" type="submit" value="Tìm kiếm">
							</div>
						</td>
						<td>
							<div class="func">
								<input class="button" name="search_subject" type="submit" value="Tìm kiếm">
							</div>
						</td>
						<td>
							<div class="func">
								<input class="button" name="search_schedule" type="submit" value="Tìm kiếm">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="func">
								<input class="button" name="add_teacher" type="submit" value="Thêm mới">
							</div>
						</td>
						<td>
							<div class="func">
								<input class="button" name="add_subject" type="submit" value="Thêm mới">
							</div>
						</td>
						<td>
							<div class="func">
								<input class="button" name="add_schedule" type="submit" value="Thêm mới">
							</div>
						</td>
					</tr>
				</table>
			</div>
		</form>
	</div>
</body>
</html>