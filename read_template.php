<?php

// search form
echo "<form role='search' action='search.php'>";
    echo "<div class='input-group col-md-3 pull-left margin-right-1em'>";
        $search_value=isset($search_term) ? "value='{$search_term}'" : "";
        echo "<input type='text' class='form-control' placeholder='Type website url...' name='s' id='srch-term' required {$search_value} />";
        echo "<div class='input-group-btn'>";
            echo "<button class='btn btn-primary' type='submit'><i class='glyphicon glyphicon-search'></i></button>";
        echo "</div>";
    echo "</div>";
echo "</form>";
 

echo "<div class='right-button-margin'>";
    echo "<a href='create.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-plus'></span> Create Website";
    echo "</a>";
echo "</div>";

// display the products if there are any
if($total_rows>0){
 
    echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th>Url</th>";
            echo "<th>No follow</th>";
            echo "<th>Time checked</th>";
            echo "<th>Url host</th>";
            echo "<th>Contains link</th>";
             echo "<th>Checked</th>";
        echo "</tr>";
 
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
 
            extract($row);
            echo "<tr>";
                echo "<td>{$url}</td>";
                echo "<td>{$nofollow}</td>";
                echo "<td>{$time_checked}</td>";
                echo "<td>{$url_host}</td>";
                echo "<td>{$contains_link}</td>";
                 echo "<td>{$checked}</td>";
 
             echo "<td>";
 
                    // read product button
                    echo "<a href='read_single.php?id={$id}' class='btn btn-primary left-margin'>";
                        echo "<span class='glyphicon glyphicon-list'></span> Read";
                    echo "</a>";

                       // read product button
                    echo "<a href='update.php' class='btn btn-primary left-margin'>";
                        echo "<span class='glyphicon glyphicon-list'></span> Update";
                    echo "</a>";

                    echo "<a href='reset_all.php' class='btn btn-primary left-margin'>";
                        echo "<span class='glyphicon glyphicon-list'></span> Reset";
                    echo "</a>";
 
 
                    // delete product button
                    echo "<a delete-id='{$id}' class='btn btn-danger delete-object'>";
                        echo "<span class='glyphicon glyphicon-remove'></span> Delete";
                    echo "</a>";
 
                echo "</td>";
 
            echo "</tr>";
 
        }
 
    echo "</table>";
 
    // paging buttons
    include_once 'paging.php';
}
 
// tell the user there are no products
else{
    echo "<div> </div>";
    echo "<div class='alert alert-danger'>No products found.</div>";
}
?>