<!DOCTYPE html>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Invite people to Data Room</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Quattrocento+Sans' rel='stylesheet' type='text/css'>
</head>
<body style="margin:0;padding:0;">
<table border="0" cellpadding="0" cellspacing="0" width="100%" >
    <tr>
        <td>
        <table align="center" border="0" cellpadding="10" cellspacing="10" width="800" style="border-collapse: collapse;border:1px solid #1279B2;">
            <tr>
            <td bgcolor="1279B2">
                <img src="http://alpha.ravabe.com/dataroom/assets/images/logo.png" alt=""/>
            </td>
            <td bgcolor="1279B2" style="padding-left:10px;">
                <h2 style="text-transform:uppercase;color:#fff;font-family: 'Oswald', sans-serif;"><?php echo Lang::get('messages.label_invite_prople_for_dataroom');?>
								</h2>
                <h4 style="color:#fff;font-family: 'Quattrocento Sans', sans-serif;"><?php echo Lang::get('messages.msg_email_content');?></h4>
            </td>
            </tr>
            <tr>
                <td colspan="2" style="padding:5px;color:#757575;padding-top:30px;font-family: 'Quattrocento Sans', sans-serif;"><!--{{$email_message}}--></td>
            </tr>
            <tr>
                <td colspan="2" style="padding:5px;"><a href="{{$email_action_url}}" style="font-family: 'Oswald', sans-serif;background-color:#1279B2;color:#fff;padding:5px;border:1px solid #fff;border-radius:4px;font-weight:normal;text-decoration:none;width:250px;display:block;text-align:center;" onmouseover="this.style.backgroundColor ='#fff';this.style.color ='#1279B2';this.style.borderColor ='#1279B2';" onmouseout="this.style.backgroundColor ='#1279B2';this.style.color ='#fff';this.style.borderColor ='#fff';">{{$email_action_text}}</a></td>
            </tr>
            <tr><td colspan="2" style="height:300px;"></td></tr>
            <tr>
                <td colspan="2" style="padding:5px;height:20px;background-color:#1279B2;color:#fff;font-size:14px;font-family: 'Oswald', sans-serif;">© <?php echo Lang::get('messages.label_email_for_allrights');?>.</td>
            </tr>
        </table>
        </td>
    </tr>
</table>
</body>
</html>

