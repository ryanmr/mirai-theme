<script type="text/javascript">
jQuery(document).ready(function($){

	var reply = $('#reply-title');
	var commentform = $('#commentform')

	reply.html( reply.html() + '<span class="toggle">(open comment form)</span>' );
	commentform.hide();
	reply.click(function(){
		commentform.show('slow');
		reply.addClass('form-open');
		$('#reply-title span.toggle').remove();
	});


});
</script>