<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Trabajo Integrador</title>
</head>
<body>
    <div class="board">
        <header>
            <h1>Diodos Bank</h1><hr>
        </header>
        <form class="menu" action="index.php" method="POST">
            <input type="submit" class="btn" name="click" value="Ingresos">
            <input type="submit" class="btn" name="click" value="Pagos">
            <input type="submit" class="btn" name="click" value="Devoluciones">
            <input type="submit" class="btn" name="click" value="Movimientos">

            <div class="content">
                <?php
                    include("funtions.php");
                    // crear variable de para almacenar los registros
                    $array_movimientos = array();
                    // si existe la variable $array_movimientos, pasarle el valor obtenidos por $_REQUEST
                   if(isset($_REQUEST['array_movimientos'])){
                        $array_movimientos = $_REQUEST['array_movimientos'];
                    }

                    // si el elemento con el nombre click existe, capturar su valor
                    if(isset($_REQUEST['click'])){
                        $click_value = $_REQUEST['click'];
                        switch($click_value){ 
                            // según el valor capturado mostrar una determinada sección del programa
                            case 'Ingresos':
                                Formulario($click_value); // se muestra el formulario dependiendo el valor de $click_value
                                break;
                            case 'Ingresar':
                                // Se guarda el resultado de la validación de los datos ingresados
                                $flag = Validacion($_REQUEST['date'],$_REQUEST['concepto'],$_REQUEST['cantidad']);
                                if($flag){ // si la validacion no es correcta
                                    echo $flag;
                                    Formulario("Ingresos");
                                }else{ // si la validación es correcta
                                    $registro = array( // se guardan los datos solicitados en un array 
                                        'fecha' => $_REQUEST["date"],
                                        'concepto' => $_REQUEST["concepto"],
                                        'cantidad' => $_REQUEST["cantidad"]
                                    );
                                    $array_movimientos[] = $registro; // se almacena el array de registro en el array de movimientos
                                    echo "<h3 class='contable'>¡Ingreso Registrado con Exitoso!</h3>";
                                    Mostrar_Movimientos($array_movimientos, $click_value); // se muestra la tabla de movimientos
                                }
                                break;
                            case 'Pagos':
                                Formulario($click_value);
                                break;
                            case 'Pagar':
                                $flag = Validacion($_REQUEST['date'],$_REQUEST['concepto'],$_REQUEST['cantidad']);
                                if($flag){
                                    echo $flag;
                                    Formulario("Pagos");
                                }else{
                                    $registro = array(
                                        'fecha' => $_REQUEST["date"],
                                        'concepto' => $_REQUEST["concepto"],
                                        'cantidad' => -$_REQUEST["cantidad"]
                                    );
                                    $array_movimientos[] = $registro;
                                    echo "<h3 class='contable'>¡Pago Registrado con Exitoso!</h3>";
                                    Mostrar_Movimientos($array_movimientos, $click_value);
                                }
                                break;
                            case 'Devoluciones':
                                echo "<h3>Devolución de recibos</h3>";
                                Mostrar_devoluciones($array_movimientos); // se muestra la tabla con los valores para devoluciones
                                break;
                            case 'Devolver':
                                echo "<h3>Devolución de recibos</h3>";
                                $array_movimientos = Devolucion($array_movimientos); // se actualiza el array de movimientos sin el registro devuelto 
                                
                                break;
                            case 'Cancelar':
                                Mostrar_devoluciones($array_movimientos);
                                break;
                            case 'Movimientos':
                                echo "<h3>Ultimos 5 movimientos</h3>";
                                Mostrar_Movimientos($array_movimientos, $click_value); 
                                break;
                        }
                    }else{
                        echo "<h2> ¡Bienvenido! </h2>"; 
                    }
                    // se envian los datos actuales del array de movimientos a si mismo
                    foreach ($array_movimientos as $clave => $valor) {
                        echo '<input type="hidden" name="array_movimientos[' . $clave . '][fecha]"     value="' . $valor['fecha'] . '">'; //Fechas
                        echo '<input type="hidden" name="array_movimientos[' . $clave . '][concepto]"  value="' . $valor['concepto'] . '">'; //Conceptos  
                        echo '<input type="hidden" name="array_movimientos[' . $clave . '][cantidad]"  value="' . $valor['cantidad'] . '">'; //Importes
                    }
                ?>
            </div>
        </form>

        <footer>
            <p>Desarrollado por Franco Roldan - 2022</p>
        </footer>

    </div>
</body>
</html>