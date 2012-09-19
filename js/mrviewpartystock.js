$(document).ready(function(){
    var interval = 0;
    var ids;
    var baseLinkUrls = "agricare.php";
    var addParamEs = "&page=editpartystock";
    var idNames ="id";
//    alert(baseLinkUrls);
        $('#prev').click(function(){
            interval++;
            var limit = new Array();
            limit = getMonthLimit(interval);
            jQuery('#datepicker').val(limit[0]);
            jQuery('#datepicker_to').val(limit[1]);
            //alert(interval);
            jQuery('#next').attr("disabled",false);
            jQuery('#list').jqGrid('setGridParam',{url:'./ajax/mrpartystock.php?q=1&id='+ids+'&llimit='+limit[0]+'&ulimit='+limit[1],page:1});
            jQuery('#list').jqGrid('setCaption','Party Stock List:').trigger('reloadGrid');
        });

        $('#next').click(function(){
            if(interval > -1){
                interval--;

                var limit = new Array();
				limit = getMonthLimit(interval);
				jQuery('#datepicker').val(limit[0]);
				jQuery('#datepicker_to').val(limit[1]);

                if(interval == 1)
                    jQuery('#next').attr("disabled",true);
            }
            //else {
                //jQuery('#next').attr("disabled",true);
            //}
            //alert(interval);
            jQuery('#list').jqGrid('setGridParam',{url:'./ajax/mrpartystock.php?q=1&id='+ids+'&llimit='+limit[0]+'&ulimit='+limit[1],page:1});
            jQuery('#list').jqGrid('setCaption','Party Stock List:').trigger('reloadGrid');
        });

        $('#go').click(function(){
                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/mrpartystock.php?q=1&id='+ids+'&llimit='+jQuery('#datepicker').val()+'&ulimit='+jQuery('#datepicker_to').val(),page:1});
                jQuery('#list').jqGrid('setCaption','Party Stock List:').trigger('reloadGrid');

            });

	$('#party').change(function(){

            ids =this.value;
//            alert(ids);
            if(ids == null || ids <1) {
                ids=0;
                var limit = new Array();
                limit = getMonthLimit(0);
                jQuery('#datepicker').val(limit[0]);
                jQuery('#datepicker_to').val(limit[1]);
                //if(jQuery('#list').jqGrid('getGridParam','records') >0 ) {
                    jQuery('#list').jqGrid('setGridParam',{url:'./ajax/mrpartystock.php?q=1&id='+ids+'&llimit='+limit[0]+'&ulimit='+limit[1],page:1});
                    jQuery('#list').jqGrid('setCaption','Party Stock List:').trigger('reloadGrid');
                //}
            } else {
		limit = new Array();
                limit = getMonthLimit(interval);
                jQuery('#datepicker').val(limit[0]);
                jQuery('#datepicker_to').val(limit[1]);
                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/mrpartystock.php?q=1&id='+ids+'&llimit='+limit[0]+'&ulimit='+limit[1],page:1});
                jQuery('#list').jqGrid('setCaption','Party Stock List:').trigger('reloadGrid');
            }

        });


        jQuery('#list').jqGrid({
            url:'./ajax/mrpartystock.php?q=1&id=0&inv=0',
            datatype: 'xml',
            mtype: 'GET',
            colNames:['SN','Date','Created Date','Product','No. of Case','Indivisual','-','-',''],
                colModel :[
                {name:'id', index:'id', width:25,sortable:false},
                {name:'collected_date', index:'collected_date', width:60, align:'left',sorttype:'text'},
                {name:'created_date', index:'created_date', width:70, align:'left',sorttype:'text'},
//                {name:'party_name', index:'party_name', width:150, align:'left',sortable:false},
                {name:'name', index:'name', width:100, align:'left',sortable:false},
                {name:'no_of_case', index:'no_of_case', width:50, align:'left',sortable:false},
                {name:'indivisual', index:'indivisual', width:50, align:'left',sortable:false},
                {name:'a', index:'a', width:20, align:'center', sortable:false, formatter:'showlink', formatoptions:{baseLinkUrl:baseLinkUrls, addParam: addParamEs, idName:idNames}},
                {name:'b', index:'b', width:20, align:'center', sortable:false},
                {name:'dummy', index:'dummy', hidden:true}
                ],
                pager: '#pager',
            rowNum:10,
                width:600,
                height:250,
                hidegrid:false,
            rowList:[10,20,30],
            sortname: 'collected_date',
            sortorder: 'DESC',
            viewrecords: true,
            imgpath: '',
            caption: 'Party Stock List'
        });

        $('#party').change();
});
