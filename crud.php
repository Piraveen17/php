Index.php
<?php  include('php_code.php'); ?>
<?php 
        if (isset($_GET['edit'])) {
                $id = $_GET['edit'];
                $update = true;
        $record = mysqli_query($db, "SELECT * FROM info WHERE id=$id");

                if (mysqli_num_rows($record) == 1 ) {
                        $n = mysqli_fetch_array($record);
                        $name = $n['name'];
                        $address = $n['address'];
                }   }
?>
<!DOCTYPE html>
<html>
<head>
        <title>CRUD: CReate, Update, Delete PHP MySQL</title>
        <link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php if (isset($_SESSION['message'])): ?>
        <div class="msg">
                <?php 
                        echo $_SESSION['message']; 
                        unset($_SESSION['message']);
                ?>
        </div>
<?php endif ?>
<body>
        <?php $results = mysqli_query($db, "SELECT * FROM info"); ?>
        <table>
        <thead>  <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th colspan="2">Action</th>
                </tr>
        </thead>
            <?php while ($row = mysqli_fetch_array($results)) { ?>
                    <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td>
                                 <a href="index.php?edit=<?php echo $row['id']; ?>" class="edit_btn" >Edit</a>
                            </td>
                            <td>
                                <a href="php_code.php?del=<?php echo $row['id']; ?>" class="del_btn">Delete</a>
                            </td>
                    </tr>
            <?php } ?>
        </table>

        <form method="post" action="php_code.php" >
                <div class="input-group">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="input-group">    
                    <label>Name</label>
                    <input type="text" name="name" value="<?php echo $name; ?>">
                </div>
                <div class="input-group">
                        <label>Address</label>
                        <input type="text" name="address" value="<?php echo $address; ?>">
                </div>
                <div class="input-group">
                    <?php if ($update == true): ?>
                    <button class="btn" type="submit" name="update" style="background: #556B2F;">update</button>
                    <?php else: ?>
                    <button class="btn" type="submit" name="save" >Save</button>
                    <?php endif ?>
                </div>
        </form>
</body>
</html>
PHP_code.php
<?php 
        session_start();
        $db = mysqli_connect('localhost', 'root', '', 'crud');

        // initialize variables
        $name = "";
        $address = "";
        $id = 0;
        $update = false;

        if (isset($_POST['save'])) {
                $name = $_POST['name'];
                $address = $_POST['address'];

                mysqli_query($db, "INSERT INTO info (name, address) VALUES ('$name', '$address')"); 
                $_SESSION['message'] = "Address saved"; 
                header('location: index.php');
                exit();
        }
        if (isset($_POST['update'])) {
                $name = $_POST['name'];
                $address = $_POST['address'];
                $id = $_POST['id'];

                $result = mysqli_query($db, "UPDATE info set name = '$name' , address = '$address' WHERE id = '$id'"); 
                if($result) {   $_SESSION['message'] = "Address Updated";   }
                else{    $_SESSION['message'] = "Error";    } 
                header('location: index.php');
                exit();
        }
        if (isset($_GET['del'])) {
                $id = $_GET['del'];
                $result = mysqli_query($db,"DELETE FROM info WHERE id='$id'");
                if($result){   $_SESSION['message'] = "Address Deleted";    }
                else{   $_SESSION['message'] = "Error";    }
                header('location: index.php');
                exit();
        }



