<?
session_start();
require_once("../config/config.inc.php");
require_once("../config/functions.inc.php");
validate_admin();
$line=mysql_fetch_array(mysql_query("select * from tbl_document where id=".$_GET['doc_id']));
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=SITE_ADMIN_TITLE?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />

<script src="popcalendar.js"></script>
<script src="ajax.js" type="text/javascript"></script>
<script language="javascript" runat="server">
function trim(s) {
  while (s.substring(0,1) == ' ') {
    s = s.substring(1,s.length);
  }
  while (s.substring(s.length-1,s.length) == ' ') {
    s = s.substring(0,s.length-1);
  }
  return s;
}
function check(fval)
{
	url = document.location.href;
	xend = url.lastIndexOf("/") + 1;
	var base_url = url.substring(0, xend);
	
	url="checkuser.php";
	 if (url.substring(0, 4) != 'http') {
		url = base_url + url;		
	}		

	var strSubmit="id1="+fval+"&selected=<?=$id?>";	
	var strURL = url;

	
	var strResultFunc = "displayResultuser";
	
	xmlhttpPost(strURL, strSubmit, strResultFunc)
	return true;
}
function displayResultuser(strIn) {
	if(strIn!='')
	{	
	//alert(strIn);
		document.getElementById('postid').innerHTML=strIn;
if(strIn=='This email is currently in use. Please choose another one.' || document.getElementById('email').value==''){
		document.getElementById('email').value='';
document.regFrm.email.focus();
}
	}
}
function checkpass(fval)
{
	url = document.location.href;
	xend = url.lastIndexOf("/") + 1;
	var base_url = url.substring(0, xend);
	
	url="checkpass.php";
	 if (url.substring(0, 4) != 'http') {
		url = base_url + url;		
	}		

	var strSubmit="id2="+fval+"&cat="+document.regFrm.password.value;		
	var strURL = url;

	
	var strResultFunc = "displayResultpass";
	
	xmlhttpPost(strURL, strSubmit, strResultFunc)
	return true;
}
function displayResultpass(strIn) {
	if(strIn!='')
	{	
		document.getElementById('cpass').innerHTML=strIn;
		if(strIn=='The confirm password is incorrect please try again.'){
		document.getElementById('cpassword').value='';
document.regFrm.cpassword.focus();
	}
	}
}


function validEmailAddress(email)
{
		invalidChars = " /:,;~"
		if (email == "") 
		{
			return (false);
		}
		for (i=0; i<invalidChars.length; i++) 
		{
			badChar = invalidChars.charAt(i)
			if (email.indexOf(badChar,0) != -1) 
			{
				return (false);
			}
		}
		atPos = email.indexOf("@",1)
		if (atPos == -1) 
		{
			return (false);
		}
		if (email.indexOf("@",atPos+1) != -1) 
		{
			return (false);
		}
		periodPos = email.indexOf(".",atPos)
		if (periodPos == -1) 
		{
			return (false);
		}
		if (periodPos+3 > email.length)	
		{
			return (false);
		}
			
		return (true);
}



function validForm(obj)
{
	
	var msg='Incomplete data! Kindly give Required information.\n\n', flag=false;
	if(obj.title.value == '') msg+='- Please enter Document Title. \n';
	if(obj.keyword.value == '') msg+='- Please enter Document Title. \n';
	<?php
	if($id=='')
	{	
	?>	if(obj.doc_path.value =='')
		{
			if(obj.doc_content.value =='')
			{
				msg+='- Please Uplaod Document Or Copy and Paste It. \n';
			}
		}
	<?php } 
	else
	{
		if(!$doc_path)
	?>
		if(obj.doc_content.value =='')
		{
			//msg+='- Please Uplaod Document Or Copy and Paste It. \n';
		}
	<?php 
	}	
	?>
	if(msg == 'Incomplete data! Kindly give Required information.\n\n')
		return true;
	else{
		alert(msg);
		return false;
	}
}

function changelanguage(id)
{
	location.href='user_addf.php?lang_id='+id;
}

</script>
</head>
<body >
<? include("header.inc.php");?>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <!--td width="180" valign="top">
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center">><? include("left_menu.inc.php");?></td>
        </tr>
        <tr>
          <td width="23" style="padding-left:10px">&nbsp;</td>
        </tr>
      </table>
    <br />
    <br /></td-->
    <td width="1" bgcolor="#045972"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td width="1"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td height="400" align="center" valign="top">
	<!-- Center Part Begins Here  -->
		<table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
          <!--tr>
            <td height="21" align="left" bgcolor="#EDEDED" class="txt">
				<table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="76%"><span class="title"><img src="images/heading_icon.gif" width="16" height="16" hspace="5">Document Manager</span></td>
                      <td width="24%" align="right"><input name="b1" type="button" class="button" id="b1" value="Document Manager" onClick="location.href='document_list.php?user_id=<?=$_GET[user_id]?>'"></td>
                    </tr>
                </table>
			</td>
          </tr-->
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF"><br>
              <form action="document_addf.php" method="post" enctype="multipart/form-data" name="regFrm"  onSubmit="return validForm(this)">
			  <input type="hidden" name="id" class="txtfld" value="<?=$id?>">
			  <input type="hidden" name="user_id" value="<?=$_GET[user_id]?>" />
			<table width="100%" border="0" cellspacing="0" cellpadding="4" align=center  bgcolor="#FFFFFF">
				<TR bgcolor="#EDEDED" align="left"> 
					<TD height="25" colspan="2" bgcolor="#4096AF" class="bigWhite"><strong>
				    <?php echo $line[doc_title];?></TD>
				
				</TR>
				<td align="left"><?=$line[doc_content]?></td>
			  	</tr>
				<TR>
				<td align="left">&nbsp;</td>
			  	</tr>
				<TR>
				<td align="left">&nbsp;</td>
			  	</tr>
				<tr align="center">
				<td align="left" valign="top">
				  <input type="button" name="close" value="Close"  onclick="window.close();" class="button" /> 
				</td>
				</tr>
				</table>
			  	
		
	  </form>
		<br>
         </td>
       </tr>
     </table>
	<!-- Center Part Ends Here  -->
	</td>
    <td width="20" valign="top" bgcolor="#EDEDED">&nbsp;</td>
  </tr>
</table>
<? include("footer.inc.php");?>
</body>
</html>
