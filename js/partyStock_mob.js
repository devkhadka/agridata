$(document).ready(function(){
    var interval = 0;
    var ids;
    var limit = new Array();
    limit = getLimit(interval);

    jQuery('#next').attr('disabled',true);
    $('#prev').click(function(){
        interval++;

        limit = getLimit(interval);
        $.ajax({
            url:"./ajax_mobile/partyStockList.php?id="+ids+"&llimit="+limit[0]+"&ulimit="+limit[1],
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
                url:"./ajax_mobile/partyStockList.php?id="+ids+"&llimit="+limit[0]+"&ulimit="+limit[1],
                success: function(html){
                    $('#list').html(html);
                }
            });
            if(interval == 0)
                jQuery('#next').attr('disabled',true);
        }
    });
        $.ajax({
        url:"./ajax_mobile/partyStockList.php?id="+ids+"&llimit="+limit[0]+"&ulimit="+limit[1],
        success: function(html){
            $('#list').html(html);
        }
    });
    $('#mob_party').change(function(){

        ids = this.value;
        //alert(ids);
        if(ids == null || ids <1) {
            ids=0;

            var limit = new Array();
            limit = getMonthLimit(0);
            $.ajax({
                url:"./ajax_mobile/partyStockList.php?id="+ids+"&llimit="+limit[0]+"&ulimit="+limit[1],
                success: function(html){
                    $('#list').html(html);
                }
            });
        } else {
            //            alert(ids);
            limit = getLimit(interval);
            $.ajax({
                url:"./ajax_mobile/partyStockList.php?id="+ids+"&llimit="+limit[0]+"&ulimit="+limit[1],
                success: function(html){
                    $('#list').html(html);
                }
            });
        }
    });

});
