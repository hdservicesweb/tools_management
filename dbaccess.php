<?php 
require 'FileMaker-master/autoloader.php';
require_once ('FileMaker-master/src/FileMaker.php');

 use airmoi\FileMaker\FileMaker;

 $fm = new FileMaker();
$fm = new FileMaker('PSC_Crimp_Test', 'localhost', 'user1', 'user1');


try {
    $command = $fm->newFindCommand('layout_name');
    $records = $command->execute()->getRecords(); 
    
    foreach($records as $record) {
        echo $record->getField('fieldname');
        
    }
} 
catch (FileMakerException $e) {
    echo 'An error occured ' . $e->getMessage() . ' - Code : ' . $e->getCode();
}

// $fm->setProperty('database', 'PSC_Crimp_Test');
// $fm->setProperty('host','localhost');
// $fm->setProperty('username', 'user1');
// $fm->setProperty('password', 'user1');

?>
