<?php
setcookie("token", "", time() - 3600, "/");
setcookie("auth_count", 1, time() + 3600, "/"); // 1 час
header("Location: /");
die();