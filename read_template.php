

<?php

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
           <th class='col-md-2'>Url</th>
           <th class='col-md-1'>No follow</th>
           <th class='col-md-3'>Time checked</th>
           <th class='col-md-2'>Url host</th>
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
    // paging buttons
    include_once 'paging.php';
}
 
// tell the user there are no products
else{
    echo "<br><br>";
    echo "<div class='alert alert-danger'>No products found.</div>";
}
?>