<?php include 'classes.php';
$object = new Tableau;
// Going trough the array
foreach ($object as $index => $value){
    echo 'The object contains '. $value .' at the index '. $index .'<br>';
}
// Seek specific value in array
$data = $object->seek(3);
echo $data.'<br>';
// Count the number of entries in the array
echo $object->count().'<br>';
?>
