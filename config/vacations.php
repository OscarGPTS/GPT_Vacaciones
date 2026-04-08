<?php

return [
    
    /*
    |--------------------------------------------------------------------------
    | IDs de Usuarios de Recursos Humanos
    |--------------------------------------------------------------------------
    |
    | Lista de IDs de usuarios que recibirán notificaciones de Recursos Humanos
    | para solicitudes de vacaciones que requieren aprobación final.
    |
    */
    'rh_user_ids' => [
        123, // Usuario principal de RH
        // Agregar más IDs según sea necesario
    ],

    /*
    |--------------------------------------------------------------------------
    | IDs de Usuarios de Dirección
    |--------------------------------------------------------------------------
    |
    | Lista de IDs de usuarios que recibirán notificaciones de Dirección
    | para solicitudes de vacaciones que requieren aprobación intermedia
    | (después de jefe directo, antes de RH).
    |
    */
    'direction_user_ids' => [
        // Agregar IDs de usuarios de Dirección aquí
        // Ejemplo: 456, 789
    ],

];
