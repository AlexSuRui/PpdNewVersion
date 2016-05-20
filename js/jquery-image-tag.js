
  $(document).ready(function(){
    var counter = 0;
    var mouseX = 0;
    var mouseY = 0;
    
    $("#imgtag img").click(function(e) { // make sure the image is click
      var imgtag = $(this).parent(); // get the div to append the tagging list
      mouseX = ( e.pageX - $(imgtag).offset().left ) - 50; // x and y axis
      mouseY = ( e.pageY - $(imgtag).offset().top ) - 50;
      $( '#tagit' ).remove( ); // remove any tagit div first
      $( imgtag ).append( '<div id="tagit"><div class="box"></div><div class="name"><div class="text">Type any name or tag</div><input type="text" name="txtname" id="tagname" /><input type="button" name="btnsave" value="Save" id="btnsave" /><input type="button" name="btncancel" value="Cancel" id="btncancel" /></div></div>' );
      $( '#tagit' ).css({ top:mouseY, left:mouseX });
      
      $('#tagname').focus();
    });
    
	// Save button click - save tags
    $( document ).on( 'click',  '#tagit #btnsave', function(){
      name = $('#tagname').val();
    var usr = <?php echo $me->UID?>;
		var img = $('#imgtag').find( 'img' );
		var id = $( img ).attr( 'id' );
      $.ajax({
        type: "POST", 
        url: "savetag.php", 
        data: "pic_id=" + id + "&name=" + name + "&usr=" + usr + "&pic_x=" + mouseX + "&pic_y=" + mouseY + "&type=insert",
        cache: true, 
        success: function(data){
          viewtag( id );
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
			viewtag( id );
        }
      });
    });
	
	// load the tags for the image when page loads.
    var img = $('#imgtag').find( 'img' );
	var id = $( img ).attr( 'id' );
	
	viewtag( id ); // view all tags available on page load
    
    function viewtag( pic_id )
    {
      // get the tag list with action remove and tag boxes and place it on the image.
	  $.post( "taglist.php" ,  "pic_id=" + pic_id, function( data ) {
	  	$('#taglist ol').html(data.lists);
		 $('#tagbox').html(data.boxes);
	  }, "json");
	
    }
    
    
  });
