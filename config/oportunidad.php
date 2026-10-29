<?php

return [

    /*
    | Correos con acceso al panel de administración de empleos.
    | Se definen en el archivo .env, separados por comas:
    | ADMIN_EMAILS=uno@correo.com,otro@correo.com
    */
    'admin_emails' => array_values(array_filter(array_map(
        fn ($correo) => strtolower(trim($correo)),
        explode(',', (string) env('ADMIN_EMAILS', ''))
    ))),

];
