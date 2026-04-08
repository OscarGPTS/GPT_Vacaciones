<?php

function obtenerImagenAniversario($aniversario)
{
    $imagenes = [
       1 => 'https://res.cloudinary.com/gpt-services/image/upload/v1649789688/aniversario/1_ndetp8.jpg',
       2 => 'https://res.cloudinary.com/gpt-services/image/upload/v1649789688/aniversario/2_oq9mzz.jpg',
       3 => 'https://res.cloudinary.com/gpt-services/image/upload/v1649789688/aniversario/3_ilggl1.jpg',
       4 => 'https://res.cloudinary.com/gpt-services/image/upload/v1649789688/aniversario/4_bb0sbt.jpg',
       5 => 'https://res.cloudinary.com/gpt-services/image/upload/v1649789689/aniversario/5_whfhkp.jpg',
       6 => 'https://res.cloudinary.com/gpt-services/image/upload/v1649789688/aniversario/6_dcgdco.jpg',
       7 => 'https://res.cloudinary.com/gpt-services/image/upload/v1649789690/aniversario/7_lqmhii.jpg',
       8 => 'https://res.cloudinary.com/gpt-services/image/upload/v1649789690/aniversario/8_ceqesa.jpg',
       9 => 'https://res.cloudinary.com/gpt-services/image/upload/v1649789689/aniversario/9_dipweb.jpg',
       10 => 'https://res.cloudinary.com/gpt-services/image/upload/v1649789690/aniversario/10_lrlh9g.jpg',
       11 => 'https://res.cloudinary.com/gpt-services/image/upload/v1649789690/aniversario/11_gzo6oi.jpg',
       12 => 'https://res.cloudinary.com/gpt-services/image/upload/v1649789688/aniversario/12_xastur.jpg',
       13 => 'https://res.cloudinary.com/gpt-services/image/upload/v1649789689/aniversario/13_r5hznr.jpg',
       14 => 'https://res.cloudinary.com/gpt-services/image/upload/v1649789689/aniversario/14_b8glbu.jpg',
       15 => 'https://res.cloudinary.com/gpt-services/image/upload/v1649789689/aniversario/15_ca4d20.jpg'
    ];
    
    return $imagenes[$aniversario];



}
