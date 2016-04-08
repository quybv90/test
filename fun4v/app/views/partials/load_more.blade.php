<script type="text/javascript">
$(document).ready(function() {
    $("#other_content").hide();
    var track_load =3; //total loaded record group(s)
    var loading  = false; //to prevents multipal ajax loads
    var total_groups = <?php echo $total_groups; ?>; //total record group(s)
    if(track_load >= total_groups){
        $("#other_content").show();
    }    
    $(window).scroll(function() { //detect page scroll
        
        if($(window).scrollTop() + $(window).height() >= $(document).height()-150)  //user scrolled to bottom of the page?
        {
            
            if(track_load < total_groups && loading==false) //there's more data to load
            {
                $("#img_loading").show();
                loading = true; //prevent further ajax loading
                
                $.get('{{URL::action("PostController@show", [$post->id])}}',{'group_no': track_load}, function(data){
                    $("#content-div").append(data.replace('null', '')); //append received data into the element

                    track_load++; //loaded group increment
                    loading = false; 
                    $("#img_loading").hide();
                
                }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?
                    
                    alert(thrownError); //alert with HTTP error
                    loading = false;
                });
                
            }else{
                $("#img_loading").hide();
                $("#other_content").show();
            }
        }
    });
});
</script>
