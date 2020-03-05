<?php
include("../header.php");
$link = Conectarse();

if ((isset($_REQUEST['customer'])) && ($_REQUEST['customer'] != "")) {
    $customer = $_REQUEST['customer'];
} else {
    $customer = "";
}
if (isset($_REQUEST['c_pn'])) {
    $c_pn = $_REQUEST['c_pn'];
} else {
    $c_pn = "";
}
if (isset($_REQUEST['rev'])) {
    $rev = $_REQUEST['rev'];
} else {
    $rev = "";
}
if ((isset($_REQUEST['PSC_PN'])) && ($_REQUEST['PSC_PN'] != "")) {
    $PSC_PN = $_REQUEST['PSC_PN'];
} else {
    $PSC_PN = "";
}
if (isset($_REQUEST['date_psc'])) {
    $date_psc = $_REQUEST['date_psc'];
} else {
    $date_psc = date('m/d/Y');
}
if (isset($_REQUEST['prepared'])) {
    $prepared = $_REQUEST['prepared'];
} else {
    $prepared = "";
}



$pn_tool_concated = "";
$tool_tool_concated = "";
$crip_tool_concated ="";
$y = 0;
if (isset($_REQUEST['tool_tool'])) {
    foreach ($_REQUEST['tool_tool'] as $tool_tool[]) {
        $tool_tool_concated = $tool_tool_concated . strtoupper ($tool_tool[$y]) . ',';
        $y++;
    }
}
$y = 0;
if (isset($_REQUEST['crip_tool'])) {
    foreach ($_REQUEST['crip_tool'] as $crip_tool[]) {
        $crip_tool_concated = $crip_tool_concated . strtoupper ($crip_tool[$y]) . ',';
        $y++;
    }
}
$y = 0;
if (isset($_REQUEST['pn_tool'])) {
    foreach ($_REQUEST['pn_tool'] as $pn_tool[]) {
        $pn_tool_concated = $pn_tool_concated . strtoupper($pn_tool[$y]) . ',';
        $y++; 
    }
    
}
else {
    $y = 1;
    $pn_tool[] = "";
    $tool_tool[] = "";
    $crip_tool[] ="";
   // echo "eNO xist";
}

?>
<script type='text/javascript'>
    $(document).ready(function() {
        var max_fields = 13;
        var wrapper = $(".container1");
        var add_button = $(".add_form_field");

        var x = <?= $y ?>;
        $(add_button).click(function(e) {
            e.preventDefault();
            if (x < max_fields) {
                x++;
                $(wrapper).append(' <div class="row "><div class="col-sm-4"><input type="text" name="pn_tool[' + x + ']" class="form-control form-control-sm" required> </div> <div class="col-sm-4"> <input type="text" name="tool_tool[' + x + ']" class="form-control form-control-sm" required> </div> <div class="col-sm-3"> <input type="text" name="crip_tool[' + x + ']" class="form-control form-control-sm" > </div> <input type="button" class="btn btn-sm btn-danger delete" value=" - "></div><br>'); //add input box
            } else {
                alert('You Reached the limits')
            }
        });

        $(wrapper).on("click", ".delete", function(e) {
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        })
    });
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div id="form_req">
                <div class="card">
                    <div class="card-header">
                        <label for="">Tooling Requirement Form</label>
                    </div>
                    <form action="tool_req.php" method="get">
                        <div class="card-body">
                            <div class="container-fluid form-group">
                                <div class="row">
                                    <div class="col-sm-5">
                                        Customer:
                                        <input type="text" class="form-control form-control-sm" placeholder="Customer" name="customer" value="<?= $customer ?>">
                                    </div>
                                    <div class="col-sm-5">
                                        Customer Part Number:
                                        <input type="text" class="form-control form-control-sm" placeholder="Customer PartNumber" name="c_pn" value="<?= $c_pn ?>">
                                    </div>
                                    <div class="col-sm-2">
                                        Revision Lvl:
                                        <input type="text" class="form-control form-control-sm" placeholder="Revision" name="rev" value="<?= $rev ?>">
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-sm-4">
                                        PSC Part Number:
                                        <input type="text" class="form-control form-control-sm" placeholder="PSC Partnumber" name="PSC_PN" value="<?= $PSC_PN ?>">
                                    </div>
                                    <div class="col-sm-4">
                                        Date:
                                        <input type="text" class="form-control form-control-sm" placeholder="Date" name="date_psc" value="<?= $date_psc ?>">
                                    </div>
                                    <div class="col-sm-4">
                                        Prepared by:
                                        <input type="text" class="form-control form-control-sm" placeholder="Prepared" name="prepared" value="<?= $prepared ?>">
                                    </div>
                                </div><br>
                                <hr><br>
                                <div class="container1">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            PART NUMBER:
                                        </div>
                                        <div class="col-sm-4">
                                            TOOLING NEEDED:
                                        </div>
                                        <div class="col-sm-4">
                                            CRIMP HT/PULL:
                                        </div>
                                    </div>

                                    <?php

                                    for ($i = 0; $i < $y; $i++) {


                                    ?>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input type="text" name="pn_tool[]" class="form-control form-control-sm" value="<?= $pn_tool[$i]; ?>" required>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" name="tool_tool[]" class="form-control form-control-sm" value="<?= $tool_tool[$i]; ?>" required>
                                            </div>
                                            <div class="col-sm-3">

                                                <input type="text" name="crip_tool[]" class="form-control form-control-sm" value="<?= $crip_tool[$i]; ?>">
                                            </div>
                                        </div><br>
                                    <?php
                                    }
                                    ?>


                                </div>
                                <button class="btn btn-sm btn-primary add_form_field pull-right">Add &nbsp;
                                    <span style="font-size:16px; font-weight:bold;">+ </span>
                                </button>
                                <a class="btn btn-sm btn-warning text-white" href="tool_req"> CLEAN</a>
                                <input type="submit" value="Generate >>" class="btn btn-sm btn-success" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div id="format">
        <iframe src="../TCPDF-master/examples/PSC_Tool_requeriment.php?customer=<?= $customer ?>&c_pn=<?= $c_pn ?>&rev=<?= $rev ?>&PSC_PN=<?= $PSC_PN ?>&date_psc=<?= $date_psc ?>&prepared=<?= $prepared ?>&pn_tool=<?= $pn_tool_concated ?>&tool_tool=<?=$tool_tool_concated?>&crip_tool=<?=$crip_tool_concated?>" frameborder="0" width="100%" height="500px"></iframe>
    </div>
</div>
</div>
</div>



<?php
include('../footer.php');
?>