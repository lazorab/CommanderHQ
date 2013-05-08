<script type="text/javascript">
$('#back').html('<img alt="Back" onclick="OpenThisPage(\'<?php echo $_SERVER ['HTTP_REFERER'];?>\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 

function Continue()
{
    $.ajax({url:'ajax.php?module=terms&action=validateform',data:$("#terms").serialize(),dataType:"html",success:messagedisplay});  
}

function messagedisplay(message)
{
    if(message.length > 2)
         alert(message);
    else    
         window.location = '?module=memberhome'; 
}

</script>
<br/>

<div id="AjaxOutput">

<h2>TERMS AND CONDITIONS OF SUBSCRIPTION</h2>
<p>All references to "the Company"", "we", "us" and "our" in these terms and conditions are deemed to refer to Cellular Media Distribution CC, registration number 2008/232596/23, a limited liability company incorporated in the Republic of South Africa and having its registered postal address at PO Box 2167, Sun Valley, Cape Town, Western Cape, South Africa 7985.</p><p>
All references to "you" and "your" are deemed to refer to any user and/or visitor of www.commanderhq.net, www.commanderhq.biz, www.commanderhq.info, www.commanderhq.mobi, www.commanderhq.org, and other related URLs, mobile web applications and/or native applications (iOS, Android, Windows or Blackberry) ("Websites"). </p><p>
These Terms and Conditions of Subscription govern the subscription by you to the communications issued by the Websites and are in addition to the terms and conditions of use of the Websites, which can be viewed <a href="?module=websitesterms">here</a>. </p><p>
Once you tick the box labeled "I accept", these Terms and Conditions of Subscription form a legally-binding agreement between you and the Company.  You may contact us via email to [subscriptions@commanderHQ.net] to obtain a full record of your transaction.  We will in any event confirm your subscription and your details via email or mobile communication.</p><p>
The Company will provide to you the communications you select in return for your payment.  To subscribe, please complete the form below.</p><p>
[●Drafting note: insert template order form e.g. name and surname, address, description of goods, credit card details, etc]</p><p>
Payment can be made via the Websites using a credit card or PayPal.  Once you accept these Terms and Conditions of Subscription, you will be directed to a link to a secure site for payment of the subscription fee. </p><p>
We take the security of your payment and personal information seriously.  In this regard, we  [● insert description of the nature of the security measures taken, as section 43(1)(p) of the ECT Act requires that these measures be stated]. Paypal will be our payment gateway, is it ok to refer the user to their T&C’s?</p><p>
All personal information that you provide to us is subject to our Privacy Policy, which can be viewed by clicking <a href="?module=policy">here</a>. However, due to the nature of the Internet, we cannot guarantee that your communications will be free from unauthorised access by third parties.  Accordingly, WE WILL NOT BE LIABLE FOR ANY LOSS OR DAMAGES ARISING FROM THIRD PARTIES' UNAUTHORISED ACCESS OF YOUR DATA. </p><p>
Should you wish to suspend or cancel your subscription to the Service, you may send us an email with the words "Suspend CommanderHQ subscription" in the subject line to <a href="mailto:stop@commanderhq.net?Subject=Suspend%20CommanderHQ%20subscription">stop@commanderhq.net</a>.  Your cancellation will be effected within 30 days after you have notified us of your cancellation.</p><p>
If any party ("Defaulting Party") breaches any of these terms and conditions and fails to remedy such breach within 14 (fourteen) days of receipt of notice to remedy the breach, the aggrieved party shall be entitled to claim specific performance or to cancel this agreement forthwith upon written notice to the defaulting party, without prejudice to its right to recover:</p><p>
1.1 any amounts that may be due to it in terms of this agreement; and</p><p>
1.2 any loss or damage suffered as a consequence of the breach or the cancellation of this agreement.</p><p>
Our relationship and/or any dispute arising from or in connection with these terms and conditions of sale shall be governed by the laws of the Republic of South Africa.  You agree to be subject to the exclusive jurisdiction of the South African courts.</p><p>
The Company hereby selects the address set out above as its address for the service of all formal notices and legal processes in connection with these terms and conditions of sale ("domicilium").  You hereby select the address specified on the Goods purchase page as your domicilium.  Either party may change its domicilium to any other physical address by not less than 7 days' notice in writing to the other party.  Notices must be sent either by hand, prepaid registered post, telefax or email and must be in English.  All notices sent – </p><p>
1.3 by hand will be deemed to have been received on the date of delivery;</p><p>
1.4 by prepaid registered post, will be deemed to have been received 10 days after the date of posting;</p><p>
1.5 by telefax before 16h30 on a business day will be deemed to have been received, on the date of successful transmission of the telefax.  All telefaxes sent after 16h30 or on a day which is not a business day will be deemed to have been received on the following business day; and</p><p>
1.6 by email will be deemed to have been  on the date indicated in the "Read Receipt" notification.  ALL EMAIL COMMUNICATIONS BETWEEN YOU AND US MUST MAKE USE OF THE "READ RECEIPT" FUNCTION to serve as proof that an email has been received.</p><p>
You may not cede, assign or otherwise transfer your rights and obligations in terms of these terms and conditions to any third party.</p><p>
Any failure on the part of you or the Company to enforce any right in terms hereof shall not constitute a waiver of that right.</p><p>
If any term or condition contained herein is declared invalid, the remaining terms and conditions will remain in full force and effect.  </p><p>
No variation, addition, deletion, or agreed cancellation of these terms and conditions will be of any force or effect unless in writing and accepted by or on behalf of the parties hereto.</p><p>
No indulgence, extension of time, relaxation or latitude which any party ("the grantor") may show grant or allow to the other ("the grantee") shall constitute a waiver by the grantor of any of the grantor's rights and the grantor shall not thereby be prejudiced or stopped from exercising any of its rights against the grantee which may have arisen in the past or which might arise in the future. </p><p>
These terms and conditions contain the whole agreement between you and the Company relating to the subject matter hereof and no other warranty or undertaking is valid, unless contained in this document between the parties. </p>
    
<form action="index.php" id="terms">
    <input data-role="none" id="checkbox-1" type="checkbox" name="TermsAccepted" value="yes"/>
    <label for="checkbox-1">I have read and agree to Terms and Conditions</label>
<br/><br/>           
<input class="buttongroup" type="button" onClick="Continue();" value="Continue"/>
</form><br/><br/>
</div>
<div class="clear"></div>