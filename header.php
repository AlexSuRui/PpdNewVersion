<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>|Idv</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link href="css/global.css" rel="stylesheet" type="text/css">
    <link href="css/site.css" rel="stylesheet" type="text/css">
    <link href="css/jquery-ui-1.9.1.custom.css" rel="stylesheet" type="text/css">
    <!-- Jquery file upload -->
    <link rel="stylesheet" href="css/jquery.imagetag.css">
    <!-- Popup Core File -->
    <link rel="stylesheet" href="css/magnific-popup.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->
    <script language="javascript" >

        function get_school(categorie){
            local=$("#categorie").val();//取得地区名称
                        $("#sub-category").empty();//清空学校名称
                        $("#sub-category").append("<option selected=\"selected\">正在读取 "+local+" 地区学校列表，请稍侯……</option>");
            $.ajax({           
                               type:'post',
                               url:'get_SousCat.php',
                               data:{
                                    get_option:categorie
                               },
                               
                               dataType:'text',
                               success:function(schools)
                        {
                    $("#sub-category").empty();
                      $("#sub-category").append("<option selected=\"selected\">请选择 "+local+" 地区院校</option>");
                    $("#sub-category").append(schools);
                        }
            });
        }
    </script>
  </head>

 <div class="wrapper">
    <div class="header_1">
        <div id="logo">
        <a href="index.php"></a>
        </div>
        <div class="top-box">
        <a href=""><img src="" border="0" style="display: none !important;"></a>        </div>
        <div class="clear"></div> 
    </div>
    <div class="header_2 corner-all">
        <ul>
               <li><a href="index.php">Home</a></li>
                            <?php if(isset($me)) {?>
                    <li><a href="profil.php" class="current" id="profil">Profil</a></li>
                    <li><a href="demandes.php" id="tache">Tasks</a></li>
                            <?php } ?>
                    <form class="form-horizontal" role="form" action="profil.php" method="post">        
                            <button class="btn btn-success " type="submit"  name="deconnexion" style="float: right; margin-right: 10px;margin-top: 2px;">Log out</button>    
                    </form>
                        </ul>
        <div class="clear"></div>
    </div>
 </div>
