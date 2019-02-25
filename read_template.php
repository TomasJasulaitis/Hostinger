

<?php

if(isset($_GET['message']) && ($_GET['message'] != null)){
    switch($_GET['message']){
        case 'success':
            echo "<div class='alert alert-success'>Successfully reseted </div>";
            break;
        case 'failure':
            echo "<div class='alert alert-danger'> Failed to reset </div>";
            break;
        default: 
            break;
    }
}


// search form
echo "<form  role='search' action='search.php'>
    <div class='input-group col-md-3 pull-left margin-right-1em mb-5 p-5'>";
        $search_value=isset($search_term) ? "value='{$search_term}'" : "";
        echo "<input type='text' class='form-control' placeholder='Type website url...' name='s' id='srch-term' required {$search_value} />
       <div class='input-group-btn'>
           <button class='btn btn-primary' type='submit'><i class='glyphicon glyphicon-search'></i></button>
       </div>
   </div>
</form>";
echo "<br><br>";


 ?>
<!DOCTYPE html>

<style>
table{
    background-color: lightgrey;
}
</style>
<?php

// display the websites if there are any
if($total_rows>0){

   echo "<div id='create-table' class='col-xs'>
   <table class='table table-hover table-responsive table-bordered table-striped'>
       <tr>
           <th class='col-md-2'>Website</th>
           <th class='col-md-1'>Nofollow</th>
           <th class='col-md-3'>Time checked</th>
           <th class='col-md-2'>Host website</th>
           <th class='col-md-1'>Contains link</th>
           <th class='col-md-1'>Checked</th>
           <th>
            <div class='right-button-margin'>
            <a href='create.php' class='btn btn-primary pull-right'>
                 <span class='glyphicon glyphicon-plus'></span> Create Website
            </a>
            </div>
       </tr>";
 
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
 
            extract($row);
               echo "<tr>
                   <td>{$url}</td>
                   <td>{$nofollow}</td>
                   <td>{$time_checked}</td>
                   <td>{$url_host}</td>
                   <td>{$contains_link}</td>
                   <td>{$checked}</td>
                <td>";
 
                    // read product button
                   echo "<a href='read_single.php?id={$id}' class='btn btn-primary left-margin'>
                       <span class='glyphicon glyphicon-list'></span> Read
                   </a>";
 
                    // delete product button
                    echo "<a delete-id='{$id}' class='btn btn-danger delete-object'>
                        <span class='glyphicon glyphicon-remove'></span> Delete
                    </a>
                </td>
            </tr>
        </div>";
        }
 
    echo "</table>";



    echo "<div class='right-button-margin'>
            <a href='update_fields.php' class='btn btn-primary pull-left'>
                 <span class='glyphicon glyphicon-plus'></span> Force update all fields
            </a>
            </div>";
        echo "<div class='right-button-margin'>
            <a href='reset_fields.php' class='btn btn-primary pull-middle'>
                 <span class='glyphicon glyphicon-plus'></span> Reset all checked fields
            </a>
            <a href='mailer.php' class='btn btn-primary pull-right'>
                 <span class='glyphicon glyphicon-plus'></span> Get info about websites
            </a>
            </div>";
    // paging buttons
    include_once 'paging.php';
}
 
// tell the user there are no products
else{
    echo "<div class='right-button-margin'>
            <a href='create.php' class='btn btn-primary pull-right'>
                 <span class='glyphicon glyphicon-plus'></span> Create Website
            </a>
            </div>";
    echo "<br><br>";
    echo "<div class='alert alert-danger'>No products found.</div>";
}
?>