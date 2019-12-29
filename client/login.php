<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
      <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<title>Radiologi Bethesda</title>
<body>
    <div class="container">
        <div class="row">
			<div class="col-md-5 mx-auto">
			<div id="first">
				<div class="myform form ">
					 <div class="logo mb-3">
						 <div class="col-md-12 text-center">
							<h1>Login</h1>
						 </div>
					</div>
               <form>
                  <div class="form-group">
                     <label for="exampleInputEmail1">Username</label>
                     <input type="text" name="username"  class="form-control" id="username" aria-describedby="emailHelp" placeholder="Enter email">
                  </div>
                  <div class="form-group">
                     <label for="exampleInputEmail1">Password</label>
                     <input type="password" name="password" id="password"  class="form-control" aria-describedby="emailHelp" placeholder="Enter Password">
                  </div>
                  <div class="col-md-12 text-center ">
                     <a href="#" class=" btn btn-block mybtn btn-primary tx-tfm" onclick="login();">Login</a>
                  </div>
               </form>
				</div>
			</div>
			</div>
		</div>
      </div>   
</body>
<script src="../plugins/jquery/sweetalert2.all.min.js"></script>
<script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
   function login(){
      url = "http://localhost/bethesda/api/";
            const usernm = username.value;
            const pass = password.value;
            if(!usernm){
              Swal.fire(
                'Pesan',
                'Kolom Email Tidak Boleh Kosong',
                'warning'
              )
              return false;
            }else if(!pass){
              Swal.fire(
                'Pesan',
                'Kolom Password Tidak Boleh Kosong',
                'warning'
              )
              return false;
            }
            $.ajax({
              url: url+"login",
              type: "POST",
              data: {username:usernm, password:pass},
              success:function(response){
                const data = response;
                if(data.status === true){
                  localStorage.setItem('token',data.token);
                  localStorage.setItem('fullnm',data.fullnm);
                  window.location = "http://localhost/bethesda/client";
                }else{
                  Swal.fire(
                  'Pesan',
                  data.data,
                  'warning'
                )
                return false;
                }
              },
              error:function(jqXHR, textStatus, errorThrown){
                console.log(textStatus, errorThrown);
              }
            });
        }
</script>