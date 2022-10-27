<?php

return [
    "path" => "../storage/logs/",
    "file" => 'laravel-route-logger.log',
    "format" => "status_message status client_ip method path_info error_message {'request':[],'response': []} execution_time auth_id user_agent now\n"
];
