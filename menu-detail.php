<?php
// Keep links to the root detail page working.
$query = http_build_query($_GET);
header('Location: Pages/menu-detail.php' . ($query !== '' ? '?' . $query : ''));
exit;
