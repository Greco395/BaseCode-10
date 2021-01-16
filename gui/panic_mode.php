<?php 
class PANIC{
    public $internal_bs_version = "10-0-1";
    public function __construct(){
        session_name("secure");
        session_start();
    }
    public function check_main_status(){
        exec("php -l ../main.php", $output_check_main, $return_check_main);
        if ($return_check_main === 0) {
            return true;
        }else{
            return false;
        }
    }
    public function check_logged(){
        global $_SESSION;
        if(isset($_SESSION['logged']) and $_SESSION['logged']){
            if(isset($_SESSION['username'])){
                return true;
            }else{
                return false;
                die();
            }
        }else{
            return false;
            die();
        }
        return false;
        die();
    }
    public function getSubDirectories($path){
        $dirs = array();
        $dir = dir($path);
        while (false !== ($entry = $dir->read())) {
            if ($entry != '.' && $entry != '..') {
                if (is_dir($path . '/' .$entry)) {
                        $dirs[] = $entry; 
                }
            }
        }
        return $dirs;
    }
    public function restore_file($file_to_restore, $backup_file){
        if(!$this->check_logged()){ return die("NOT LOGGED"); }
        $bakup = file_get_contents(__DIR__."/".$backup_file);
        $f=fopen($file_to_restore,'w');
        fwrite($f,$bakup);
        fclose($f);
    }
    public function delete_files($target) {
        if(is_dir($target)){
            $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned
    
            foreach( $files as $file ){
                $this->delete_files( $file );      
            }
    
            rmdir( $target );
        } elseif(is_file($target)) {
            unlink( $target );  
        }
    }
    public function delete_ALL($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
              if ($object != "." && $object != "..") {
                if (filetype($dir."/".$object) == "dir") 
                    delete_ALL($dir."/".$object); 
                else unlink   ($dir."/".$object);
              }
            }
            reset($objects);
            rmdir($dir);
          }
    }
    public function boolToString($value){
        if($value){
            return "true";
        }else{
            return "false";
        }
    }
    public function redirect($url){
        if (!headers_sent()){
            header('Location: '.$url);
            exit;
          }else{
            echo '<script type="text/javascript">';
            echo 'window.location.href="'.$url.'";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
            echo '</noscript>'; exit;
        }
    }
    public function arrayToStringArray($array, $pure=false){
        $pre = "array(";
        $el = "";
        if(is_array($array)){
            foreach($array as $element){
                if(is_array($element)){
                    $this->arrayToStringArray($element);
                }else{
                    $el .= "\"".str_replace('"','\"',$element)."\", ";
                }
            }
            $el = rtrim($el,", ");
            if($pure){
                return $el;
            }else{
                return $pre.$el.")";
            }
        }else{
            return $array;
        }
    }

    public function stringToArrayFake($strings){
        return "array(".$strings.")";
    }
}
$panic_varClass = new PANIC;

$msg="Hello ;)";
if(isset($_POST) && !empty($_POST['case']) && !empty($_GET['bs_show_brainHTML'])){
    if($_POST['case'] and $_POST['case'] == "reset_ALL"){
        if(!$panic_varClass->check_logged()){ return die("NOT LOGGED"); }
        $rq = $panic_varClass->login($_SESSION['username'], $_POST['password']);
        if($rq){
            $panic_varClass->restore_file("../main.php", "backups/backup_main.php");
            $panic_varClass->restore_file("../settings.php", "backups/backup_settings.php");
            $panic_varClass->restore_file("./brain.php", "backups/backup_brain.php");
            $type = "success";
            $msg = "ALL FILE ARE RESTORED!";
        }else{
            $type="danger";
            $msg = "INCORRECT PASSWORD";
        }
        
    }elseif($_POST['case'] and $_POST['case'] == "reset_MAIN"){
        if(!$panic_varClass->check_logged()){ return die("NOT LOGGED"); }
        $rq = $panic_varClass->login($_SESSION['username'], $_POST['password']);
        if($rq){
            $panic_varClass->restore_file("../main.php", "backups/backup_main.php");
            $type = "success";
            $msg = "MAIN FILE RESTORED!";
        }else{
            $type="danger";
            $msg = "INCORRECT PASSWORD";
        }
        
    }elseif($_POST['case'] and $_POST['case'] == "reset_SETTINGS"){
        if(!$panic_varClass->check_logged()){ return die("NOT LOGGED"); }
        $rq = $panic_varClass->login($_SESSION['username'], $_POST['password']);
        if($rq){
            $panic_varClass->restore_file("../settings.php", "backups/backup_settings.php");
            $type = "success";
            $msg = "SETTINGS FILE RESTORED!";
        }else{
            $type="danger";
            $msg = "INCORRECT PASSWORD";
        }
        
    }elseif($_POST['case'] and $_POST['case'] == "reset_BRAIN"){
        if(!$panic_varClass->check_logged()){ return die("NOT LOGGED"); }
        $rq = $panic_varClass->login($_SESSION['username'], $_POST['password']);
        if($rq){
            $panic_varClass->restore_file("./brain.php", "backups/backup_brain.php");
            $type = "success";
            $msg = "BRAIN FILE RESTORED!";
        }else{
            $type="danger";
            $msg = "INCORRECT PASSWORD";
        }
        
    }?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>BaseCode</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="./assets/css/components.css">
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-<?php echo $type; ?>">
                    <div class="card-header">
                        <h4>ALERT</h4>
                    </div>
                    <div class="card-body">
                    <br>
                        <code><h3><?php echo $msg; ?></h3></code>
                    </div>
                    <div class="card-footer text-right">
                        <a href="index.php" class="btn btn-block btn-primary">RETURN TO DASHBOARD</a>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="./assets/js/stisla.js"></script>

  <!-- JS Libraies -->
  <script src="http://maps.google.com/maps/api/js?key=AIzaSyB55Np3_WsZwUQ9NS7DP-HnneleZLYZDNw&amp;sensor=true"></script>
  <script src="./node_modules/gmaps/gmaps.min.js"></script>

  <!-- Template JS File -->
  <script src="./assets/js/scripts.js"></script>
  <script src="./assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
  <script src="./assets/js/page/utilities-contact.js"></script>
</body>
</html>
<?php 

}else{
?>


<?php 
$bs_version = "10.0.0"; 
$bs_edition = "BRTE update 2";
if(isset($_GET) && isset($_GET['logout'])){
  if($_GET['logout'] == "now"){
    unset($_SESSION);
    session_destroy();
  }
}
if(!$panic_varClass->check_logged()){ header("Location: access.php"); die("Not logged, click <a href='access.php'>here</a>."); }
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>PANIC MODE - BaseCode</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="./node_modules/jqvmap/dist/jqvmap.min.css">
  <link rel="stylesheet" href="./node_modules/weathericons/css/weather-icons.min.css">
  <link rel="stylesheet" href="./node_modules/weathericons/css/weather-icons-wind.min.css">
  <link rel="stylesheet" href="./node_modules/summernote/dist/summernote-bs4.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="./assets/css/components.css">
</head>

<body class="layout-3">

<div id="app">
    <div class="main-wrapper container">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
      <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="../gui" class="nav-link nav-link-lg btn btn-dark" style="color:red;">EXIT PANIC MODE</a></li>
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <div class="d-sm-none d-lg-inline-block">Hi, Admin</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="?logout=now" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">

          <div class="section-body">
            <div class="invoice">
              <div class="row">
                  <div class="col-lg-12">
                    <div class="invoice-title">
                      <h2>What is this?</h2>
                    </div>
                    <div class="invoice-body">
                      <p>Starting from version 10, 
                      BaseCode has integrated a security system that allows it to detect 
                      if the page you are accessing has critical errors. In this case you tried to access 
                      the page: 
                      <code><?php echo urldecode($_GET['from']); ?></code> 
                      which is dead due to syntax errors. 
                      In these cases BaseCode allows you to reset some pivotal pages of the script, 
                      however, it is not possible to reset everything, 
                      if by resetting these pages you continue to return to PANIC MODE we advise you to delete 
                      the /gui/ folder and replace it with the version downloadable from GitHub</p>
                    </div>
                    <a class="btn btn-warning" href="<?php echo urldecode($_GET['from']); ?>">RETURN TO DIED PAGE</a>
                  </div>
                </div>
                <br>
                
            </div>
          </div>


          <div class="section-body">
            <h2 class="section-title">RESET</h2>
            <p class="section-lead">
              Use this section to reset basecode components.
            </p>

            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Reset <code>ALL</code></h4>
                  </div>
                  <div class="card-body">
                    <p class="text-muted">This action is <code>IRREVERSIBLE</code> and will reset <code>ALL files</code>.</p>
                    <div class="buttons">
                      <button class="btn btn-block btn-outline-dark" data-toggle="modal" data-target="#resetALLmodal">RESET BASECODE</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Reset <code>Main File</code></h4>
                  </div>
                  <div class="card-body">
                  <p class="text-muted">This action is <code>IRREVERSIBLE</code> and will reset the "<code>main.php</code>".</p>
                    <div class="buttons">
                      <button class="btn btn-block btn-outline-danger" data-toggle="modal" data-target="#resetMAINmodal">RESET MAIN FILE</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </div>
          
          <div class="row">
          <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Reset <code>Settings</code></h4>
                  </div>
                  <div class="card-body">
                    <p class="text-muted">This action is <code>IRREVERSIBLE</code> and will reset the "<code>settings.php</code>".</p>
                    <div class="buttons">
                    <button class="btn btn-block btn-outline-secondary" data-toggle="modal" data-target="#resetSETTINGSmodal">RESET ALL SETTINGS</button>
                    </div>
                  </div>
                </div>
              </div>
            
            
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Reset <code>Brain</code> File</h4>
                  </div>
                  <div class="card-body">
                    <p class="text-muted">This action is <code>IRREVERSIBLE</code> and will reset the "<code>brain.php</code>".</p>
                    <div class="buttons">
                    <button class="btn btn-block btn-outline-warning" data-toggle="modal" data-target="#resetBRAINmodal">RESET ALL SETTINGS</button>
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

        </section>
      </div>

<!-- MODALS -->
      <div class="modal fade" tabindex="-1" role="dialog" id="updateModal">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">BASECODE UPDATE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Clicking "Update" will download a new version of BaseCode from the basecode server.<br>
                  To perform the update it is essential to use the php <code>eval()</code> function, before updating make sure it is enabled and <code>do not forget to make a backup</code>.<br>
                  The automatic update or any associated risk such as data loss is completely borne by the user.</p>
                <form action="?bs_show_brainHTML=yes" method="POST">

                <br>
                <div class="form-group">
                  <label>Confirm your password to continue</label>
                  <input type="password" class="form-control" name="password" placeholder="Insert your password">
                </div>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <a class="btn btn-secondary" data-dismiss="modal">NO! GO BACK</a>
                  <input type="hidden" name="case" value="update_now" />
                  <button type="submit" class="btn btn-danger">UPDATE NOW</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="resetALLmodal">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">RESET BASECODE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Are you sure to reset all basecode ("main.php", "settings.php", "brain.php") and replace them with backups?</p>
                <form action="?bs_show_brainHTML=yes" method="POST">
                <br>
                <div class="form-group">
                  <label>Confirm your password to continue</label>
                  <input type="password" class="form-control" name="password" placeholder="Insert your password">
                </div>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <a class="btn btn-secondary" data-dismiss="modal">NO! GO BACK</a>
                  <input type="hidden" name="case" value="reset_ALL" />
                  <button type="submit" class="btn btn-danger">YES! RESET ALL</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="resetMAINmodal">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">RESET Main File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Are you sure to reset the main file ("main.php") and replace it with the backup?</p>
                <form action="?bs_show_brainHTML=yes" method="POST">
                <br>
                <div class="form-group">
                  <label>Confirm your password to continue</label>
                  <input type="password" class="form-control" name="password" placeholder="Insert your password">
                </div>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <a class="btn btn-secondary" data-dismiss="modal">NO! GO BACK</a>
                  <input type="hidden" name="case" value="reset_MAIN" />
                  <button type="submit" class="btn btn-danger">YES! RESET MAIN FILE</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="resetSETTINGSmodal">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">RESET Settings File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Are you sure to reset the settings file ("settings.php") and replace it with the backup?</p>
                <form action="?bs_show_brainHTML=yes" method="POST">
                <br>
                <div class="form-group">
                  <label>Confirm your password to continue</label>
                  <input type="password" class="form-control" name="password" placeholder="Insert your password">
                </div>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <a class="btn btn-secondary" data-dismiss="modal">NO! GO BACK</a>
                  <input type="hidden" name="case" value="reset_SETTINGS" />
                  <button type="submit" class="btn btn-danger">YES! RESET SETTINGS</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="resetBRAINmodal">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">RESET Brain File (gui)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Are you sure to reset the brain file ("brain.php") and replace it with the backup?</p>
                <form action="brain.php?bs_show_brainHTML=yes" method="POST">
                <br>
                <div class="form-group">
                  <label>Confirm your password to continue</label>
                  <input type="password" class="form-control" name="password" placeholder="Insert your password">
                </div>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <a class="btn btn-secondary" data-dismiss="modal">NO! GO BACK</a>
                  <input type="hidden" name="case" value="reset_BRAIN" />
                  <button type="submit" class="btn btn-danger">YES! RESET SETTINGS</button>
                </form>
              </div>
            </div>
          </div>
        </div>
<!-- END MODALS -->

<footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; <?php echo date("Y",time()); ?> <div class="bullet"></div> Basecode powered by <a href="https://greco395.com" target="_blank">Domenico Greco</a>.
        </div>
        <div class="footer-right">
        Template: <a href="https://github.com/stisla/stisla" target="_blank">stisla</a>
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="./assets/js/stisla.js"></script>

  <!-- JS Libraies -->
  <script src="./node_modules/simpleweather/jquery.simpleWeather.min.js"></script>
  <script src="./node_modules/chart.js/dist/Chart.min.js"></script>
  <script src="./node_modules/jqvmap/dist/jquery.vmap.min.js"></script>
  <script src="./node_modules/jqvmap/dist/maps/jquery.vmap.world.js"></script>
  <script src="./node_modules/summernote/dist/summernote-bs4.js"></script>
  <script src="./node_modules/chocolat/dist/js/jquery.chocolat.min.js"></script>

  <!-- Template JS File -->
  <script src="./assets/js/scripts.js"></script>
  <script src="./assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
  <script src="./assets/js/page/index-0.js"></script>
</body>
</html>
<?php } ?>
