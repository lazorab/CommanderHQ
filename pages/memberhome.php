<?php

$member = new Member($_SESSION['UID']);
$MemberDetails = $member->Details();

?>
<wall:br/>
<wall:br/>
Welcome <?php echo $MemberDetails->FirstName;?>!
<wall:br/>
<wall:br/>
Please select from menu.