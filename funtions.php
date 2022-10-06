<?php
    // -------- FUNCIONES ------
    // función para mostrar el formulario segun si estamos en la sección de ingresos o pagos.
    function Formulario($click){
        if($click == 'Ingresos'){
            $title = "Ingreso de Dinero"; // titulo del formulario
            $btn_value = "Ingresar";  // texto del boton
        }else{
            $title = "Efectuar Pagos";
            $btn_value = "Pagar";
        }
        // formulario
        ?>
            <div class="form">
                <h3><?php echo $title ?></h3>
                <label for="date">Fecha: </label><input type="date" name="date"><br>
                <label for="concepto">Concepto: </label><input type="text" name="concepto"><br>
                <label for="cantidad">Cantidad: </label><input type="text" name="cantidad"><br>
                <input type="submit" name="click" class='btn-devolucion' value="<?php echo $btn_value ?>">
            </div>
        <?php

    }

    // Función para mostrar los movimientos, se pide el array de movimientos y valor click que nos permite saber en qué sección nos encontramos
    function Mostrar_Movimientos($Movimientos, $click){
        $saldo = 0;
        $saldo_contables = 0;
        if($click == 'Movimientos'){ // si nos encontramos dentro de movimientos que solo se visualicen los últimos 5 movimientos
            $ultimo_movimiento = (count($Movimientos)-5);
        }else{
            $ultimo_movimiento = 0; // de lo contrario, que se visualice todo
        }
        // tabla
        ?>
            <table>
                <tr>
                    <th><b>Fecha</b></th>
                    <th><b>Concepto</b></th>
                    <th><b>Cantidad</b></th>
                    <th><b>Salgo Contable</b></th>
                </tr>
                <?php
                    foreach($Movimientos as $indice => $registros){
                        $saldo_contables =  $saldo + intval($registros['cantidad']); // el saldo contable es igual a la saldo actual más el nuevo ingreso o menos el nuevo pago
                        if($indice >= $ultimo_movimiento){ // solo si el índice es mayor o igual que la varibale ultimo_movimiento se muestra el registro en la tabla
                            echo "<tr><td>".$registros['fecha']."</td><td>".$registros['concepto']."</td>";
                            if($registros['cantidad'] > 0){
                                echo "<td class='contable'> $" . number_format($registros['cantidad'], 2, ',', '.') . "</td>";
                            }
                            else{
                                echo "<td class='negativo'> $" . number_format($registros['cantidad'], 2, ',', '.') . "</td>";
                            }
                            if($saldo_contables > 0){ // Saldo Contable positivo
                                echo "<td class='contable'> $" . number_format($saldo_contables, 2, ',', '.') . "</td></tr>";
                            }
                            else{ // Saldo Contable negativo
                                echo "<td class='negativo'> $" . number_format($saldo_contables, 2, ',', '.') . "</td></tr>";
                            }
                        }
                        $saldo += $registros['cantidad'];

                    }
                    if($saldo > 0){ // saldo positivo
                        echo "<tr><td colspan='3'><b>Saldo Total: </b></td><td class='contable'> $".number_format($saldo, 2, ',', '.')."</td></tr>";
                    }
                    else{ // saldo negativo
                        echo "<tr><td colspan='3'><b>Saldo Total: </b></td><td class='negativo'> $".number_format($saldo, 2, ',', '.')."</td></tr>";
                    }
                ?>

            </table>
        <?php

    
    }

    // función para mostrar solo los registros que tengan valor negativo y se puedan devolver
    function Mostrar_devoluciones($Movimientos){
        $existe_flag = false; // se crea una variable controlador para saber si existen o no registros para devolver

        echo "<table>";
        echo "<tr><th><b>#</b></th><th><b>Fecha</b></th><th><b>Concepto</b></th><th><b>Cantidad</b></th></tr>";

        if(!empty($Movimientos)){ // si el array de movimientos no está vacío, se muestran
            foreach($Movimientos as $indice => $registros){
                if($registros['cantidad'] < 0){
                    echo "<tr><td><input type='radio' name='indice' value='".$indice."'></td><td>" . $registros['fecha'] . "</td><td>" . $registros['concepto'] . "</td><td class='negativo'>$" . $registros['cantidad'] . "</td></tr>";
                    $existe_flag = TRUE; // cambiamos el estado del controlador
                }
            }
            if($existe_flag){  // visualizamos los botones de devolver y cancelar
                echo "</table>";
                echo "<br>";
                echo "<div><input type='submit' name='click' class='btn-devolucion' value='Devolver'><input type='submit' name='click' class='btn-devolucion' value='Cancelar'></div>";
            }else{ // de lo contrario, mostramos el siguiente mensaje
                echo "<tr><td colspan='4'>No existen registros para visualizar</td></tr></table>";
            }
        }else{
            echo "<tr><td colspan='4'>No existen registros para visualizar</td></tr></table>";
        }
    }

    // función para devolver un pago
    function Devolucion($Movimientos){
        if(isset($_REQUEST['indice'])){ // si la variable índice existe (definida cuando mostramos los registros)
            $indice_select = $_REQUEST['indice']; // se guanda su valor
            $new_Movimientos = array();  // variable para guardar el nuevo array resultante
            foreach($Movimientos as $indice => $registros){
                if($indice != $indice_select){
                    $new_Movimientos[] = $registros;
                }
            }
        }else{ // de lo contrario se notifica que no se a seleccionado ningún registro
            echo "<h3>Ningun registro fue seleccionado</h3>"; 
            Mostrar_devoluciones($Movimientos); // se muestra la tabla de devoluciones sin cambios
            return $Movimientos; // se retorna el array de entrada sin modificaciones 
        }
        Mostrar_devoluciones($new_Movimientos); // se muestra la tabla de devoluciones con los cambios
        return $new_Movimientos; // se retorna el array modificado
    }

    // función para validar los datos solicitados.
    function Validacion($fecha, $concepto, $cantidad){

        if(empty($fecha) || empty($concepto) || empty($cantidad)){ // si no se ingreso alguno de los datos
            return "<h3 class='negativo'>Registro invalido, complete todos los campos</h3>";
        }else{ // si el valor del campo cantidad es un número, devolver false y dar por validados correctamente los campos
            if(is_numeric($cantidad)){
                return false;
            }else{ // de lo contrario, notificarlo
               return "<h3 class='negativo'>Registro invalido, la cantidad debe ser un valor entero </h3>";
            }
        }
    }
    
?>