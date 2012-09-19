<?php
function expert_services(){
    global $ctrl,$form;
    $ret="";
    if(isset($_POST['submit']) ){
        $retVal= $ctrl->askExpertQuery($_POST);
        if($retVal==='fail'){
            $response.="<div id='notice'><font color='red' size='2'> There is some problem with server, Please try later. </font> </div> <br />";
        }
        else{
        if($retVal){
        $response.="<div id='notice'><font color='red' size='2'> Thank you for you interest Agricare Nepal. We will reply you shortly. </font> </div> <br />";
        }else
        {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
            header("Location:".$ctrl->referrer);				
        
        }
        }
    } 

    Page::$jslink=array('js/jquery-latest.js','js/jquery.validate.js');
    Page::$jslink=('js/service-expert.js');
    Page::$csslink=array('css/ui.all.css');
$ret.=<<<EOT
	<div>
	<div class="header_01">Ask the Experts</div>
	<p>Our aim is not only to sell the products but also to know the related problems with its distribution, the problems people are facing in their field related to their crops. Also to the students who have new concepts, innovation related to agriculture. For this purpose we have the ‘ask the expert’ section. Through this section we aim to solve the problems of the farmers and the people faced by them in their field. We want the innovative mind to flourish so as to help develop the agricultural situation of the country. We are doing this because we believe that through agricultural development the economic condition of the country could be lifted that cannot be done by the other sector. So to be economically stable country we have to be stable in our agricultural production. The section has been divided into three parts i.e. for students, for farmers and for the researchers who wants to do some research in this field. In case of research work we want you to send the concept which is suitable to the local needs so that its output should facilitate the local agriculture. Funds will be made available to the researchers by the company if the concept is suitable. 
    </div><div>{$response} </div>
    <div style="position:relative;">
		<form id="formFarmers" method="post" action="{$_SERVER['REQUEST_URI']}">
			<div style="position:relative;">
				<table border=0 align='left' width ='70%'>				
					<tr>
						<td width='200' align='right'>Name :* </td>
						<td width='8'></td>
						<td width='160'><input type="text" name="name" value="{$form->value('name')}" /></td>
                                                <td> <div class="form_error">{$form->error('name')}</div> </td>
 
				        </tr>				
					-<tr>
						<td width='200' align='right'>Address :*</td>
						<td width='8'></td>
						<td width='160'><input type="text" name="address" value="{$form->value('address')}" /></td>
                                                <td> <div class="form_error">{$form->error('address')}</div> </td>
					</tr>
					<tr>
						<td width='200' align='right'>Telephone No :</td>
						<td width='8'></td>
						<td width='160'><input type="text" name="phone" value="{$form->value('phone')}" /></td>
                                                <td> <div class="form_error">{$form->error('phone')}</div> </td>
					</tr>
					<tr>
						<td width='200' align='right'>Email address :</td>
						<td width='8'></td>
						<td width='160'><input type="text" name="email" value="{$form->value('email')}" /></td>
                                                <td> <div class="form_error">{$form->error('email')}</div> </td>
					</tr>
					<tr>
						<td width='200' align='right'>Profession :</td>
						<td width='8'></td>
						<td width='160'>
							<select name="profession" id="selectprofession">
								<option value="select">---Select Occupation ---</option>
								<option value='student'>Student</option>
								<option value='farmer'>Farmer</option>
								<option value='research'>Research</option>
							</select>
						</td>
                                                <td> </td>
					</tr> 
				</table>
			</div>
			<div id = "students">
				<table border=0 align='left' >				
					<tr>					
						<td width='200' align='right'>Currently involved (Universities/College) :</td>
						<td width='8'></td>
						<td width='200'><input type="text" name="collegeS" /></td>					
                                                <td> </td>
					</tr>
					<tr>					
						<td width='200' align='right'>Interest Topic :</td>
						<td width='8'></td>
						<td width='200'><input type="text" name="topicS" /></td>					
                                                <td> </td>
					</tr>
					<tr>					
						<td width='200' align='right'>Ask the queries/questions * :</td>
						<td width='8'></td>
						<td width='200'><textarea name="questionS" rows= "11" cols="65" ></textarea></td>					
                                                <td> </td>
					</tr>
				</table>			
			</div>		
			<div id = "farmer">
				<table border=0 align='left' >				
					<tr>					
						<td width='200' align='right'>Name of the crop :</td>
						<td width='8'></td>
						<td width='200'><input type="text" name="cropF" /></td>					
                                                <td> </td>
					</tr>
					<tr>					
						<td width='200' align='right'>Days from when the problem appears :</td>
						<td width='8'></td>
						<td width='200'><input type="text" name="dateOfProblem" /></td>					
                                                <td> </td>
					</tr>					
					<tr>					
						<td width='200' align='right'>Problems in Crop(General) :</td>
						<td width='8'></td>
						<td width='200'><textarea rows="4" cols="65" name="generalF" ></textarea></td>					
                                                <td> </td>
					</tr>
					<tr>					
						<td width='200' align='right'>Problems in Crop(Specific) :</td>
						<td width='8'></td>
						<td width='200'><textarea rows="4" cols="65" name="specificF" ></textarea></td>					
                                                <td> </td>
					</tr>
				</table>			
			</div>		
			<div id = "research">
				<table border=0 align='left' >				
					<tr>					
						<td width='200' align='right'>Topic on Research :</td>
						<td width='8'></td>
						<td width='200'><input type="text" name="topicR" /></td>					
                                                <td> </td>
					</tr>
					<tr>					
						<td width='200' align='right'>Other/Explanation :</td>
						<td width='8'></td>
						<td width='200'><textarea name="explanationR" rows="9" cols="65" ></textarea></td>					
                                                <td> </td>
					</tr>					
				</table>			
			</div>
			<div>
				<table border=0 align='left' >
					 <tr>
						<td width='250'>&nbsp;</td>
						 <td><input id='btnSubmit' name="submit" class="submit" type="submit" value="Submit"></td>
					 </tr>
				 </table>
			</div>			
		</form>   
	</div>         



EOT;

return $ret;

}
?>
