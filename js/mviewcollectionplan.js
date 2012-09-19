$(document).ready(function(){

        var interval = 0;
        var ids;
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
                    jQuery('#list').jqGrid('setGridParam',{url:'./ajax/mCollectionPlan.php?q=1&id='+ids+'&llimit='+limit[0]+'&ulimit='+limit[1],page:1});
                    jQuery('#list').jqGrid('setCaption','Collection Plan List:').trigger('reloadGrid');
                //}
            } else {
                var limit = new Array();
                limit = getLimit(interval);
                jQuery('#datepicker').val(limit[0]);
                jQuery('#datepicker_to').val(limit[1]);

                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/mCollectionPlan.php?q=1&id='+ids+'&llimit='+limit[0]+'&ulimit='+limit[1],page:1});
                jQuery('#list').jqGrid('setCaption','Collection Plan List:').trigger('reloadGrid');
            }

        });

        $('#go').click(function(){
                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/mCollectionPlan.php?q=1&id='+ids+'&llimit='+jQuery('#datepicker').val()+'&ulimit='+jQuery('#datepicker_to').val(),page:1});
                jQuery('#list').jqGrid('setCaption','Collection Plan List:').trigger('reloadGrid');

            });
        jQuery('#next').attr('disabled',true);
        $('#prev').click(function(){
            interval++;
            var limit = new Array();
            limit = getLimit(interval);
            jQuery('#datepicker').val(limit[0]);
            jQuery('#datepicker_to').val(limit[1]);

            jQuery('#next').attr('disabled',false);
            jQuery('#list').jqGrid('setGridParam',{url:'./ajax/mCollectionPlan.php?q=1&id='+ids+'&llimit='+limit[0]+'&ulimit='+limit[1],page:1});
            jQuery('#list').jqGrid('setCaption','Collection Plan List:').trigger('reloadGrid');
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
            jQuery('#list').jqGrid('setGridParam',{url:'./ajax/mCollectionPlan.php?q=1&id='+ids+'&llimit='+limit[0]+'&ulimit='+limit[1],page:1});
            jQuery('#list').jqGrid('setCaption','Collection Plan List:').trigger('reloadGrid');
        });

        jQuery('#list').jqGrid({

			//var limit = new Array();
            //limit = getLimit(interval);
            //alert(limit);

            url:'./ajax/mCollectionPlan.php?q=1&id='+ids+'&inv=0',
            datatype: 'xml',
            mtype: 'GET',
            colNames:['SN','Party Name','Created_at','From','To','Amount',''],
            colModel :[
            {name:'id', index:'id', width:25,sortable:false},
            {name:'party_name', index:'party_name', width:150, align:'left',sortable:false},
            {name:'created_at', index:'created_at', width:70, align:'left',sorttype:'text'},
            {name:'From_date', index:'From_date', width:60, align:'left',sorttype:'text'},
            {name:'To_date', index:'To_date', width:60, align:'left',sorttype:'text'},
            {name:'amount', index:'amount', width:60, align:'left',sorttype:'false'},
            {name:'dummy', index:'dummy', hidden:true}

            ],
            pager: '#pager',
            rowNum:10,
                width:650,
                height:220,
                hidegrid:false,
            rowList:[10,20,30],
            sortname: 'From_date',
            sortorder: 'DESC',
            viewrecords: true,
            imgpath: '',
            caption: 'Collection Plan List'

        });
        $('#user').change();

});
