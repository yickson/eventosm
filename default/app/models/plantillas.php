<?php

/**
 *
 */
class Plantillas
{
  public function usuario($compra, $usuario)
  {
    $conf = (New Configuracion)->find(1);
    $contenido = '<table max-width="800" cellpadding="0" cellspacing="0" align="center">
      <tr>
        <td height="80" align="left" valign="middle" bgcolor="ffffff" style="font-family:Arial, Helvetica, sans-serif; color:#ffffff;">
          <div style="font-size:15px;">
            <b></b>
          </div>
          <div style="font-size:30px;">
            <b><img src="http://serviciosm.cl/img/smlogomin2.jpg" width="80" height="80" style="display:block;"></b>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <table width="650" cellpadding="0" cellspacing="0" align="center">
            <tr>
              <td width="650">
                <h2 align="center">Orden de compra</h2>
                <p></p>
              </td>
            </tr>
          </table>
          </td>
          <!-- 2 column layout with 10px spacing -->
          </tr>
          <tr>
          <td>
            <table width="650" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <th width="325">
                  <h2>Método de pago</h2>
                </th>
                <th width="325">
                  <h2>Envío y dirección</h2>
                </th>
              </tr>
              <tr>
                <td width="295" align="center">Pago electrónico</td>
                <td width="295">
                  <p>Nombre: <b>'.$usuario->nombre.'</b></p>
                </td>
              </tr>
            </table>
          </td>
          </tr>
          <br><br>
          <!-- 4 column layout with 0px spacing -->
          <tr>
          <td>
              <table width="650" cellpadding="0" cellspacing="0" align="center" border="1" style="font-family:Arial, Helvetica, sans-serif;">
              <!-- Aquí se encuentra el bucle del los pedidos -->
              <tr>
                <th>Evento</th>
                <th>Orden de compra</th>
                <th>Cantidad de entradas</th>
                <th>Precio</th>
              </tr>
              <tr>
                <td>'.$conf->nombre.'</td>
                <td>'.$compra->numero_compra.'</td>
                <td>'.$usuario->cantidad.'</td>
                <td>'.$compra->monto.'</td>
              </tr>
              </table>
          </td>
          </tr>
          <!-- 1 column layout with 0px spacing -->
          <tr>
          <table width="650" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center" valign="middle" style="padding-bottom:5px;">
                  <img src="http://serviciosm.cl/img/divider.gif" width="650" height="28">
                </td>
            </tr>
          </table>
          </tr>
          <tr>
          <td>
            <table width="650" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td width="650">
                  <p>¿Tiene alguna duda?
                  Este email contiene información personal --- Por favor, no lo reenvíe. Si tiene alguna llámenos al 600 381 13 12.

                  Llámenos al 600 381 13 12.

                  Ediciones SM Chile S.A. Coyancura 2283, Oficina 203, Providencia, Santiago.

                  </p>
                </td>
              </tr>
            </table>
          </td>
      </tr>
    </table>';

    return $contenido;
  }

  public function gratis($usuarios)
  {
    $contenido = '<table max-width="800" cellpadding="0" cellspacing="0" align="center">
      <tr>
        <td height="80" align="left" valign="middle" bgcolor="ffffff" style="font-family:Arial, Helvetica, sans-serif; color:#ffffff;">
          <div style="font-size:15px;">
            <b></b>
          </div>
          <div style="font-size:30px;">
            <b><img src="http://serviciosm.cl/img/smlogomin3.png" width="80" height="80" style="display:block;"></b>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <table width="650" cellpadding="0" cellspacing="0" align="center">
            <tr>
              <td width="650">
                <h2 align="center">DETALLE DE ENTRADA</h2>
                <p></p>
              </td>
            </tr>
          </table>
          </td>
          <!-- 2 column layout with 10px spacing -->
          </tr>
          <tr>
          <td>
            <table width="650" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <th width="325">
                  <h2>Método de pago</h2>
                </th>
                <th width="325">
                  <h2>Envío</h2>
                </th>
              </tr>
              <tr>
                <td width="295" align="center"><b>No aplica</b></td>
                <td width="295" align="center">
                  <p><b>Correo electrónico</b></p>
                </td>
              </tr>
            </table>
          </td>
          </tr>
          <br><br>
          <!-- 4 column layout with 0px spacing -->
          <tr>
          <td>
              <table width="650" cellpadding="0" cellspacing="0" align="center" style="font-family:Arial, Helvetica, sans-serif; border-bottom: 1px solid #ddd  border-collapse: collapse; width: 100%;">
              <!-- Aquí se encuentra el bucle del los pedidos -->
              <tr>
                  <th colspan="3" style="border-bottom: 1px solid #ddd;">
                    ASISTENTES DEL EVENTO
                  </th>
              </tr>
              <tr>
                <th style="border-bottom: 1px solid #ddd;"><i>NOMBRE</i></th>
                <th style="border-bottom: 1px solid #ddd;"><i>TELEFONO</i></th>
                <th style="border-bottom: 1px solid #ddd;"><i>CORREO</i></th>
              </tr>';
              foreach ($usuarios as $key => $valor) {
                $contenido .= '<tr>';
                $contenido .= '<td align="center" style="border-bottom: 1px solid #ddd;">'.$valor['nombre'].'</td>';
                $contenido .= '<td align="center" style="border-bottom: 1px solid #ddd;">'.$valor['telefono'].'</td>';
                $contenido .= '<td align="center" style="border-bottom: 1px solid #ddd;">'.$valor['correo'].'</td>';
                $contenido .= '</tr>';
              }
              $contenido .= '</table>
          </td>
          </tr>
          <!-- 1 column layout with 0px spacing -->
          <tr>
            <td>
              <br /><br />
            </td>
          </tr>
          <tr>
          <td>
            <table width="650" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td width="650">
                  <p>¿Tiene alguna duda?
                  Este email contiene información personal --- Por favor, no lo reenvíe. Si tiene alguna llámenos al 600 381 13 12.

                  Llámenos al 600 381 13 12.

                  Ediciones SM Chile S.A. Coyancura 2283, Oficina 203, Providencia, Santiago.

                  </p>
                </td>
              </tr>
            </table>
          </td>
      </tr>
    </table>';

    return $contenido;
  }


}


?>
