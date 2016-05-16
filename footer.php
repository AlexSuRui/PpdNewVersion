   <div class="wrapper"> 
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.0 beta
        </div>
        <strong>Copyright &copy; 2016-2017 </strong> All rights reserved.
      </footer>
  </div>
    <!-- jQuery 2.1.4 -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="js/bootstrap.min.js"></script>
    <!-- BlowUp -->
    <script src="js/blowup.js"></script>
    <!-- File upload -->
    <script src="js/jquery-image-tag.js"></script>
    <!-- PopUp -->
    <script src="js/jquery.magnific-popup.min.js"></script>
<!--     <script src="js/jquery.ui.widget.js"></script>
    <script src="js/jquery.iframe-transport.js"></script>
    <script src="js/jquery.fileupload.js"></script> -->
     <script>
       $(document).ready(function () {
        $("#imgAnnotation").blowup()
    })
    </script>
    <script type="text/javascript">
       $(document).ready(function(){
        $("#imgAnnotation").magnific-popup({type:'image'});
       });
    </script>
    <script language="javascript" >

        function get_CousCat(categorie){
                        $("#sub-category").empty();
            $.ajax({           
                               type:'post',
                               url:'get_SousCat.php',
                               data:{
                                    get_option:categorie
                               },
                               
                               dataType:'text',
                               success:function(response)
                        {
                    $("#sub-category").empty();
                    $("#sub-category").append(response);
                        }
            });
        }
    </script>
  </body>
</html>