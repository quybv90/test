<script type="text/javascript">
    var rateObject = {
        like : function(obj) {
            obj.on('click', function(e) {
                var thisObj = $(this);
                var thisType = thisObj.hasClass('rateUp') ? 'up' : 'down';
                var thisItem = thisObj.attr('data-item');
                var thisValue = thisObj.children('span').text();
                $.ajax({
                    type: 'POST',
                    url: '{{ URL::action("LikeController@like") }}',
                    dataType:'JSON',
                    data: {post_id: thisItem, like_value: 1},
                    success: function(data){
                      if(isNaN(data))
                      {
                        alert(data);
                        if (data == '{{Lang::get("common.login_require_message")}}'){
                            window.location = '{{ URL::to("login")}}';
                        }
                      }else{
                        $("#like_title").html('Đã có '+data+' người khen xinh, còn bạn thấy sao?');
                        $("#"+thisItem+" .rateUpN").html("Xinh ("+data+")");
                        // if(data - 1 > 0){
                        //     alert("Đã có " + (data) + " lượt khen ngon!");
                        // } else{
                        //     alert("Bạn đã khen ngon!");
                        // }
                        // $("#"+thisItem+" .rateUpN").html(data + "Ngon");
                      }
                    }
                });
                e.preventDefault();
            });
        },
        disLike : function(obj) {
            obj.on('click', function(e) {
                var thisObj = $(this);
                var thisType = thisObj.hasClass('rateUp') ? 'up' : 'down';
                var thisItem = thisObj.attr('data-item');
                var thisValue = thisObj.children('span').text();
                $.ajax({
                    type: 'POST',
                    url: '{{ URL::action("LikeController@disLike") }}',
                    dataType:'JSON',
                    data: {post_id: thisItem, like_value: -1},
                    success: function(data){
                      if(isNaN(data))
                      {
                        alert(data);
                        if (data == '{{Lang::get("common.login_require_message")}}'){
                            window.location = '{{URL::to("login")}}';
                        }
                      }else{
                        $("#dis_"+thisItem+" .rateDownN").html("Ko Xinh ("+data+")");
                        // if(data - 1 > 0){
                        //     alert("Đã có " + (data) + " lượt chê bài này!");
                        // } else{
                        //     alert("Bạn đã chê bài này!");
                        // }
                        // $("#total_like_number").html(data);
                        // $("#"+thisItem+" .rateDownN").html(data + "Ko Ngon");
                      }
                    }
                });
                e.preventDefault();
            });
        }
    };
    $(function() {
        jQuery.ajaxSetup({ cache:false });
        rateObject.like($('.like'));
        rateObject.disLike($('.disLike'));
    });

</script>