<?php
//conetion tom a databse
$host = "localhost";
$username = "root";
$password = "";
$database = "php-practice";
$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
  echo "error";
}
$insert = false;
if(isset($_REQUEST['delete_id'])&& $_REQUEST['delete_id'] > 0){
  $sql_delete = "DELETE FROM `notes` WHERE id=". $_REQUEST['delete_id'];
  $delete = mysqli_query($conn,$sql_delete);
  if($delete){
    echo "Note deletes successfully";
    header("location:http://localhost/curd");
  }
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if(isset($_REQUEST['id']) &&  $_REQUEST['id'] > 0){
    $title = $_REQUEST['edit_title'];
    $description = $_REQUEST['edit_description'];
    $sql_update = "UPDATE `notes` SET `title` = '".$title ."',`description` = '".$description."' WHERE id=".$_REQUEST['id'];
    $update = mysqli_query($conn,$sql_update);
    if($update){
      echo "Note Updates successfully";
    }
  }else{
    $title = $_REQUEST['title'];
    $description = $_REQUEST['description'];
    $sql_insert = "INSERT INTO `notes` (`title`,`description`) values ('" . $title . "','" . $description . "')";
    $res = mysqli_query($conn, $sql_insert);
    if ($res) {
      $insert = true;
    }
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>



</head>

<body>
  <!-- Button trigger modal -->

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Note</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="post" action="">
            <input type="hidden" name="id" value="" id="id">
            <div class="mb-3">
              <label for="title" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="edit_title" name="edit_title" placeholder="Note Title">
            </div>
            <div class="mb-3">
              <label for="desc" class="form-label">Note Description</label>
              <textarea class="form-control" id="edit_description" name="edit_description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Edit Note</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">PHP CURD</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Contact us</a>
          </li>
        </ul>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
  <?php
    if ($insert) {
    ?>
      <div class="alert alert-success" role="alert">
        Note inserted successfully.
      </div>
    <?php
    }
    ?>
  <div class="container my-5">
    <h2>Add Note</h2>
    <form method="post" action="">
      <div class="mb-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Note Title">
      </div>
      <div class="mb-3">
        <label for="desc" class="form-label">Note Description</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>
    <table class="table my-10" id="myTable">
      <thead>
        <tr>
          <th scope="col">Id</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM `notes`";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>
          <th scope='row'>" . $row["id"] . "</th>
          <td>" . $row["title"] . "</td>
          <td>" . $row["description"] . "</td>
          <td><button class='edit btn btn-primary' id='".$row["id"]."'> Edit</button> <button class='delete btn btn-primary' id='".$row["id"]."'> Delete</button></td>
        </tr>";
        };
        ?>
      </tbody>
    </table>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css" />

  <script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
          //console.log("edit", e.target.parentNode.parentNode)
          tr = e.target.parentNode.parentNode;
          title = tr.getElementsByTagName('td')[0].innerText;
          description = tr.getElementsByTagName('td')[1].innerText;
          $("#exampleModal").modal('toggle');
          $("#edit_title").val(title);
          $("#edit_description").val(description);
          $("#id").val(e.target.id)
          //console.log(title, description);
        })
      })
     //delete
     deletes = document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
          //console.log("edit", e.target.parentNode.parentNode)
          id = e.target.id;
          if(window.confirm('Are you sure?')){
            window.location.href="http://localhost/curd?delete_id="+id
          }
        })
      })
    });
  </script>
</body>

</html>