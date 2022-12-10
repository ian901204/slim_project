<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <?php
        include __DIR__."/common_component/head.php";
    ?>
</head>
<body class="bg-dark">

    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="index.html">
                        <img class="align-content" src="images/logo.png" alt="">
                    </a>
                </div>
                <div class="login-form">
                        <div class="form-group">
                            <label>管理員帳戶</label>
                            <input id = "account" class="form-control" placeholder="輸入帳號">
                        </div>
                        <div class="form-group">
                            <label>密碼</label>
                            <input id = "password" type="password" class="form-control" placeholder="輸入密碼">
                        </div>
                        <button onclick = "login()" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        var dataJSON = {};
        function login(){
            dataJSON["account"] = $("#account").val();
            dataJSON["password"] = $("#password").val();
            $.ajax({
                url: $(location).attr('origin') + "/login",
                data: JSON.stringify(dataJSON),
                type: "POST",
                contentType: "application/json;charset=utf-8",
                success: function(returnData){
                    window.localStorage.setItem("token", JSON.parse(JSON.stringify(returnData))["token"]);
                    alert("登入成功！");
                    window.location.href = $(location).attr("origin") + "/order/list";
                },
                error: function(xhr, ajaxOptions, thrownError){
                    if (xhr.statusCode == "400"){
                        alert(xhr.responseText);
                    }else{
                        alert(xhr.responseText);
                        var responseData = $.parseJSON(xhr.responseText);
                        if (responseData["Status"] == "account"){
                            $("#account").addClass("is-invalid");
                            $("#password").removeClass("is-invalid");
                        }else if(responseData["Status"] == "password"){
                            $("#password").addClass("is-invalid");
                            $("#account").removeClass("is-invalid");
                        }
                    }
                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        $('link[src="assets/js/main.js"]').attr('href',$(location).attr('origin') + 'assets/js/main.js');
    </script>
</body>
</html>
