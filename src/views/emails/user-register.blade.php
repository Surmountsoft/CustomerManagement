{{--
  |  Client register Email Template
  |
  |  @package resources/views/admin/emails/User-register
  |
  |  @author Mohit.kumar <mohit.kumar@surmountsoft.in>
  |
  |  @copyright 2020 SurmountSoft Pvt. Ltd. All rights reserved.
  |
--}}

<html>
 <body> 
 <div bgcolor="#F3F3F3" style="background-color:#f3f3f3"> 
 <table width="650" bgcolor="#FFFFFF" border="0" align="center" cellpadding="0" cellspacing="0" style="color:#000;font-family:Lato,Helvetica Neue,Helvetica,Arial,sans-serif;">
  <tbody>
   <tr> 
   <td height="30" bgcolor="#F3F3F3"></td>
   </tr>
   <tr>
    <td height="102" align="center" style="border-bottom:1px solid #EAEAEA;"> 
    <img src="{{ asset('assets/admin/global_assets/images/neworganic.png') }}" alt="logo" class="logo-wrapper " style="width: 310px;height: auto;"> </td>
    </tr>
    <tr> 
    <td valign="top"> 
    <table width="100%" border="0" cellpadding="30" cellspacing="0" style="font-size:14px"> 
    <tbody> 
    <tr> 
    <td>
     <div> 
     <p style="color:#333;font-size:14px">Hi {{ ucwords ($data['name'] )}},</p>
     <div style="color:#333;font-size:14px"> 
     <p style="color:#333;font-size:14px">@lang('messages.register_body_header') </p><br>
    <br>
    <b style="color:#333;font-size:14px">@lang('views.email'): </b>{{$data['email']}}<br>
    <b style="color:#333;font-size:14px">@lang('views.password'): </b>{{ $data['password']}}
    <br>
    <p style="color:#333;font-size:14px">@lang('views.thanks') 
    <br> @lang('views.organic_b2b_system')</p>
     </div>
     </div>
     </td>
     </tr>
     </tbody> 
     </table> 
     </td>
     </tr>
     <tr> 
     <td height="40" align="center" valign="bottom" style="font-size:12px;color:#999"> @lang('messages.copyright')  </td>
     </tr>
     <tr> 
     <td height="30"></td>
     </tr>
     <tr> 
     <td height="30" bgcolor="#F3F3F3"></td>
     </tr>
     </tbody> 
     </table> 
     </div>
     </body>
     </html> 

