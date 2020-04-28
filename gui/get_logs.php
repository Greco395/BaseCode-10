<?php 
$enable_head_security = true; // this variable is essential!!!
$page_title = "Logs - Basecode";
$page_name = "get_logs";
include("head.php");
if(!$class_administrator_bs->check_logged()){ header("Location: access.php"); die("Not logged, click <a href='access.php'>here</a>."); }
?>
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Errors</h1>
          </div>
<?php 
if(isset($_POST) && isset($_POST['logs_case'])){
    if($_POST['logs_case'] == "clearAll"){
        if(unlink("../basecode_error.log")){
            echo '<div class="alert alert-success alert-has-icon">
                    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                    <div class="alert-body">
                    <div class="alert-title">Success</div>
                        Logs deleted!
                    </div>
                </div>';
        }else{
            echo '<div class="alert alert-danger alert-has-icon">
                    <div class="alert-icon"><i class="fas fa-times"></i></div>
                    <div class="alert-body">
                    <div class="alert-title">Error</div>
                        Impossible to delete the logs file. Check permissions!
                    </div>
                </div>';
        }
    }
}
?>

          <div class="card">
            <div class="form-group" style="margin-bottom:0px;padding-bottom:0px;">
                <textarea class="form-control" style="width:100%;min-height:450px;" readonly><?php 
                        if(file_exists("../basecode_error.log")){
                            $lg = file_get_contents("../basecode_error.log");
                            if($lg=="" or $lg == " " or empty($lg)){
                                echo "Your log file is Empty";
                            }else{
                                echo $lg;
                            }
                        }else{
                            echo "Your log file is Empty";
                        }
                    ?></textarea>
            </div>
            <div class="card-footer text-right">
                <form action="" method="POST">
                    <input type="hidden" name="logs_case" value="clearAll" />
                    <button type="submit" class="btn btn-danger">CLEAR LOGS</button>
                </form>
            </div>

          </div>
<?php
  include("footer.php");
?>