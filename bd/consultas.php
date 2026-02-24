<?php

function eliminarMascotaPorEncargadoBD($pdo,$id,$cedula_empleado)  {
    try {
    
        // Se agrega el filtro de cédula por seguridad: solo el encargado puede borrarla.
        $sql = "DELETE FROM mascotas WHERE id_mascota = ? AND cedula_empleado_encargado = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id, $cedula_empleado]);

    } catch (PDOException $e) {
        die("Error al eliminar el registro: " . $e->getMessage());
    }

    
}

function autenticarEmpleadoBD($pdo,$cedula,$pass_usuario) {

    try {
        // Busca al empleado por su cedula en la base de datos
        $sql = "SELECT * FROM empleados WHERE cedula = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$cedula]);
        $empleado = $stmt->fetch();

        // Verifica si existe el empleado y si la contraseña coincide 
        if ($empleado && password_verify($pass_usuario, $empleado['password'])) {

            // Guardamos datos en la sesión
            $_SESSION['cedula'] = $empleado['cedula'];
            $_SESSION['nombre_completo'] = $empleado['nombre'] . " " . $empleado['apellido'];
            
            header("Location: /adopcioncom/views/dashboard.php"); // Redirige a la página de inicio
            exit();
        } else {

            header("Location: /adopcioncom/views/login.php?msj=" . urlencode("Usuario o contraseña incorrecta"));
            exit();
        }
    } catch (PDOException $e) {
        die("Error en el sistema: " . $e->getMessage());
    }

}

function liberarMascotaDeAsignadoBD($pdo,$id)  {
    try {
        
        $pdo->beginTransaction();

        // Obtenemos los datos de la base de datos de la mascota actual
        $sqlSelect = "SELECT nombre_mascota, especie, edad_meses, genero, estado, peso_g 
                      FROM mascotas WHERE id_mascota = ?";
        $stmtSelect = $pdo->prepare($sqlSelect);
        $stmtSelect->execute([$id]);
        $mascota = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        if ($mascota) {
            // Insertamos en la tabla de mascotas_sin_asignar los datos de la mascota actual
            $sqlInsert = "INSERT INTO mascotas_sin_asignar (nombre_mascota, especie, edad_meses, genero, estado, peso_g) 
                          VALUES (?, ?, ?, ?, ?, ?)";
            $stmtInsert = $pdo->prepare($sqlInsert);
            $stmtInsert->execute([
                $mascota['nombre_mascota'],
                $mascota['especie'],
                $mascota['edad_meses'],
                $mascota['genero'],
                $mascota['estado'],
                $mascota['peso_g']
            ]);

            // Borramos de la tabla original a la mascota actual
            $sqlDelete = "DELETE FROM mascotas WHERE id_mascota = ?";
            $pdo->prepare($sqlDelete)->execute([$id]);

            $pdo->commit();
        } else {
            echo "La mascota no existe.";
        }

    } catch (Exception $e) {
        // Si algo sale mal, deshace todo para no perder los datos 
        $pdo->rollBack();
        echo "Error al mover la mascota: " . $e->getMessage();
    }
}

function eliminarDeSinCuidadorBD($pdo,$id) {
    try {
    // Borra de la tabla original la mascota sin asignar
    $sqlDelete = "DELETE FROM mascotas_sin_asignar WHERE id_mascotas_sin_asignar = ?";
    $resultado = $pdo->prepare($sqlDelete)->execute([$id]);

       if (!$resultado) {
       throw new Exception("No se pudo eliminar la mascota establecida.");
    }

    $pdo->commit();

    } catch (Exception $e) {

        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

    }
}

function asignarMascotaAEmpleadoBD($pdo,$id,$cedula) {
    try {
        
        $pdo->beginTransaction();

        // Se obtiene los datos de la mascota actual
        $sqlSelect = "SELECT nombre_mascota, especie, edad_meses, genero, estado, peso_g 
                      FROM mascotas_sin_asignar WHERE id_mascotas_sin_asignar = ?";
        $stmtSelect = $pdo->prepare($sqlSelect);
        $stmtSelect->execute([$id]);
        $mascota = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        // Cuenta cuantas mascotas tiene asignadas el cuidador en la tabla final
        $sqlCount = "SELECT COUNT(*) FROM mascotas WHERE cedula_empleado_encargado = ?";
        $stmtCount = $pdo->prepare($sqlCount);
        $stmtCount->execute([$cedula]);
        $totalAsignadas = $stmtCount->fetchColumn();

        if ($totalAsignadas >= 5) {
            // Si ya tiene 5, cancela la transaccion y redirige
            $pdo->rollBack();
            header("Location: /adopcioncom/views/mascotas_lista_sin_cuidador.php?msj=" . urlencode("El cuidador ya tiene 5 mascotas (límite alcanzado)."));
            exit();
        }

        if ($mascota) {
            // Inserta en la tabla de mascotas_sin_asignar
            $sqlInsert = "INSERT INTO mascotas (nombre_mascota, especie, edad_meses, genero, estado, peso_g, cedula_empleado_encargado) 
                          VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmtInsert = $pdo->prepare($sqlInsert);
            $stmtInsert->execute([
                $mascota['nombre_mascota'],
                $mascota['especie'],
                $mascota['edad_meses'],
                $mascota['genero'],
                $mascota['estado'],
                $mascota['peso_g'],
                $cedula
            ]);

            // Borra de la tabla original
            $sqlDelete = "DELETE FROM mascotas_sin_asignar WHERE id_mascotas_sin_asignar = ?";
            $pdo->prepare($sqlDelete)->execute([$id]);

            $pdo->commit();
            echo "Mascota Asigna con éxito.";
        } else {

            $pdo->rollBack();
            // Redirige con un mensaje de error
            header("Location: /adopcioncom/views/mascotas_lista_sin_cuidador.php?msj=" . urlencode("La mascota no existe o ya fue asignada"));
            exit();
        }

    } catch (Exception $e) {
        // Si algo sale mal, deshace todo para no perder la informacion
        $pdo->rollBack();
        echo "Error al mover la mascota: " . $e->getMessage();
    }
}

function registrarEmpleadoBD($pdo,$nombre, $apellido, $cedula, $password_encriptada, $fecha_actual)  {
    try {
        // Inserta los datos del empleado
        $sql = "INSERT INTO empleados (nombre, apellido, cedula, password, fecha_contratacion ) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nombre, $apellido, $cedula, $password_encriptada, $fecha_actual]);

       
    } catch (PDOException $e) {
       
        if ($e->getCode() == 23000) {
            echo "Error: La cédula ya se encuentra registrada.";
        } else {
            echo "Error en el registro: " . $e->getMessage();
        }
    }
}

function registrarMascotaConValidacionBD($pdo,$emp_id,$estado,$nombre_mascota,$especie, $edad, $genero, $peso){
    try {
        
        if ($estado === 'En tratamiento') {
            $sql_check = "SELECT COUNT(*) FROM mascotas WHERE cedula_empleado_encargado = ? AND estado = 'En tratamiento'";
            $stmt_check = $pdo->prepare($sql_check);
            $stmt_check->execute([$emp_id]);
            $conteo = $stmt_check->fetchColumn();

            if ($conteo >= 3) {
                   header("Location: /adopcioncom/views/mascotas_lista_sin_cuidador.php?msj=" . urlencode("Error: No puedes tener más de 3 mascotas en tratamiento simultáneamente por salud laboral."));
                    exit();

                }
                
        }

        // Insertar datos de la mascota
        $sql = "INSERT INTO mascotas_sin_asignar (nombre_mascota, especie, edad_meses, genero, estado, peso_g) VALUES (?, ?, ?, ?, ?, ?)";
        $pdo->prepare($sql)->execute([$nombre_mascota,$especie, $edad, $genero, $estado, $peso]);
        header("Location: /adopcioncom/views/mascotas_lista_sin_cuidador.php?msj=Mascota registrada");
        
    } catch (PDOException $e) {
        die("Error al guardar: " . $e->getMessage());
    }
    
}

function actualizarMascotaConProtocoloBD($pdo,$nombre, $especie, $edad, $genero, $estado, $peso, $id)  {
    try {
  
        // Actualiza los datos de la mascota en la base de datos
        $sql = "UPDATE mascotas SET 
                nombre_mascota = ?, especie = ?, edad_meses = ?, 
                genero = ?, estado = ?, peso_g = ? 
                WHERE id_mascota = ?";
        
        $pdo->prepare($sql)->execute([$nombre, $especie, $edad, $genero, $estado, $peso, $id]);
        
        header("Location: /adopcioncom/views/mis_mascotas.php?msj=Actualizado correctamente");
        exit();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

function editarMascotaSinAsignar($pdo,$nombre, $especie, $edad, $genero, $estado, $peso, $id)  {
    try {
       
        // Actualiza los datos de la mascota en la base de datos
        $sql = "UPDATE mascotas_sin_asignar SET 
                nombre_mascota = ?, especie = ?, edad_meses = ?, 
                genero = ?, estado = ?, peso_g = ? 
                WHERE id_mascotas_sin_asignar = ?";
        
        $pdo->prepare($sql)->execute([$nombre, $especie, $edad, $genero, $estado, $peso, $id]);
        
        header("Location: /adopcioncom/views/mascotas_lista_sin_cuidador.php?msj=Actualizado correctamente");
        exit();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

function BuscarCuidadorXidMascota($pdo,$id_buscado,$cedula_cuidador)  {
    try {
    // Se busca en la base de datos al cuidador mediante al id de mascota para ubicar la cedula vinculada
    $sql = "SELECT * FROM mascotas 
            WHERE id_mascota = ? 
            AND cedula_empleado_encargado = ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_buscado, $cedula_cuidador]);

    if ($stmt->rowCount() > 0) {
        return true;
    } 
    else {
        return false;
    } 

    } catch (PDOException $e) {
        echo "Error en la consulta: " . $e->getMessage();
    }
    
}



























?>  