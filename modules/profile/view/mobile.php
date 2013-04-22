<script type="text/javascript">
		$( document ).on( "pageinit", ".pages", function() {
			$( "#autocomplete" ).on( "listviewbeforefilter", function ( e, data ) {
				var $ul = $( this ),
					$input = $( data.input ),
					value = $input.val(),
					html = "";
				$ul.html( "" );
				if ( value && value.length > 0 ) {
					//$ul.html( "<li><div class='ui-loader'><span class='ui-icon ui-icon-loading'></span></div></li>" );
					//$ul.listview( "refresh" );
					$.ajax({
						url: "ajax.php?module=registergym",
						dataType: "jsonp",
						crossDomain: true,
						data: {
							q: $input.val()
						}
					})
.then( function ( response ) {
  $.each( response, function ( i, val ) {
    html += '<li class="gym" id="' + val.AffiliateId + '">' + val.GymName + '</li>';
  });
  $ul.html( html );
  $ul.listview( "refresh" );
  $ul.trigger( "updatelayout");
  $('.gym').click(function(){
    var id = $(this).attr('id');
    $('#gym').val(id);
  $input.val($('#'+id+'').html());
  $ul.html('');
  $ul.listview( "refresh" );
  $ul.trigger( "updatelayout");    
  });
});
				}
			});
		});
                
function getSystem(val)
{
    var thisheight = document.getElementById("height").value;
    var thisweight = document.getElementById("weight").value;
    
    if(val == 'Metric'){
        var newheight = thisheight * 2.54;
        var newweight = thisweight * 0.45;
        document.getElementById("heightlabel").innerHTML = 'Height(cm)';
        document.getElementById("height").value = newheight.toFixed(2);
        document.getElementById("weightlabel").innerHTML = 'Weight(kg)';
        document.getElementById("weight").value = newweight.toFixed(2);
    }
    else if(val == 'Imperial'){
        var newheight = thisheight * 0.39;
        var newweight = thisweight * 2.20;
        document.getElementById("heightlabel").innerHTML = 'Height(inches)';
        document.getElementById("height").value = newheight.toFixed(2);
        document.getElementById("weightlabel").innerHTML = 'Weight(lbs)';
        document.getElementById("weight").value = newweight.toFixed(2);     
    }
}

function profilesubmit()
{
    $.getJSON('ajax.php?module=profile&action=validateform', $("#profileform").serialize(),messagedisplay);
}

function messagedisplay(message)
{
    if(message == 'Success'){
        window.location = 'index.php?module=memberhome&message=1';
    }else{
        alert(message);
        $.getJSON('ajax.php?module=profile', $("#profileform").serialize(),display);
    }
}

function display(data)
{
        $('#AjaxOutput').html(data);
        $('#listview').listview();
        $('#listview').listview('refresh');
        $('.controlbutton').button();
        $('.controlbutton').button('refresh');
        $('.buttongroup').button();
        $('.buttongroup').button('refresh'); 
        $('.radioinput').checkboxradio();
        $('.radioinput').checkboxradio('refresh');
        $('.textinput').textinput();
        $('#AjaxLoading').html('');
}
</script>

<br/>

<div id="AjaxOutput">
    <?php echo $Display->Output();?>
</div>

