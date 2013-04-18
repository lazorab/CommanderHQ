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
               
function gymformsubmit(gym)
{  
    $.ajax({url:'ajax.php?module=registergym&action=formsubmit',data:{AffiliateId:gym},dataType:"html",success:messagedisplay});
}

function messagedisplay(message)
{
    alert(message);
    if(message == 'Successfully Updated!'){
        window.location = 'index.php?module=memberhome&message=2';
    }
}

function display(data)
{
    $('#AjaxOutput').html(data);
    $('.select').selectmenu();
    $('.select').selectmenu('refresh');
    $('#AjaxLoading').html('');
}
</script>

<br/>

<div id="AjaxOutput">
    <div data-demo-html="true" data-demo-js="true" data-demo-css="true">
        <h3>Worldwide Affiliates</h3>
 <br/><br/>
        <ul id="autocomplete" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="Find a gym..." data-filter-theme="d"></ul>
    </div><br/><br/>
    <form action="index.php" method="post" name="form" id="gymform">
    <input type="hidden" name="gym" id="gym" value=""/>
     <input class="buttongroup" type="button" onclick="gymformsubmit(gym.value);" value="Save"/>
</form>
</div>