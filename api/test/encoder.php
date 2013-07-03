<?php

$digest = base64_encode(sha1("f617ee2803ddd625"."2013-04-30T06:42:09Z"."adminpass", true));

echo $digest;