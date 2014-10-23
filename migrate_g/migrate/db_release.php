<?php
function clearStoredResults($mysqli_link){
    while($mysqli_link->next_result()){
      if($l_result = $mysqli_link->store_result()){
              $l_result->free();
      }
    }
}
?>