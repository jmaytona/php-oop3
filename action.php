<?php

include 'db.php';
$object = new Database();

if(isset($_POST["action"]))
{
    if($_POST["action"] == "Load")
    {
        echo $object->get_data_in_table("SELECT * FROM medicine WHERE deleted = 0 ORDER BY id DESC");
    }
}

if(isset($_POST["action"]))
{
    if($_POST["action"] == "Insert")
    {
        $name = mysqli_real_escape_string($object->connect, $_POST["medName"]);
        $qty = mysqli_real_escape_string($object->connect, $_POST["qty"]);
        $query = "INSERT INTO medicine (name, stock) VALUES ('".$name."', '".$qty."')";
        $object->execute_query($query);
        echo 'Data Inserted';

    }
    if($_POST["action"] == "Fetch")
    {
        $output;
        $query = "SELECT * FROM medicine WHERE id = '".$_POST["user_id"]."' "; 
        $result = $object->execute_query($query);
        while($row = mysqli_fetch_array($result))
        {
            $output["name"] = $row["name"];
            $output["stock"] = $row["stock"];
            $output["id"] = $row["id"];
        }
        echo json_encode($output);   
    }
    if($_POST["action"] == "Update")
    {
        $name = mysqli_real_escape_string($object->connect, $_POST["medName"]);
        $qty = mysqli_real_escape_string($object->connect, $_POST["qty"]);
        $query = "UPDATE medicine SET name = '".$name."', stock = '".$qty."' WHERE id = '".$_POST["user_id"]."' "; 
        $object->execute_query($query);
        echo 'Data Updated';
    }
    if($_POST["action"] == "Delete")
    {
        $query = "UPDATE medicine SET deleted = 1 WHERE id = '".$_POST["user_id"]."' "; 
        $object->execute_query($query);
        echo 'Data Deleted';
    }
}




?>