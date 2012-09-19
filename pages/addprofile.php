<?php 
function addProfile(){
$str; global $form;
$str="<form method='POST' action='index.html'>
<table width='488' border='0'>
  <tr>
    <td colspan='4'><div align='center'>
      <h3>Personal Information </h3>
    </div></td>
  </tr>
  <tr>
    <td width='178'>&nbsp;</td>
    <td width='18'>&nbsp;</td>
    <td width='278'>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>First Name </td>
    <td>:</td>
    <td><input type='text' name='fname' /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Middle Name </td>
    <td>:</td>
    <td><input type='text' name='mname' /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Last Name </td>
    <td>:</td>
    <td><input type='text' name='lname' /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Street Address 1 </td>
    <td>:</td>
    <td><input type='text' name='streetAdd1' value='{$form->value('streetAdd1')}' ></td>
    <td>{$form->error('streetAdd1')}</td>
  </tr>
  <tr>
    <td>Street Address 2 </td>
    <td>:</td>
    <td><input type='text' name='streetAdd2' value='{$form->value('streetAdd2')}' ></td>
    <td>{$form->error('streetAdd2')}</td>
  </tr>
  <tr>
    <td>City</td>
    <td>:</td>
    <td><input type='text' name='city' value='{$form->value('city')}' ></td>
    <td>{$form->error('city')}</td>
  </tr>
  <tr>
    <td>State</td>
    <td>:</td>
    <td><input type='text' name='state' value='{$form->value('state')}'></td>
	<td>{$form->error('state')}</td>
  </tr>
  <tr>
    <td>Zip</td>
    <td>:</td>
    <td><input type='text' name='zip' value='{$form->value('zip')}'></td>
    <td>{$form->error('zip')}</td>
  </tr>
  <tr>
    <td>Country</td>
    <td>:</td>
    <td><input type='text' name='country' value='{$form->value('country')}'></td
    <td>{$form->error('country')}<td>
  </tr>
  <tr>
    <td>Mobile</td>
    <td>:</td>
    <td><input type='text' name='mobile' value='{$form->value('mobile')}'></td>
    <td>{$form->error('mobile')}<td>
  </tr>
  <tr>
    <td>&nbsp;</td>";
if($form->value('help_setupCamera')=="yes")
$check="checked";
  $str.=" <td><div align='right'><input type ='checkbox' name='help_setupCamera' value='yes' {$check}></div></td>
    <td>Help me setup my camera. </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type='submit' value= 'Next' name='Next' /></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>";
return $str;


}
?>
