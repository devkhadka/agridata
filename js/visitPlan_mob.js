$(document).ready(function(){

        var interval = 0;
        var limit = new Array();
        limit = getLimit(interval);

        jQuery('#next').attr('disabled',true);
        $('#prev').click(function(){
            interval++;

            limit = getLimit(interval);
            $.ajax({
                url:"./ajax_mobile/visitPlanList.php?llimit="+limit[0]+"&ulimit="+limit[1],
                success: function(html){
                    $('#list').html(html);
                }

            });

            jQuery('#next').attr('disabled',false);
        });

        $('#next').click(function(){
            if(interval > -1){
                interval--;
                limit = getLimit(interval);
                $.ajax({
                    url:"./ajax_mobile/visitPlanList.php?llimit="+limit[0]+"&ulimit="+limit[1],
                    success: function(html){
                        $('#list').html(html);
                    }
                });
                if(interval == 0)
                    jQuery('#next').attr('disabled',true);
            }
        });
        $.ajax({
            url:"./ajax_mobile/visitPlanList.php?llimit="+limit[0]+"&ulimit="+limit[1],
            success: function(html){
                $('#list').html(html);
            }
        });
    });





//    function partyId(val) {
////        alert(val);
//        $.ajax({
//            type:"GET",
//            url:"./ajax_mobile/collectionPlan.php?party_id="+val,
//            cache: false,
//            success: function(msg){
//                $("#dueAmount").html(msg);
//                $("#dueAmount").show();
//            }
//        });
//    }