
            <script type='text/javascript'>
            <script type='text/javascript'>
jQuery(document).ready(function(){

                $('#headquater').chainSelect('#party','partychainselect.php',
                { 
                    //before:function (target) //before request hide the target combobox and display the loading message
                //alert('rk chor');
                    //{ 
                        //$('#loading').css('display','block');
                        //$(target).css('display','none');
                    //},
                    after:function (target) //after request show the target combobox and hide the loading message
                    { 
                        //$('#loading').css('display','none');
                        $(target).css('display','inline');
                    }
                });
        
            jQuery('#list').jqGrid({
                url:'{$url}',
                datatype: 'xml',
                mtype: 'GET',
                colNames:['SN','Date', 'Product','N.D.Price','No. in Case','No. of Case','Amount'],
                colModel :[ 
                {name:'id', index:'id', width:25,sortable:false}, 
                {name:'collected_date', index:'collected_date', width:50, align:'left',sortable:false}, 
                {name:'product', index:'product', width:100, align:'left',sortable:false}, 
                {name:'ndprice', index:'ndprice', width:60, align:'left',sortable:false}, 
                {name:'noincase', index:'noincase', width:50, align:'left',sortable:false}, 
                {name:'noofcase', index:'noofcase', width:50, align:'left',sortable:false}, 
                {name:'amount', index:'amount', width:50, align:'left',sortable:false}, 
                ],
                pager: '#pager',
                rowNum:8,
                    width:500,
                    height:175,
                    hidegrid:false,
                rowList:[10,20,30],
                sortname: 'collected_date',
                sortorder: 'DESC',
                viewrecords: true,
                imgpath: '',
                caption: 'Party Stock List'
            }); 
            }); 
            </script>
jQuery(document).ready(function(){

                $('#headquater').chainSelect('#party','partychainselect.php',
                { 
                    //before:function (target) //before request hide the target combobox and display the loading message
                //alert('rk chor');
                    //{ 
                        //$('#loading').css('display','block');
                        //$(target).css('display','none');
                    //},
                    after:function (target) //after request show the target combobox and hide the loading message
                    { 
                        //$('#loading').css('display','none');
                        $(target).css('display','inline');
                    }
                });
        
            jQuery('#list').jqGrid({
                url:'{$url}',
                datatype: 'xml',
                mtype: 'GET',
                colNames:['SN','Date', 'Product','N.D.Price','No. in Case','No. of Case','Amount'],
                colModel :[ 
                {name:'id', index:'id', width:25,sortable:false}, 
                {name:'collected_date', index:'collected_date', width:50, align:'left',sortable:false}, 
                {name:'product', index:'product', width:100, align:'left',sortable:false}, 
                {name:'ndprice', index:'ndprice', width:60, align:'left',sortable:false}, 
                {name:'noincase', index:'noincase', width:50, align:'left',sortable:false}, 
                {name:'noofcase', index:'noofcase', width:50, align:'left',sortable:false}, 
                {name:'amount', index:'amount', width:50, align:'left',sortable:false}, 
                ],
                pager: '#pager',
                rowNum:8,
                    width:500,
                    height:175,
                    hidegrid:false,
                rowList:[10,20,30],
                sortname: 'collected_date',
                sortorder: 'DESC',
                viewrecords: true,
                imgpath: '',
                caption: 'Party Stock List'
            }); 
            }); 
            </script>
