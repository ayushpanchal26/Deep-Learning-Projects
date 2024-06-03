<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
 <?php require_once('inc/header.php') ?>
<body class="hold-transition ">
  <script>
    start_loader()
  </script>
  <style>
    html, body{
      height:calc(100%) !important;
      width:calc(100%) !important;
    }
    body{
      background-image: url("<?php echo validate_image($_settings->info('cover')) ?>");
      background-size:cover;
      background-repeat:no-repeat;
    }
    .login-title{
      text-shadow: 2px 2px black
    }
    #login{
        direction:rtl
    }
    #login * {
        direction:ltr
    }
  </style>
  <?php if(isMobileDevice()): ?>
    <style>
      #login{
        flex-direction:column !important
      }
      #login .col-7,#login .col-5{
        width: 100% !important;
        max-width:unset !important
      }
    </style>
  <?php endif; ?>
  <div class="h-100 d-flex align-items-center w-100" id="login">
    <div class="col-7 h-100 d-flex align-items-center justify-content-center">
      <div class="w-100">
        <h1 class="text-center py-5 login-title"><b><?php echo $_settings->info('name') ?> - Admin</b></h1>
        <center><img src="<?= validate_image($_settings->info('logo')) ?>" alt=""></center>
      </div>
      
    </div>
    <div class="col-5 h-100 bg-gradient">
      <div class="d-flex w-100 h-100 justify-content-center align-items-center">
        <div class="card col-md-4 col-lg-8 card-outline card-primary">
          <div class="card-header">
            <h4 class="text-purle text-center"><b>Create Account</b></h4>
          </div>
          <div class="card-body">
            <form id="register-frm" action="" method="post">
                <input type="hidden" name="id">
                <input type="hidden" name="type" value="2">
              <div class="mb-3">
                <input type="text" class="form-control" autofocus name="firstname" placeholder="Firstname" required>
              </div>
              <div class="mb-3">
                <input type="text" class="form-control" name="middlename" placeholder="Middlename (optional)">
              </div>
              <div class="mb-3">
                <input type="text" class="form-control" name="lastname" placeholder="Lastname" required>
              </div>
              <div class="input-group mb-3">
                <input type="text" class="form-control" name="username" placeholder="Username" required>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input type="password" class="form-control" id="cpassword" placeholder="Confirm Password" required>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                </div>
                <!-- /.col -->
              </div>
              <div class="row">
                <div class="col-md-12 text-center">
                  <a href="./login.php">Already have an Account</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<script>
  $(document).ready(function(){
    end_loader();

    $('#register-frm').submit(function(e){
            e.preventDefault();
            var _this = $(this)
            $('.pop-msg').remove()
            $('#password,#cpassword').removeClass("is-invalid")
            var el = $('<div>')
                el.addClass("pop-msg alert")
                el.hide()
            if($('#password').val() != $('#cpassword').val()){
                el.addClass("my-1 alert-danger")
                el.text("Password does not match")
                $('#cpassword').parent().after(el)
                el.show('slow')
                return false;
            }
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Users.php?f=save",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
                success:function(resp){
                    if(resp == 1){
                        alert("Your Account was successfully created. Wait till the management verifies your account. Thank you!");
                        location.href = './';
                    }else if(resp == 3){
                        el.addClass("alert-danger")
                        el.text("Username already exists.")
                        _this.prepend(el)
                    }else{
                        el.addClass("alert-danger")
                        el.text("An error occurred due to unknown reason.")
                        _this.prepend(el)
                    }
                    el.show('slow')
                    end_loader();
                    $('html, body').animate({scrollTop:0},'fast')
                }
            })
        })
  })
</script>
</body>
</html>