<?php

$member = new Member($_SESSION['UID']);
$MemberDetails = $member->Details();

?>
<wall:br/>Welcome <?php echo $MemberDetails->FirstName;?>!
