$(document).ready(function(){
        $('#list_d').hide();
        var interval = 0;
        var ids;
         var limit = new Array();
/*
	$('#headquater').chainSelect('#user','userchainselect.php',
	{
		after:function (target) //after request show the target combobox and hide the loading message
		{
			$(target).css("display","inline");
		}
	});
*/
	$('#user').change(function(){
            ids =this.value;
//alert(ids);
           
            if(ids == null || ids <1) {
                ids=0;
                
                limit = getLimit(0);
               
                jQuery('#datepicker').val(limit[0]);
                jQuery('#datepicker_to').val(limit[1]);
                //if(jQuery('#list').jqGrid('getGridParam','records') >0 ) {
                    jQuery('#list').jqGrid('setGridParam',{url:'./ajax/msalesplan.php?q=1&id='+ids+'&llimit='+limit[0]+'&ulimit='+limit[1],page:1});
                    jQuery('#list').jqGrid('setCaption','Sales Plan List:').trigger('reloadGrid');
                //}
            } else {
                //limit = new Array();
                limit = getLimit(interval);
                jQuery('#datepicker').val(limit[0]);
                jQuery('#datepicker_to').val(limit[1]);

//                 alert(ids);
                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/msalesplan.php?q=1&id='+ids+'&llimit='+limit[0]+'&ulimit='+limit[1],page:1});
                jQuery('#list').jqGrid('setCaption','Sales Plan List:').trigger('reloadGrid');
            }

        });

        $('#go').click(function(){
                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/msalesplan.php?q=1&id='+ids+'&llimit='+jQuery('#datepicker').val()+'&ulimit='+jQuery('#datepicker_to').val(),page:1});
                jQuery('#list').jqGrid('setCaption','Sales Plan List:').trigger('reloadGrid');

            });
        jQuery('#next').attr('disabled',true);
        $('#prev').click(function(){
            interval++;
            var limit = new Array();
            limit = getLimit(interval);
            jQuery('#datepicker').val(limit[0]);
            jQuery('#datepicker_to').val(limit[1]);

            jQuery('#next').attr('disabled',false);
            jQuery('#list').jqGrid('setGridParam',{url:'./ajax/msalesplan.php?q=1&id='+ids+'&llimit='+limit[0]+'&ulimit='+limit[1],page:1});
            jQuery('#list').jqGrid('setCaption','Sales Plan List:').trigger('reloadGrid');
        });

        $('#next').click(function(){
            if(interval > -1){
                interval--;
                var limit = new Array();
                limit = getLimit(interval);
                jQuery('#datepicker').val(limit[0]);
                jQuery('#datepicker_to').val(limit[1]);


                if(interval == 0)
                    jQuery('#next').attr('disabled',true);
            }
            //else {
                //jQuery('#next').attr('disabled',true);
            //}
            //alert(interval);
            jQuery('#list').jqGrid('setGridParam',{url:'./ajax/msalesplan.php?q=1&id='+ids+'&llimit='+limit[0]+'&ulimit='+limit[1],page:1});
            jQuery('#list').jqGrid('setCaption','Sales Plan List:').trigger('reloadGrid');
        });

        jQuery('#list').jqGrid({
            url:'./ajax/msalesplan.php?q=1&id='+ids+'&inv=0',
            datatype: 'xml',
            mtype: 'GET',
           colNames:['SN', 'Party Name','Created_at','From Date','To Date',''],
                colModel :[
                {name:'id', index:'id', width:25,sortable:false},
                {name:'party_name', index:'party_name', width:150, align:'left',sortable:false},
                {name:'Created_at', index:'Created_at', width:70, align:'left',sorttype:'text'},
                {name:'from_date', index:'from_date', width:70, align:'left',sorttype:'text'},
                {name:'to_date', index:'to_date', width:60, align:'left',sorttype:'text'},
                {name:'dummy', index:'dummy', hidden:true}

            ],
            pager: '#pager',
            rowNum:10,
                width:650,
                height:220,
                hidegrid:false,
            rowList:[10,20,30],
            sortname: 'created_at',
            sortorder: 'DESC',
            viewrecords: true,
            imgpath: '',
            caption: 'Sales Plan List',
            onSelectRow: function(ids) {

                    //alert(ids);
                      $('#list_d').show();
                    jQuery('#list_d').jqGrid('setGridParam',{url:'./ajax/salesPlanDetail.php?q=1&llimit='+limit[0]+'&ulimit='+limit[1]+'&id='+ids,page:1});
                    jQuery('#list_d').jqGrid('setCaption','Sales Plan Detail :').trigger('reloadGrid');
                }

        });
        jQuery('#list_d').jqGrid({
                url:'./ajax/salesPlanDetail.php?q=1&llimit='+limit[0]+'&ulimit='+limit[1],
                datatype: 'xml',
                mtype: 'GET',
                colNames:['SN', 'Product Name','Plan','Discount'],
                colModel :[
                {name:'id', index:'id', width:25,sortable:false},
                {name:'product_name', index:'product_name', width:150, align:'left',sortable:false},
                {name:'plan', index:'plan', width:70, align:'left',sorttype:'text'},
                {name:'Discount', index:'Discount', width:60, align:'left',sorttype:'text'},
                ],
                pager: '#pager',
                rowNum:15,
                    width:650,
                    height:330,
                    hidegrid:false,
                rowList:[10,20,30],
                sortname: 'plan_case',
                sortorder: 'DESC',
                viewrecords: true,
                imgpath: '',
                caption: 'Sales Plan Detail'
            });
        $('#user').change();

});
