<?php echo $this->extend('layouts/login');?>

<?php echo $this->section('content');?>


<section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">
              <div class="card-header">
                <h4>Login</h4>
              </div>
              <div class="card-body">
                <!-- <form method="POST" action="<?php //echo base_url('administrator/login/auth'); ?>" class="needs-validation" novalidate=""> -->
                <form onsubmit="loginHandler(event)">
                  <div class="alert alert-danger d-none">
                    Username / Password Salah
                  </div>
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" type="text" class="form-control" name="username"  tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Please fill in your username
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                      <div class="float-right">
                        <a href="" class="text-small">
                          Forgot Password?
                        </a>
                      </div>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                      please fill in your password
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block btnlogin" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>

              </div>
            </div>
            <div class="mt-5 text-muted text-center">
              Sitaspen powered by <a href="#">GHA</a>
            </div>
          </div>
        </div>
      </div>
    </section>
<?php echo $this->endsection();?>

<?php echo $this->section('jslibraries')?>
    <script type="text/javascript">
        const loginHandler = (event)=>{
          console.log('2134');
          event.preventDefault();
          let formData = new FormData();
          formData.append('username',$('#username').val());
          formData.append('password',$('#password').val());
          axios.post(`<?php echo base_url();?>/api/auth/login`, formData).then(res=>{
            if(res.data.status !== 201){
              $('.alert-danger').removeClass('d-none');
              return;
            }
            location.href = `<?php echo base_url('/dashboard');?>`;
          })
        }
    </script>
<?php echo $this->endSection();?>
