$(document).ready(function(){

        var interval = 0;
        var ids;

	/*$('#headquater').chainSelect('#user','userchainselect.php',
	{ 
		after:function (target) //after request show the target combobox and hide the loading message
		{ 
			$(target).css("display","inline");
		}
	});*/
	
	$('#user').change(function(){

            ids =this.value;

//alert(ids);
            if(ids == null || ids <1) { 
                ids=0; 
                var limit = new Array();
                limit = getLimit(0);
                jQuery('#datepicker').val(limit[0]);
                jQuery('#datepicker_to').val(limit[1]);
                //if(jQuery('#list').jqGrid('getGridParam','records') >0 ) { 
                    jQuery('#list').jqGrid('setGridParam',{url:'./ajax/mtada.php?q=1&id='+ids+'&llimit='+limit[0]+'&ulimit='+limit[1],page:1}); 
                    jQuery('#list').jqGrid('setCaption','TA / DA List:').trigger('reloadGrid');
                //} 
            } else { 
				
				var limit = new Array();
                limit = getLimit(interval);
                jQuery('#datepicker').val(limit[0]);
                jQuery('#datepicker_to').val(limit[1]);
                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/mtada.php?q=1&id='+ids+'&llimit='+limit[0]+'&ulimit='+limit[1],page:1}); 
                jQuery('#list').jqGrid('setCaption','TA / DA List:').trigger('reloadGrid'); 
            } 

        });
        
        $('#go').click(function(){
                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/mtada.php?q=1&id='+ids+'&llimit='+jQuery('#datepicker').val()+'&ulimit='+jQuery('#datepicker_to').val(),page:1}); 
                jQuery('#list').jqGrid('setCaption','TA / DA List:').trigger('reloadGrid');

            });

        jQuery('#next').attr('disabled',true); 
        $('#prev').click(function(){
            interval++;
            var limit = new Array();
            limit = getLimit(interval);
            jQuery('#datepicker').val(limit[0]);
            jQuery('#datepicker_to').val(limit[1]);
            jQuery('#next').attr('disabled',false); 
            jQuery('#list').jqGrid('setGridParam',{url:'./ajax/mtada.php?q=1&id='+ids+'&llimit='+limit[0]+'&ulimit='+limit[1],page:1}); 
            jQuery('#list').jqGrid('setCaption','TA / DA List:').trigger('reloadGrid'); 
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
            jQuery('#list').jqGrid('setGridParam',{url:'./ajax/mtada.php?q=1&id='+ids+'&llimit='+limit[0]+'&ulimit='+limit[1],page:1}); 
            jQuery('#list').jqGrid('setCaption','TA / DA List:').trigger('reloadGrid'); 
        });

        jQuery('#list').jqGrid({
            url:'./ajax/mtada.php?q=1&id=0&inv=0',
            datatype: 'xml',
            mtype: 'GET',
            colNames:['SN','Date','Created Date', 'Visited Place','TA (Rs.)','DA (Rs.)','Others (Rs.)','Total (Rs.)','Remark','Approved'],
            colModel :[ 
            {name:'id', index:'id', width:15,sortable:false}, 
            {name:'visited_date', index:'visited_date', width:60, align:'left',sorttype:'text'},
            {name:'created_date', index:'created_date', width:60, align:'left',sorttype:'text'},
            {name:'visit_place', index:'visit_place', width:80, align:'left',sortable:false}, 
            {name:'ta', index:'ta', width:50, align:'left',sortable:false}, 
            {name:'da', index:'da', width:50, align:'left',sortable:false}, 
            {name:'other', index:'other', width:50, align:'center',sortable:false}, 
            {name:'total', index:'total', width:50, align:'center',sortable:false}, 
            {name:'remark', index:'remark', width:100, align:'left',sortable:false}, 
            {name:'approved', index:'approved', width:70, align:'center', sortable:false}
            ],
            pager: '#pager',
            rowNum:10,
                width:650,
                height:220,
                hidegrid:false,
            rowList:[10,20,30],
            sortname: 'visited_date',
            sortorder: 'DESC',
            viewrecords: true,
            imgpath: '',
            caption: 'TA / DA List',
            editurl:'./ajax/mtada.php?msg=del',         
            onCellSelect: function(ids,colid,value) {
                    
                    if(colid == 9){
                        var gr=jQuery(this).jqGrid('getGridParam','selrow');                       
                        if(gr !=null ){ 
                            jQuery(this).jqGrid('delGridRow',gr,{reloadAfterSubmit:true,caption:"Approve / Reject",msg:"Are you sure you want to approve / reject ?",bSubmit:"Approve / Reject",bCancel:"Cancel"});							
                        }                        
                    }
                }
        }); 
        $('#user').change();	
});
