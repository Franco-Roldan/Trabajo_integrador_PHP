<?php

    function Formulario($click){
        if($click == 'Ingresos'){
            $title = "Ingreso de Dinero";
            $btn_value = "Ingresar"; 
        }else{
            $title = "Efectuar Pagos";
            $btn_value = "Pagar";
        }
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
    function Mostrar_Movimientos($Movimientos, $click){
        $saldo = 0;
        $saldo_contables = 0;
        if($click == 'Movimientos'){
            $ultimo_movimiento = (count($Movimientos)-5);
        }else{
            $ultimo_movimiento = 0;
        }
       
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
                        $saldo_contables =  $saldo + intval($registros['cantidad']);
                        if($indice >= $ultimo_movimiento){
                            echo "<tr><td>".$registros['fecha']."</td><td>".$registros['concepto']."</td>";
                            if($registros['cantidad'] > 0){
                                echo "<td class='contable'> $" . number_format($registros['cantidad'], 2, ',', '.') . "</td>";
                            }
                            else{
                                echo "<td class='negativo'> $" . number_format($registros['cantidad'], 2, ',', '.') . "</td>";
                            }
                            if($saldo_contables > 0){
                                echo "<td class='contable'> $" . number_format($saldo_contables, 2, ',', '.') . "</td></tr>";
                            }
                            else{
                                echo "<td class='negativo'> $" . number_format($saldo_contables, 2, ',', '.') . "</td></tr>";
                            }
                        }
                        $saldo += $registros['cantidad'];

                    }
                    if($saldo > 0){
                        echo "<tr><td colspan='3'><b>Saldo Total: </b></td><td class='contable'> $".number_format($saldo, 2, ',', '.')."</td></tr>";
                    }
                    else{
                        echo "<tr><td colspan='3'><b>Saldo Total: </b></td><td class='negativo'> $".number_format($saldo, 2, ',', '.')."</td></tr>";
                    }
                ?>

            </table>
        <?php

    
    }
    function Mostrar_devoluciones($Movimientos){
        $existe_flag = false;

        echo "<table>";
        echo "<tr><th><b>#</b></th><th><b>Fecha</b></th><th><b>Concepto</b></th><th><b>Cantidad</b></th></tr>";

        if(!empty($Movimientos)){
            foreach($Movimientos as $indice => $registros){
                if($registros['cantidad'] < 0){
                    echo "<tr><td><input type='radio' name='indice' value='".$indice."'></td><td>" . $registros['fecha'] . "</td><td>" . $registros['concepto'] . "</td><td class='negativo'>$" . $registros['cantidad'] . "</td></tr>";
                    $existe_flag = TRUE;
                }
            }
            if($existe_flag){
                echo "</table>";
                echo "<br>";
                echo "<div><input type='submit' name='click' class='btn-devolucion' value='Devolver'><input type='submit' name='click' class='btn-devolucion' value='Cancelar'></div>";
            }else{
                echo "<tr><td colspan='4'>No existen registros para visualizar</td></tr></table>";
            }
        }else{
            echo "<tr><td colspan='4'>No existen registros para visualizar</td></tr></table>";
        }
    }
    function Devolucion($Movimientos){
        if(isset($_REQUEST['indice'])){
            $indice_select = $_REQUEST['indice'];
            $new_Movimientos = array();
            foreach($Movimientos as $indice => $registros){
                if($indice != $indice_select){
                    $new_Movimientos[] = $registros;
                }
            }
        }else{
            echo "<h3>Ningun registro fue seleccionado</h3>"; 
            Mostrar_devoluciones($Movimientos);
            return $Movimientos;
        }
        Mostrar_devoluciones($new_Movimientos);
        return $new_Movimientos;
    }
    function Validacion($fecha, $concepto, $cantidad){

        if(empty($fecha) || empty($concepto) || empty($cantidad)){
            return "<h3 class='negativo'>Registro invalido, complete todos los campos</h3>";
        }else{
            if(is_numeric($cantidad)){
                return false;
            }else{
               return "<h3 class='negativo'>Registro invalido, la cantidad debe ser un valor entero </h3>";
            }
        }
    }
    
?>