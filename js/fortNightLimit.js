function getMonthLimit(interval){
		
	var year,month,day;
	var curTime = new Date();
	var curYear = curTime.getFullYear();
	var curMonth = curTime.getMonth()+1;
	var curDay = curTime.getDate();
	
		
	if(interval == 0){
            year = curYear;
            month = curMonth;
            
    }else {
            
		if((curMonth-interval) > 0)
			month = curMonth - interval;
		else
			month = 12 +(curMonth - interval)%12;

		year = curYear-Math.floor(((interval-curMonth)/13)+1);
	}
	
	//alert(year+"-"+month)
	
	var limit = new Array();
    limit[0] = year+"-"+pad(month,2)+"-01";
    limit[1] = year+"-"+pad(month,2)+"-"+daysInMonth(month,year);

    return limit; 	
}


function getLimit(interval){

    var year,month,day,lday;
    var curTime = new Date();
    var curYear = curTime.getFullYear();
    var curMonth = curTime.getMonth()+1;
    var curDay = curTime.getDate();
    if(curDay >= 16){
        if((curMonth-interval/2) > 0)
            month = Math.ceil(curMonth - interval/2);
        else
            month = Math.ceil(13 +(curMonth - interval/2)%13);
        year = curYear-Math.floor(((interval/2-curMonth)/13)+1); 
        if(interval%2 == 0){
            day = "15";
            lday = "31";
        }else{
            day = "01";
            lday= "15";
        }
        
    } else {
        
        if(interval == 0){
            year = curYear;
            month = curMonth;
            
        }else {
            
            if((curMonth-Math.ceil(interval/2)) > 0)
                month = Math.ceil(curMonth - Math.ceil(interval/2));
            else
                month = Math.ceil(13 +(curMonth - Math.ceil(interval/2))%13);

            year = curYear-Math.floor(((Math.ceil(interval/2)-curMonth)/13)+1); 
        }           

        if(interval%2 == 0){
            day = "01";
            lday = "15";
        }
        else{
            day = "15";
            lday = "31";
        }
    }       

    var limit = new Array();
    limit[0] = year+"-"+pad(month,2)+"-"+day;
    limit[1] = year+"-"+pad(month,2)+"-"+lday;

    return limit;            
}


function daysInMonth(month,year) {
	var dd = new Date(year, month, 0);
	return dd.getDate();
} 

function pad(number, length) {
   
    var str = '' + number;
    while (str.length < length) {
        str = '0' + str;
    }
   
    return str;

}
