<?php
session_start();
session_unset();
header("Location: ../../views/homepages/unloged.php");