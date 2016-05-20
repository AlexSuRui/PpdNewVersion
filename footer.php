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
<!--      <script>
       $(document).ready(function () {
        $("#imgAnnotation").blowup()
    })
    </script> -->
<!--     <script type="text/javascript">
       $(document).ready(function(){
        $("#imgAnnotation").magnific-popup({type:'image'});
       });
    </script> -->
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
    <script>
      $(document).ready(function(){
        var counter = 0;
        var mouseX = 0;
        var mouseY = 0;
        
        $("#imgtag img").click(function(e) { // make sure the image is click
          var imgtag = $(this).parent(); // get the div to append the tagging list
          mouseX = ( e.pageX - $(imgtag).offset().left ) - 50; // x and y axis
          mouseY = ( e.pageY - $(imgtag).offset().top ) - 50;
          $( '#tagit' ).remove( ); // remove any tagit div first
          $( imgtag ).append( '<div id="tagit"><div class="box"></div><div class="name"><div class="text">Type any name or tag</div><input type="text" name="txtname" id="tagname" /><input type="button" name="btnsave" value="Save" id="btnsave" /><input type="button" name="btncancel" value="Cancel" id="btncancel" /><div id="radio"><input type="radio" name="confiance" value="100" checked>Confident  </input><input type="radio" name="confiance" value="80">Average confident</input><input type="radio" name="confiance" value="60">Hesitant</input></div></div></div>' );
          $( '#tagit' ).css({ top:mouseY, left:mouseX });
          
          $('#tagname').focus();
        });
        
      // Save button click - save tags
        $( document ).on( 'click',  '#tagit #btnsave', function(){
          name = $('#tagname').val();
        var usr = <?php echo $me->UID?>;
        var img = $('#imgtag').find( 'img' );
        var confiance = $('#radio input[name="confiance"]:checked').val();
        var id = $( img ).attr( 'id' );
          $.ajax({
            type: "POST", 
            url: "savetag.php", 
            data: "pic_id=" + id + "&name=" + name + "&confiance=" + confiance + "&usr=" + usr + "&pic_x=" + mouseX + "&pic_y=" + mouseY + "&type=insert",
            cache: true, 
            success: function(data){
              viewtag( id,usr);
              $('#tagit').fadeOut();
            }
          });
          
        });
        
      // Cancel the tag box.
        $( document ).on( 'click', '#tagit #btncancel', function() {
          $('#tagit').fadeOut();
        });
        
      // mouseover the taglist 
      $('#taglist').on( 'mouseover', 'li', function( ) {
          id = $(this).attr("id");
          $('#view_' + id).css({ opacity: 1.0 });
        }).on( 'mouseout', 'li', function( ) {
            $('#view_' + id).css({ opacity: 0.0 });
        });
      
      // mouseover the tagboxes that is already there but opacity is 0.
      $( '#tagbox' ).on( 'mouseover', '.tagview', function( ) {
        var pos = $( this ).position();
        $(this).css({ opacity: 1.0 }); // div appears when opacity is set to 1.
      }).on( 'mouseout', '.tagview', function( ) {
        $(this).css({ opacity: 0.0 }); // hide the div by setting opacity to 0.
      });
        
      // Remove tags.
        $( '#taglist' ).on('click', '.remove', function() {
          id = $(this).parent().attr("id");
          // Remove the tag
        $.ajax({
            type: "POST", 
            url: "savetag.php", 
            data: "tag_id=" + id + "&type=remove",
            success: function(data) {
          var img = $('#imgtag').find( 'img' );
          var id = $( img ).attr( 'id' );
          //get tags if present
          viewtag( id, usr );
            }
          });
        });
      
      // load the tags for the image when page loads.
        var usr = <?php echo $me->UID?>;
        var img = $('#imgtag').find( 'img' );
        var id = $( img ).attr( 'id' );
      
      viewtag( id,usr ); // view all tags available on page load
        
        function viewtag( pic_id,usr_id )
        {
          // get the tag list with action remove and tag boxes and place it on the image.
        $.post( "taglist.php" ,  "pic_id=" + pic_id + "&usr_id=" + usr_id, function( data ) {
         $('#tagbox').html(data.boxes);
        }, "json");
      
        }
        
      });

    </script>
  </body>
</html>