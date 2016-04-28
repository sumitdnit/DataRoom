<!DOCTYPE html>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title><?php echo Lang::get('messages.msg_invite_for_projectroom');?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Quattrocento+Sans' rel='stylesheet' type='text/css'>
</head>
<body style="margin:0;padding:0;">
<table border="0" cellpadding="0" cellspacing="0" width="100%" >
    <tr>
        <td>
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="800" style="border-collapse: collapse;border:1px solid #FF9300;">
            <tr>
            <td bgcolor="FF9300" width="300">
                <img style="width:300px;" src="{{URL::asset('assets/images/RaVaBe_Email.png')}}" alt="RaVaBe, Just one click and you may enjoy your coffee."/>
            </td>
            <td width="500" bgcolor="FF9300" style="padding-left:10px;">
                <h2 style="text-transform:uppercase;color:#fff;font-family: 'Oswald', sans-serif;"><?php echo Lang::get('messages.label_user_name');?> : - {{$username}} </h2>
				<h4 style="text-transform:color:#fff;font-family: 'Oswald', sans-serif;"><?php echo Lang::get('messages.label_password');?> : - 'Pass@123' </h2>
                <h4 style="color:#fff;font-family: 'Quattrocento Sans', sans-serif;"><?php echo Lang::get('messages.msg_email_content');?></h4>
            </td>
            </tr>
            <tr>
                <td colspan="2" style="padding:5px;color:#757575;padding-top:30px;font-family: 'Quattrocento Sans', sans-serif;"><?php echo Lang::get('messages.msg_to_invite_access_project');?></td>
            </tr>
            <tr>
                <td colspan="2" style="padding:5px;"><a href="{{$email_action_url}}" style="font-family: 'Oswald', sans-serif;background-color:#FF9300;color:#fff;padding:5px;border:1px solid #fff;border-radius:4px;font-weight:normal;text-decoration:none;width:100px;display:block;text-align:center;" onMouseOver="this.style.backgroundColor ='#fff';this.style.color ='#FF9300';this.style.borderColor ='#FF9300';" onMouseOut="this.style.backgroundColor ='#FF9300';this.style.color ='#fff';this.style.borderColor ='#fff';">{{$email_action_text}}</a></td>
            </tr>
            <tr><td colspan="2" style="height:300px;"></td></tr>
            <tr>
                <td colspan="2" style="padding:5px;height:20px;background-color:#FF9300;color:#fff;font-size:14px;font-family: 'Oswald', sans-serif;">© <?php echo Lang::get('messages.label_email_for_allrights');?>.</td>
            </tr>
        </table>
        </td>
    </tr>
</table>
</body>
</html>

