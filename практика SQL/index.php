<?php
$host = 'localhost';
$db = 'school_management';
$user = 'root';
$password = '';
$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error){
    die('' . $conn->connect_error);
}
echo 'соединение установленно'
?>
<br>
<h1>Задание 2</h1>
<body>
Введите имя студента
<form method="post">
    <input name="names" id="names" type="text">
	<button type="submit">Отправить</button>
</form>
</body>
<?php
if (isset($_POST['names'])) {
	if ($_POST['names']!=''){
	    $stmt = $conn->prepare("INSERT INTO students (f_name) VALUES (?)");
        $stmt->bind_param("s", $name);

        $name = $_POST['names'];
        $stmt->execute();

        $stmt->close();
	    header("Location: " . $_SERVER['PHP_SELF']);}
	else {echo 'Введите имя!';};
}
?>

<br>
<h1>Задание 3</h1>
<?php
$sql = "SELECT id, f_name FROM students";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Номер</th>
                <th>ФИО</th>
            </tr>";
    
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["f_name"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 результатов";
}
?>
<br>
<h1>Задание 4</h1>
<!DOCTYPE html>
<html>
    <body>
        <form method="POST" action="">
            <input name="g_name" type="text" placeholder="Название группы"/>
            <input type="submit" value="Зарегистрировать">
        </form>
    </body>
</html>
<?php
if (isset($_POST['g_name'])) {
	if ($_POST['g_name']!=''){
	    $stmt = $conn->prepare("INSERT INTO groups (g_name) VALUES (?)");
        $stmt->bind_param("s", $name);

        $name = $_POST['g_name'];
        $stmt->execute();

        $stmt->close();
	    header("Location: " . $_SERVER['PHP_SELF']);}
	else {echo 'Введите группу';};
}
?>
<br>
<h1>Задание 5</h1>
<?php

$sql_students = "SELECT id, f_name FROM students";
$result_students = $conn->query($sql_students);
$sql_groups = "SELECT id, g_name FROM groups";
$result_groups = $conn->query($sql_groups);
?>

<form method="POST" action="">
    <label for="student">Выберите студента:</label>
    <select name="student_id" id="student">
        <?php while ($student = $result_students->fetch_assoc()): ?>
            <option value="<?php echo $student['id']; ?>">
                <?php echo $student['f_name']; ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label for="groups">Выберите группу:</label>
    <select name="group_id" id="groups">
        <?php while ($group = $result_groups->fetch_assoc()): ?>
            <option value="<?php echo $group['id']; ?>">
                <?php echo $group['g_name']; ?>
            </option>
        <?php endwhile; ?>
    </select>

    <button type="submit">Обновить</button>
</form>
<?php
$student_id = $_POST['student_id'];
$group_id = $_POST['group_id'];

$sql_update = "UPDATE students SET group_id = ? WHERE id = ?";
$stmt = $conn->prepare($sql_update);
$stmt->bind_param("ii", $group_id, $student_id);

if ($stmt->execute()) {
    echo "";
} else {
    echo "Ошибка при обновлении группы: " . $conn->error;
}
?>
<br>
<h1>Задание 6</h1>
<?php
$sql = "SELECT students.f_name AS student_name, groups.g_name AS group_name 
        FROM students 
        LEFT JOIN groups ON students.group_id = groups.id";
$result = $conn->query($sql);

if ($result->num_rows > 0){
    echo"<table border ='1'>
            <tr>
                <th>ФИО</th>
                <th>Группа</th>
            </tr>";
while($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>" . $row["student_name"] . "</td>
            <td>" . $row["group_name"] . "</td>
          </tr>";
}
echo "</table>";
}
?>
<br>
<h1>Задание 7</h1>
<form method="post">
	    <div >
	        Введите id студента
            <input name="studentid" id="studentid" type="number">
		</div>
		
		<div>
		    Введите id курса
		    <input name="course" id="course" type="number">
		</div>
		
	    <button type="submit">Связать</button>
    </form>
<?php
		if (isset($_POST['studentid']) and isset($_POST['course'])) 
		{
			if ($_POST['studentid']!='' and $_POST['course']!=''){
				$stmt = $conn->prepare("INSERT INTO student_courses (student_id,course_id) VALUES (?,?)");
				$stmt->bind_param("ii",$stud,$courseid);

				$stud = $_POST['studentid'];
				$courseid = $_POST['course'];
				
				$stmt->execute();
				header("Location: " . $_SERVER['PHP_SELF']);}
			else {echo 'Заполните все поля!';};
		}
	?>
<br>
<h1>Задание 8</h1>
<table border =>
    <tr>
	    <td>Название курса</td>
		<td>Количество студентов на курсе</td>
	</tr>
<?php

$sql = "SELECT courses.c_name AS course_name, COUNT(student_courses.student_id) AS student_count 
        FROM courses 
        LEFT JOIN student_courses ON courses.id = student_courses.course_id 
        GROUP BY courses.c_name";
        
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>"."<td>".$row["course_name"]."</td>"."<td>". $row["student_count"]."</td>"."</tr>";
            }
        } 
        ?>
</table>
<br>
<h1>Задание 9</h1>

Введите id студента для удаления
<form method="post">
    <input name="nameu" id="nameu" type="number">
	<button type="submit">Удалить</button>
</form>

<?php
if (isset($_POST['nameu'])) {
	if ($_POST['nameu']!=''){
	    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
        $stmt->bind_param("i", $id);
		
		$stmt2 = $conn->prepare("DELETE FROM student_courses WHERE student_id = ?");
        $stmt2->bind_param("i", $id);
		
        $id = $_POST['nameu'];
		
		$stmt2->execute();
        $stmt->execute();
        $stmt2->close();
		$stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);}
	else {echo 'Введите id!';};
}
?>
<br>
<h1>Задание 10</h1>

<h1>Обновление имени студента</h1>
    <form action="" method="POST">
        <label for="id">ID студента:</label>
        <input type="number" id="idd" name="idd" required>
        <br>
        <label for="name">Новое имя:</label>
        <input type="text" id="namee" name="namee" required>
        <br>
        <input type="submit" value="Обновить">
    </form>

<?php
$id = $_POST['idd'];
$name = $_POST['namee'];

$sql = "UPDATE students SET f_name=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $name, $id);

if ($stmt->execute()) {
    echo "Имя студента успешно обновлено.";
} else {
    echo "Ошибка: " . $stmt->error;
}
?>
<br>
<h1>Задание 11</h1>
<?php
$sql = "SELECT teachers.t_name AS teacher_name, courses.c_name AS course_name 
FROM teachers 
LEFT JOIN courses ON teachers.id = courses.teacher_id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table><tr><th>Преподаватель</th><th>Курс</th></tr>";
    // Вывод данных каждой строки
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . htmlspecialchars($row["teacher_name"]) . "</td><td>" . htmlspecialchars($row["course_name"] ?? 'Нет курсов') . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 результатов";
}
?>
<br>
<h1>Задание 13</h1>

<?php
$conn = new mysqli('localhost', 'root', '', 'school_management');

$sql = "SELECT * FROM students";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
		if ($row["group_id"]=="")
		    {echo $row["f_name"].$row["group_id"]."<br>";}}}
else
    {echo "Не найдено.";}
?>

<br>
<h1>Задание 14</h1>
<body>
Введите Название курса
<form method="post">
    <input name="namec" id="namec" type="text">
	<button type="submit">Отправить</button>
</form>
</body>
<?php
if (isset($_POST['namec'])) {
	if ($_POST['namec']!=''){
	    $stmt = $conn->prepare("INSERT INTO courses (c_name) VALUES (?)");
        $stmt->bind_param("s", $name);

        $name = $_POST['namec'];
        $stmt->execute();

        $stmt->close();
    }
}
?>
<br>
<h1>Задание 15</h1>

<body>
Введите имя преподавателя
<form method="post">
    <input name="namet" id="namet" type="text">
	<button type="submit">Отправить</button>
</form>
</body>
<?php
if (isset($_POST['namet'])) {
	if ($_POST['namet']!=''){
	    $stmt = $conn->prepare("INSERT INTO teachers (t_name) VALUES (?)");
        $stmt->bind_param("s", $name);

        $name = $_POST['namet'];
        $stmt->execute();

        $stmt->close();
    }
}
?>
<br>
<h1>Задание 17</h1> 

Введите id курса, который нужно удалить
<form method="post">
    <input name="namer" id="namer" type="number">
	<button type="submit">Удалить</button>
</form>
</body>

<?php

if (isset($_POST['namer'])) {
	if ($_POST['namer']!=''){
	    $stmt = $conn->prepare("DELETE FROM courses WHERE id = ?");
        $stmt->bind_param("i", $id);
		
		$stmt2 = $conn->prepare("DELETE FROM student_courses WHERE course_id = ?");
        $stmt2->bind_param("i", $id);
		
        $id = $_POST['namer'];
		
        $stmt2->execute();
        $stmt->execute();
        $stmt2->close();
		$stmt->close();
    }
}
?>
<br>
<h1>Задание 18</h1>
<form method="POST">
<?php
$conn = new mysqli('localhost', 'root', '', 'school_management');

$sql = "SELECT * FROM groups";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo
		"<input type='radio' name='gruppa' value=".$row['id'].">".$row['g_name']."<br>";
    }
} else {
    echo "Нет студентов.";
}

$conn->close();
?>
<button type="submit">Отправить</button>
</form>

<?php
$p1=0;
$conn = new mysqli('localhost', 'root', '', 'school_management');

$sql = "SELECT groups.g_name AS group_name, groups.id AS id, students.f_name AS student_name FROM groups LEFT JOIN students ON groups.id=students.group_id";
$result = $conn->query($sql);

if (isset($_POST['gruppa'])){
	while ($row = $result->fetch_assoc()){
        if ($_POST['gruppa']==$row['id']){
			echo 
			    $row['student_name'].'<br>';
				if ($row['student_name']!='')
				    {$p1=1;}}}
	$conn->close();
	
	if($p1==0){echo 'В этой группе никто не учится';}
};
?>

<br>
<h1>Задание 19</h1>
<?php
$conn = new mysqli('localhost', 'root', '', 'school_management');
$sql = "SELECT students.f_name AS student_name, COUNT(student_courses.course_id) AS course_count 
        FROM students 
        JOIN student_courses ON students.id = student_courses.student_id 
        GROUP BY students.id 
        HAVING course_count > 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Имя студента</th><th>Количество курсов</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["student_name"] . "</td><td>" . $row["course_count"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "Нет студентов, зарегистрированных на более чем одном курсе.";
}
$conn->close();
?>
<br>
<h1>Задание 20</h1>
<h1>Список преподавателей и количество студентов</h1>
<?php
$conn = new mysqli('localhost', 'root', '', 'school_management');

$sql = "SELECT teachers.t_name AS teacher_name, COUNT(student_courses.student_id) AS total_students 
        FROM teachers 
        JOIN courses ON teachers.id = courses.teacher_id 
        JOIN student_courses ON courses.id = student_courses.course_id 
        GROUP BY teachers.id";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Имя преподавателя</th>
                <th>Количество студентов</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['teacher_name'] . "</td>
                <td>" . $row['total_students'] . "</td>
              </tr>";
    }
    
    echo "</table>";
} else {
    echo "Нет данных.";
}
$conn->close();
?>
<br>
<h2>Бывает</h2>
<?php 
echo '<a href="12and16.php" class="button green">12 и 16 задание</a>';
?>
