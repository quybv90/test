@include('partials.modal_feedback')
<div id="feedback-image">
    <a href="javascript:void(0)" id="feedback-link" ><img width='200px' height='100px' src="{{ asset('images/email1.png') }}" title="Hòm thư góp ý" id="" class="fback-hover"></a>
    <a href="javascript:void(0)" id="" ><img src="{{ asset('images/chevron-right.png') }}" class="fback-hover" id="chevron-right"></a>
</div>
<script type="text/javascript">
	$('.fback-hover').on('mouseover', function(){
	   $('#feedback-link').show(); 
	});
	$('.fback-hover').on('mouseout', function(){
	   $('#feedback-link').hide(); 
	});
	$('#feedback-link').on('click', function(){
		$('#modal_feedback').modal('show');
	});
</script>