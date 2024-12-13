
<body>
	<h1>Задание 12</h1>
Введите имя студента
<form method="post">
    <input name="name" id="name" type="text">
	<button type="submit">Отправить</button>
</form>
</body>

<?php
$p1=0;
if (isset($_POST['name'])){
	$conn = new mysqli('localhost', 'root', '', 'school_management');
	$sql = "
	    SELECT students.f_name AS student_name, students.id AS student_is, groups.g_name AS group_name 
		FROM students
        LEFT JOIN groups ON students.group_id = groups.id
        LEFT JOIN student_courses ON students.id =student_courses.student_id";

	$result = $conn->query($sql);

	while ($row = $result->fetch_assoc())
	    {if ($row["student_name"]==$_POST['name'])
			{echo 
			    "ID: ".$row["student_is"]."<br>".
			    "Имя: ". $row["student_name"]."<br>".
				"Группа: ".$row["group_name"]."<br>".
				$p1=1;}
		}
	if($p1==0){echo "Не найдено";}
	
	$conn->close();
}
?>
<br>
<h1>Задание16</h1>
<head>
    <title>16</title>
    <meta charset="utf-8">
</head>
<body>
Введите название курса
<form method="post">
    <input name="name" id="name" type="text">
	<button type="submit">Отправить</button>
</form>
</body>

<?php
$p1=0;
if (isset($_POST['name'])){
if ($_POST['name']!=""){
	$conn = new mysqli('localhost', 'root', '', 'school_management');
	$sql = "
	    SELECT students.f_name AS student_namee, students.id AS student_iss, courses.c_name AS course_namee
		FROM students
        LEFT JOIN student_courses ON students.id =student_courses.student_id
        LEFT JOIN courses ON student_courses.course_id = courses.id";

	$result = $conn->query($sql);

	while ($row = $result->fetch_assoc())
	    {if ($row["course_namee"]==$_POST['name'])
			{echo 
			    $row["student_namee"]."<br>";
				$p1=1;}
		}
	if($p1==0){echo "Не найдено";}
	
	$conn->close();
}
else{echo "Введите название!";}}
?>