<?php
/*  class Database
 {
    public $con;
    public function __construct(){
        $this->con = mysqli_connect("localhost", "root", "", "phpoop3");
        if($this->con){
            echo "Connected";
        } else {
            echo "Not Connected";
        }
    }
 } */

 class Database
 {
    public $connect;
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "phpoop3";

    function __construct()
    {
        $this->database_connect();
    }

    public function database_connect()
    {
        $this->connect = mysqli_connect($this->host, $this->username, $this->password, $this->database);
    }

    public function execute_query($query)
    {
        return mysqli_query($this->connect, $query);
    }

    public function get_data_in_table($query)
    {
        $output = '';
        $result = $this->execute_query($query);
        $output .= '
        <table class="table table-dark" id="user_table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Medicine Name</th>
                <th scope="col">Available Stock</th>
                <th scope="col">Update</th>
                <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
        ';

        $counter = 0;//Count number
        while($row = mysqli_fetch_object($result))
        {   
            $counter++;
            $output .='
                <tr>
                    <th scope="row">'.$counter.'</th>
                    <td>'.$row->name.'</td>
                    <td>'.$row->stock.'</td>
                    <td><button type="button" class="btn btn-outline-info update" id="'.$row->id.'">Update</button></td>
                    <td><button type="button" class="btn btn-outline-danger delete"  id="'.$row->id.'">Delete</button></td>
                </tr>
            ';
           
        }
        $output .='</tbody></table>';
        return $output;
    }

 }


?>