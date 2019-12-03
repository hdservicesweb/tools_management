<?php
include("../header.php");
$link = Conectarse();
$models = null;
$data = null;
$sqlmostused = "SELECT psc_id,manufacturer,model,SUM(used_qty) as newsuma from tools_main_db group by model order by newsuma desc LIMIT 20";
$exexsqlmostused = mysqli_query($link, $sqlmostused) or die("Something wrong with DB please verify.");
while ($row = mysqli_fetch_array($exexsqlmostused)){
$models .= "'".$row['manufacturer']. " - (".$row['model']. ")'," ;
$data .= "'".$row['newsuma']. "'," ;
}

?>
<div class="container-fluid">
    <div class="card">
        <div class="row">
            <div class="card-body">


                <div class="card " style="width: 30%;">
                    <div class="card-header">
                        MOST USED TOOLS
                    </div>
                    <div class="card-body">
                        <canvas id="mostusedtools"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var ctx = document.getElementById('mostusedtools').getContext('2d');
var myBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
    labels: [<?=$models?>],
    datasets: [{
        label: 'Most used tools',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        barPercentage: 0.5,
        barThickness: 4,
        maxBarThickness: 20,
        minBarLength: 0,
        data: [<?=$data?>]
    }]
},
    options: {}
});

    // var ctx = document.getElementById('mostusedtools').getContext('2d');
    // var chart = new Chart(ctx, {
    //     // The type of chart we want to create
    //     type: 'line',

    //     // The data for our dataset
    //     data: {
    //         labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    //         datasets: [{
    //             label: 'My First dataset',
    //             backgroundColor: 'rgb(255, 99, 132)',
    //             borderColor: 'rgb(255, 99, 132)',
    //             data: [0, 10, 5, 2, 20, 30, 45]
    //         }]
    //     },

    //     // Configuration options go here
    //     options: {}
    // });
</script>
<?php
include('../footer.php');
?>