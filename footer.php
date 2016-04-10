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
<!--     <script src="js/jquery.ui.widget.js"></script>
    <script src="js/jquery.iframe-transport.js"></script>
    <script src="js/jquery.fileupload.js"></script> -->
     <script>
       $(document).ready(function () {
        $("#imgAnnotation").blowup()
    })
    </script>
    <script>
      $(function(){
        $('#imgAnnotation').imageTag();
        
        $('#imgAnnotation').imageTag({tagForm: $("#form11"), labelProperty:'title'});
      })
    </script>
<!--     <script type="text/javascript">
        $(function () {
        $('#image').fileupload({
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('<p/>').text(file.name).appendTo(document.body);
                });
            }
        });
    });
    </script> -->
<!-- 	<script>
      $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
    </script> -->
  </body>
</html>