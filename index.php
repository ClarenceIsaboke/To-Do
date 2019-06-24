
<?php
   
	$errors = "";

	// connect to database
	$db = mysqli_connect("localhost", "root", "", "tasks");

if (isset($_GET['del_task'])) {
    $id = $_GET['del_task'];

    mysqli_query($db, "DELETE FROM `todo` WHERE id=".$id);
    header('location: index.php');
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($db, "SELECT * FROM todo WHERE id=".$id);

    if (count($record) == 1 ) {
        $n = mysqli_fetch_array($record);
        $task = $n['task'];
        $date = $n['date'];
        $status = $n['status'];
    }
}



	// insert a quote if submit button is clicked
	if (isset($_POST['submit'])) {
		if (empty($_POST['task'])) {
			$errors = "You must fill in the task";
		}else{
			$task = $_POST['task'];
			$sql = "INSERT INTO `todo`(`id`, `task`, `date`, `status`)
                                  VALUES (null,'$task','$date','$status')";
			mysqli_query($db, $sql);
			header('location: index.php');
		}
	}

	// ...
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tasks | To Do</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

</head>
<body>

<div class="container">



    <div class="row justify-content-center">
        <div class="col-sm-10">


            <div class="card">
                <div class="card-header bg-dark"><h2 class="text-white text-center font-weight-bold " style="font-size: 25px">Tasks | To Do</h2>
                </div>
                <div class="card-body bg-warning">

                    <form method="post" action="index.php" class="input_form">
                        <?php if (isset($errors)) { ?>
                            <p><?php echo $errors; ?></p>
                        <?php } ?>
                        <input type="text" name="task" >
                        <input type="date" name="date" >
                        <select name="status" >
                            <option value="">Complete</option>
                            <option value="">Pending</option>
                            <option value="">Not Complete</option>
                        </select>

                        <button type="submit" name="submit" id="add_btn" class="btn btn-success">Add Task</button>


                    </form>



                    <table id="tasks" class="table">
                        <thead>
                        <tr>
                            <th>Task Id</th>
                            <th>List of Task</th>
                            <th>Date To-Do</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php

                        $tasks = mysqli_query($db, "SELECT * FROM todo");

                        $i = 1;
                        while ($row = mysqli_fetch_assoc($tasks)) { ?>
                            <tr>
                                <td> <?php echo $i; ?> </td>
                                <td class="task"> <?php echo $row['task']; ?> </td>
                                <td class="date"> <?php echo $row['date']; ?> </td>
                                <td class="status"> <?php echo $row['status']; ?> </td>
                                <td class="delete">
                                    <a class="btn btn-danger" href="index.php?del_task=<?php echo $row['id'] ?>">Delete Task</a>
                                </td>
                            </tr>
                            <?php $i++; } ?>
                        </tbody>
                    </table>

                </div>

            </div>

        </div>
    </div>
</div>




<script>
    $(document).ready(function() {
        $('#tasks').DataTable();
    } );

</script>
</body>
</html>