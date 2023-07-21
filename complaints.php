<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
//code for registration
if (isset($_POST['submit'])) {
    $roomno = $_POST['room'];
    $regno = $_POST['regno'];
    // $fname = $_POST['fname'];
    // $mname = $_POST['mname'];
    // $lname = $_POST['lname'];
    // $gender = $_POST['gender'];
    $contactno = $_POST['contact'];
    // $emailid = $_POST['email'];
    $title=$_POST['title'];
    $description=$_POST['description'];
    $query = "insert into complaints(roomno,regno,contactno,title,desciption) values(?,?,?,?,?)";
    $stmt = $mysqli->prepare($query);
    print($roomno+ $regno+ $contactno+$title+$description);
    $rc = $stmt->bind_param('iiiss', $roomno, $regno, $contactno,$title,$description);
    $stmt->execute();
    echo "<script>alert('Complaint Raised Succssfully');</script>";
}
?>

<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">
    <title>Student Hostel Complaints</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">>
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
<script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
<script type="text/javascript" src="js/validation.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>

</head>
<body>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/sidebar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                    
                        <h2 class="page-title">Complaints </h2>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Fill all Info</div>
                                    <div class="panel-body">
                                        <form method="post" action="" class="form-horizontal">
                            <?php
                            $uid = $_SESSION['login'];
                            $stmt = $mysqli->prepare("SELECT emailid FROM registration WHERE emailid=? ");
                            $stmt->bind_param('s', $uid);
                            $stmt->execute();
                            $stmt->bind_result($email);
                            $rs = $stmt->fetch();
                            $stmt->close();
                            if ($rs) { ?>
                <?php } else {
                                echo "";
                            }
                            ?>            
<!-- <div class="form-group">
<label class="col-sm-4 control-label"><h4 style="color: green" align="left">Room Related info </h4> </label>
</div> -->

<div class="form-group">
<label class="col-sm-2 control-label">Room no. </label>
<div class="col-sm-8">
<select name="room" id="room"class="form-control"  onChange="getSeater(this.value);" onBlur="checkAvailability()" required> 
<option value="">Select Room</option>
<?php $query = "SELECT * FROM rooms";
$stmt2 = $mysqli->prepare($query);
$stmt2->execute();
$res = $stmt2->get_result();
while ($row = $res->fetch_object()) {
    ?>
    <option value="<?php echo $row->room_no; ?>"> <?php echo $row->room_no; ?></option>
<?php } ?>
</select> 
<span id="room-availability-status" style="font-size:12px;"></span>

</div>
</div>



<div class="form-group">
<label class="col-sm-2 control-label"><h4 style="color: green" align="left">Personal info </h4> </label>
</div>

<?php
$aid = $_SESSION['id'];
$ret = "select * from userregistration where id=?";
$stmt = $mysqli->prepare($ret);
$stmt->bind_param('i', $aid);
$stmt->execute(); //ok
$res = $stmt->get_result();
//$cnt=1;
while ($row = $res->fetch_object()) {
    ?>

    <div class="form-group">
    <label class="col-sm-2 control-label">Registration No : </label>
    <div class="col-sm-8">
    <input type="text" name="regno" id="regno"  class="form-control" value="<?php echo $row->regNo; ?>" readonly >
    </div>
    </div>


    <!-- <div class="form-group">
    <label class="col-sm-2 control-label">First Name : </label>
    <div class="col-sm-8">
    <input type="text" name="fname" id="fname"  class="form-control" value="<?php echo $row->firstName; ?>" readonly>
    </div>
    </div>

    <div class="form-group">
    <label class="col-sm-2 control-label">Middle Name : </label>
    <div class="col-sm-8">
    <input type="text" name="mname" id="mname"  class="form-control" value="<?php echo $row->middleName; ?>"  readonly>
    </div>
    </div> -->

    <!-- <div class="form-group">
    <label class="col-sm-2 control-label">Last Name : </label>
    <div class="col-sm-8">
    <input type="text" name="lname" id="lname"  class="form-control" value="<?php echo $row->lastName; ?>" readonly>
    </div>
    </div>

    <div class="form-group">
    <label class="col-sm-2 control-label">Gender : </label>
    <div class="col-sm-8">
    <input type="text" name="gender" value="<?php echo $row->gender; ?>" class="form-control" readonly>
    </div>
    </div> -->

    <div class="form-group">
    <label class="col-sm-2 control-label">Contact No : </label>
    <div class="col-sm-8">
    <input type="text" name="contact" id="contact" value="<?php echo $row->contactNo; ?>"  class="form-control" readonly>
    </div>
    </div>


    <!-- <div class="form-group">
    <label class="col-sm-2 control-label">Email id : </label>
    <div class="col-sm-8">
    <input type="email" name="email" id="email"  class="form-control" value="<?php echo $row->email; ?>"  readonly>
    </div>
    </div> -->
<?php } ?>
<div class="form-group">
<label class="col-sm-3 control-label"><h4 style="color: green" align="left">Complaint Info </h4> </label>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Title : </label>
<div class="col-sm-8">
<input type="text" name="title" id="title"  class="form-control" required="required">
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Description : </label>
<div class="col-sm-8">
<textarea  rows="5" name="description"  id="description" class="form-control" required="required"></textarea>
</div>
</div>

<div class="col-sm-6 col-sm-offset-4">
<button class="btn btn-default" type="submit">Cancel</button>
<input type="submit" name="submit" Value="Submit" class="btn btn-primary">
</div>
</form>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            </div>
                        </div>
                    </div>
                </div> 	
            </div>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>
</body>
<script type="text/javascript">
    $(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){
                $('#paddress').val( $('#address').val() );
                $('#pcity').val( $('#city').val() );
                $('#pstate').val( $('#state').val() );
                $('#ppincode').val( $('#pincode').val() );
            } 
            
        });
    });
</script>
    <script>
function checkAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'roomno='+$("#room").val(),
type: "POST",
success:function(data){
$("#room-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>


<script type="text/javascript">

$(document).ready(function() {
    $('#duration').keyup(function(){
        var fetch_dbid = $(this).val();
        $.ajax({
        type:'POST',
        url :"ins-amt.php?action=userid",
        data :{userinfo:fetch_dbid},
        success:function(data){
        $('.result').val(data);
        }
        });
        

})});
</script>

</html>