<?php

require_once '../bd/consultas.php'; // Para importar las funciones
require_once '../bd/conexion.php'; // Para conectarse a la base de datos

function validarLogin($cedula, $pass_usuario )   {
   
    // Validación de cedula
    $cedula_valida = preg_match('/^[0-9]{6,8}$/', $cedula);

    // Validación de contraseña
    $pass_valido = preg_match('/^(?=.*[A-Z])(?=.*\d).{8,40}$/', $pass_usuario);

    if ($cedula_valida && $pass_valido) {
        return true;
    } else {
        return false;

    }
}

function validarRegistroEmpleado($nombre, $apellido, $cedula, $pass1, $pass2  ) {

    // Validacion de nombre y apellido (letras, espacios y tildes, 2-50 caracteres)
    $reg_nombres = '/^[a-zA-ZÁéíóúÁÉÍÓÚñÑ ]{2,50}$/';
    $nombre_valido = preg_match($reg_nombres, $nombre);
    $apellido_valido = preg_match($reg_nombres, $apellido);

    // Validacion de cedula (solo números, entre 6 y 8 dígitos)
    $cedula_valida = preg_match('/^[0-9]{6,8}$/', $cedula);

    // Validacion de contraseña (minimo 8 caracteres, una mayúscula y un número)
    $reg_pass = '/^(?=.*[A-Z])(?=.*\d).{8,40}$/';
    $pass1_valido = preg_match($reg_pass, $pass1);

    // Verificacion de coincidencia de contraseñas
    $pass_coinciden = ($pass1 === $pass2);

    if ($nombre_valido && $apellido_valido && $cedula_valida && $pass1_valido && $pass_coinciden) {
        return true;
    } else {
        return false;
    }
    
}

function validarCreacionDeMascotasSinAsignar($nombre_mascota, $especie, $edad, $genero, $estado, $peso) {
    // Nombre de la mascota: Letras, espacios y tildes (2-30 caracteres)
    $nombre_valido = preg_match('/^[a-zA-ZÁéíóúÁÉÍÓÚñÑ ]{2,30}$/', $nombre_mascota);

    // Especie: Solo letras (ej: Perro, Gato, Ave)
    $especie_valida = preg_match('/^[a-zA-ZÁéíóúÁÉÍÓÚñÑ]{3,20}$/', $especie);

    // Edad (en meses): Solo números, máximo 3 dígitos (hasta 999 meses)
    $edad_valida = preg_match('/^[0-9]{1,3}$/', $edad);

    // Genero: Valida que sea 'Macho' o 'Hembra'
    $genero_valido = preg_match('/^(Macho|Hembra)$/i', $genero);

    // Estado: 'disponible' o 'en tratamiento'
    $estado_valido = preg_match('/^(disponible|en tratamiento)$/i', $estado);

    // Peso (en gramos): Solo números, entre 1 y 5 dígitos 
    $peso_valido = preg_match('/^[0-9]{1,5}$/', $peso);

    // Validación General
    if ($nombre_valido && $especie_valida && $edad_valida && $genero_valido && $estado_valido && $peso_valido) {
       
        return true;
    } else {
        return false;
    }
    
}

function validarEditarMisMacotas($id, $nombre, $especie, $edad, $genero, $estado, $peso) {

    // Id: Solo numeros de 1 a 10 dígitos
    $id_valido = preg_match('/^[1-9][0-9]{0,9}$/', $id);
    // Nombre de la mascota: Letras, espacios y tildes (2-30 caracteres)
    $nombre_valido = preg_match('/^[a-zA-ZÁéíóúÁÉÍÓÚñÑ ]{2,30}$/', $nombre);

    // Especie: Solo letras (ej: Perro, Gato, Ave)
    $especie_valida = preg_match('/^[a-zA-ZÁéíóúÁÉÍÓÚñÑ]{3,20}$/', $especie);

    // Edad (en meses): Solo números, máximo 3 dígitos (hasta 999 meses)
    $edad_valida = preg_match('/^[0-9]{1,3}$/', $edad);

    // Valida que sea 'Macho' o 'Hembra'
    $genero_valido = preg_match('/^(Macho|Hembra)$/i', $genero);

    // Estado:'disponible' o 'en tratamiento'
    $estado_valido = preg_match('/^(disponible|en tratamiento)$/i', $estado);

    // Peso (en gramos): Solo números, entre 1 y 5 dígitos 
    $peso_valido = preg_match('/^[0-9]{1,5}$/', $peso);

    if ($id_valido && $nombre_valido && $especie_valida && $edad_valida && $genero_valido && $estado_valido && $peso_valido) {
        
        return true;
    } else {
        return false;
    }
    
}

function validarEditarMacotasSinAsignar($id, $nombre, $especie, $edad, $genero, $estado, $peso) {

    // Id: Solo numeros de 1 a 10 dígitos
    $id_valido = preg_match('/^[1-9][0-9]{0,9}$/', $id);

    // Nombre mascota: Letras, espacios y tildes (2-30 caracteres)
    $nombre_valido = preg_match('/^[a-zA-ZÁéíóúÁÉÍÓÚñÑ ]{2,30}$/', $nombre);

    // Especie: Solo letras (ej: Perro, Gato, Ave)
    $especie_valida = preg_match('/^[a-zA-ZÁéíóúÁÉÍÓÚñÑ]{3,20}$/', $especie);

    // Edad (en meses): Solo números, máximo 3 dígitos (hasta 999 meses)
    $edad_valida = preg_match('/^[0-9]{1,3}$/', $edad);

    // Genero: Valida que sea 'Macho' o 'Hembra'
    $genero_valido = preg_match('/^(Macho|Hembra)$/i', $genero);

    // Estado:'disponible' o 'en tratamiento'
    $estado_valido = preg_match('/^(disponible|en tratamiento)$/i', $estado);

    // Peso (en gramos): Solo números, entre 1 y 5 dígitos 
    $peso_valido = preg_match('/^[0-9]{1,5}$/', $peso);

    if ($id_valido && $nombre_valido && $especie_valida && $edad_valida && $genero_valido && $estado_valido && $peso_valido) {
  
        return true;
    } else {
     
        return false;
    }
    
}

function EliminarMascotaValidarCuidador($pdo,$id,$cedula)  {

    // Solo números de 1 a 10 dígitos
    $id_valido = preg_match('/^[1-9][0-9]{0,9}$/', $id) ;

    if ($id_valido) {
        if (BuscarCuidadorXidMascota($pdo,$id,$cedula)==true) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
 
}

function ValidarIdMascota($id)  {
    // Solo números de 1 a 10 dígitos
    $id_valido = preg_match('/^[1-9][0-9]{0,9}$/', $id) ;
    

    if ($id_valido) {
            return true;
        } 
        else {
            return false;
        }
}
?>