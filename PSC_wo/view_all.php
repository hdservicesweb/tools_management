<?php
include('../header.php');
$link = Conectarse();


$sql = "SELECT wo.*,C.name_customer as NC from wo inner join customers C on wo.customer = C.id 
    where (wo.psc_no like '%" . $search . "%'
         OR wo.picking like '%" . $search . "%'
         OR wo.assy_pn like '%" . $search . "%' )   
    and wo.position <= '10' order by wo.priorizetotal desc, wo.psc_no asc";



?>
<!-- script que indica a ajax donde encontrar la informacion que debera cargarse en el cuadro contenido -->
<script src="../ajax.js"></script>
<script>
    var url = "screen_f_data.php";
</script>
<div class="container-fluid" id="contenido">
    <div name="timediv" id="timediv">
        
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <p class="float-right">
                <a href="screen_full" target="_blank" class="btn btn-sm btn-success">No Distractions Mode</a>
            </p>
        </div>
    </div>
</div>
<?php
echo "<hr>";

include('../footer.php');
?>