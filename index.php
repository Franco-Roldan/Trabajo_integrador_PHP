<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>CRUD PHP</title>
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

                   if(isset($_REQUEST['array_movimientos'])){
                        $array_movimientos = $_REQUEST['array_movimientos'];
                    }

                    // si el elemento con el nombre click existe, capturar su valor
                    if(isset($_REQUEST['click'])){
                        $click_value = $_REQUEST['click'];
                        switch($click_value){ 
                            // segun el valor capturado mostrar una determinada sección del programa
                            case 'Ingresos':
                                Formulario($click_value);
                                break;
                            case 'Ingresar':
                                $flag = Validacion($_REQUEST['date'],$_REQUEST['concepto'],$_REQUEST['cantidad']);
                                if($flag){
                                    echo $flag;
                                    Formulario("Ingresos");
                                }else{
                                    $registro = array(
                                        'fecha' => $_REQUEST["date"],
                                        'concepto' => $_REQUEST["concepto"],
                                        'cantidad' => $_REQUEST["cantidad"]
                                    );
                                    $array_movimientos[] = $registro;
                                    echo "<h3 class='contable'>¡Ingreso Registrado con Exitoso!</h3>";
                                    Mostrar_Movimientos($array_movimientos, $click_value);
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
                                Mostrar_devoluciones($array_movimientos);
                                break;
                            case 'Devolver':
                                echo "<h3>Devolución de recibos</h3>";
                                $array_movimientos = Devolucion($array_movimientos);
                                
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