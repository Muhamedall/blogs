<?php
function query(string $query, array $data = []) {
    $con = get_connection();
    $stm = $con->prepare($query);
    $stm->execute($data);
}
?>
