<?php
session_start();
if (empty($_SESSION['id'])) {
    header('Location: index.php');
}
include '../menus/menu.php';
////////////////numero factura//////////////////
include '../procesos/base.php';
conectarse();
error_reporting(0);

/////////////////contador factura venta///////////
$cont1 = 0;
$consulta = pg_query("select * from proforma order by id_proforma asc");
while ($row = pg_fetch_row($consulta)) {
    $cont1 = $row[0];
}
$cont1++;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>.:PROFORMAS:.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes"> 
        <link rel="stylesheet" type="text/css" href="../css/buttons.css"/>
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui-1.10.4.custom.css"/>    
        <link rel="stylesheet" type="text/css" href="../css/normalize.css"/>    
        <link rel="stylesheet" type="text/css" href="../css/ui.jqgrid.css"/> 
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
        <link href="../css/font-awesome.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
        <link href="../css/link_top.css" rel="stylesheet" />
        <link rel="stylesheet" href="../css/alertify.core.css" />
        <link rel="stylesheet" href="../css/alertify.default.css" id="toggleCSS" />
        <link href="../css/sm-core-css.css" rel="stylesheet" type="text/css" />
        <link href="../css/sm-blue/sm-blue.css" rel="stylesheet" type="text/css" />

        <script type="text/javascript"src="../js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/jquery-loader.js"></script>
        <script type="text/javascript" src="../js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="../js/grid.locale-es.js"></script>
        <script type="text/javascript" src="../js/jquery.jqGrid.src.js"></script>
        <script type="text/javascript" src="../js/buttons.js" ></script>
        <script type="text/javascript" src="../js/validCampoFranz.js" ></script>
        <script type="text/javascript" src="../js/proforma.js"></script>
        <script type="text/javascript" src="../js/datosUser.js"></script>
        <script type="text/javascript" src="../js/ventana_reporte.js"></script>
        <script type="text/javascript" src="../js/jquery.ui.totop.js" ></script>
        <script type="text/javascript" src="../js/guidely/guidely.min.js"></script>
        <script type="text/javascript" src="../js/jquery.smartmenus.js"></script>
        <script type="text/javascript" src="../js/alertify.min.js"></script>
    </head>

    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="brand" href="">
                        <h1><?php echo $_SESSION['empresa']; ?></h1>				
                    </a>
                </div>
            </div>
        </div> 

        <!-- /Inicio  Menu Principal -->
        <div class="subnavbar">
            <div class="subnavbar-inner">
                <?Php
                // Cabecera Menu 
                if ($_SESSION['cargo'] == '1') {
                    print menu_1();
                }
                if ($_SESSION['cargo'] == '2') {
                    print menu_2();
                }
                if ($_SESSION['cargo'] == '3') {
                    print menu_3();
                }
                ?> 
            </div> 
        </div> 
        <!-- /Fin  Menu Principal -->

        <div class="main">
            <div class="main-inner">
                <div class="container">
                    <div class="row">
                        <div class="span12">      		
                            <div class="widget ">
                                <div class="widget-header">
                                    <i class="icon-file"></i>
                                    <h3>PROFORMAS</h3>
                                </div> <!-- /widget-header -->

                                <div class="widget-content">
                                    <div class="tabbable">
                                        <div class="widget-content">
                                            <div class="widget big-stats-container">
                                                <form id="formularios_fac" name="formularios_fac" method="post" class="form-horizontal">
                                                    <fieldset>
                                                        <div class="row">
                                                            <div class="span7">
                                                                <div class="control-group">											
                                                                    <label class="form-control" for="nombres_cli">Comprobante:</label>
                                                                    <div class="form-control">
                                                                        <input type="text" name="comprobante" id="comprobante" readonly class="span2" value="<?php echo $cont1 ?>"/>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="span7">
                                                                <div class="control-group">											
                                                                    <label class="form-control" for="nombres_cli">Fecha Actual:</label>
                                                                    <div class="form-control">
                                                                        <input type="text" name="fecha_actual" id="fecha_actual" readonly class="span2" />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="span7">
                                                                <div class="control-group">											
                                                                    <label class="form-control" for="nombres_cli">Hora Actual:</label>
                                                                    <div class="form-control">
                                                                        <input type="text" name="hora_actual" id="hora_actual" readonly class="span2" />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="span7">
                                                                <div class="control-group">											
                                                                    <label class="form-control" for="nombres_cli"> Digitad@r:</label>
                                                                    <div class="form-control">
                                                                        <input type="text" name="digitador" id="digitador" value="<?php echo $_SESSION['nombres'] ?>" class="span3" readonly/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <br />
                                                    <fieldset>
                                                        <legend></legend>    
                                                        <div class="row">
                                                            <div class="span6">
                                                                <div class="control-group">											
                                                                    <label class="control-label" for="ci_ruc">CI. Identidad/RUC: <font color="red">*</font></label>
                                                                    <div class="controls">
                                                                        <input type="text" name="ruc_ci"  id="ruc_ci" required placeholder="Buscar....." class="span3" />
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">											
                                                                    <label class="control-label" for="saldo">Saldo Disponible:</label>
                                                                    <div class="controls">
                                                                        <input type="text" name="saldo" id="saldo" required readonly class="span3"  />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="span6">
                                                                <div class="control-group">											
                                                                    <label class="control-label" for="nombres_completos">Nombres del Cliente: <font color="red">*</font></label>
                                                                    <div class="controls">
                                                                        <input type="text" name="nombres_completos" id="nombres_completos" placeholder="Buscar....." class="span4" />
                                                                    </div>
                                                                </div> 

                                                                <div class="control-group">											
                                                                    <label class="control-label" for="tipo_precio">Tipo de Precio: <font color="red">*</font></label>
                                                                    <div class="controls">
                                                                        <select id="tipo_precio" name="tipo_precio" style="width: 200px">
                                                                            <option value="MINORISTA">MINORISTA</option>
                                                                            <option value="MAYORISTA">MAYORISTA</option>
                                                                        </select>
                                                                        <input type="hidden" name="id_cliente" id="id_cliente" required readonly class="span3" />
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <fieldset>
                                                        <legend>Productos</legend>    
                                                        <table cellpadding="2" border="0">
                                                            <tr>
                                                                <td><label>Código Barras:</label></td> 
                                                                <td><label>Código:</label></td>   
                                                                <td><label>Producto:</label></td>   
                                                                <td><label>Cantidad:</label></td>   
                                                                <td><label style="width: 100%">P. Venta:</label></td>
                                                                <td><label>Descuento:</label></td>
                                                            </tr>

                                                            <tr>
                                                                <td><input type="text" name="cod_barras" id="cod_barras" class="campo" style="width: 180px"  placeholder="Buscar..."/></td>
                                                                <td><input type="text" name="codigo" id="codigo" class="campo" style="width: 180px"  placeholder="Buscar..."/></td>
                                                                <td><input type="text" name="producto" id="producto" class="campo" style="width: 200px"  placeholder="Buscar..."/></td>
                                                                <td><input type="text" name="cantidad" id="cantidad" class="campo" style="width: 60px" maxlength="10"/></td>
                                                                <td><input type="text" name="p_venta" id="p_venta" style="width: 60px" class="campo" maxlength="10"/></td>
                                                                <td><input type="text" name="descuento" id="descuento" class="campo" style="width: 60px" maxlength="10" value="" placeholder="%"/></td>
                                                                <td><input type="hidden" name="cod_producto" id="cod_producto" class="campo" style="width: 100px"/></td>
                                                                <td><input type="hidden" name="iva_producto" id="iva_producto" class="campo" style="width: 100px" /></td>
                                                            </tr>
                                                        </table>

                                                        <div>
                                                            <table id="list"></table>
                                                        </div>
                                                        
                                                        <div style="padding: 15px; ">
                                                            <div class="control-group">											
                                                                <label class="control-label" for="nombres_completos">Observaciones: </label>
                                                                <div class="controls">
                                                                    <textarea name="observaciones" id="observaciones" class="campo" ></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div style="padding: 15px; margin-left: 560px; margin-top: -90px;">
                                                            <div class="control-group">											
                                                                <label class="control-label" for="total_p">Tarifa 0:</label>
                                                                <div class="controls">
                                                                    <div class="input-prepend input-append">
                                                                        <span class="add-on">$</span>
                                                                        <input type="text" name="total_p" id="total_p" readonly value="0.00" class="span1"/>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="control-group">											
                                                                <label class="control-label" for="total_p2">Tarifa 12:</label>
                                                                <div class="controls">
                                                                    <div class="input-prepend input-append">
                                                                        <span class="add-on">$</span>
                                                                        <input type="text" name="total_p2" id="total_p2" readonly value="0.00" class="span1"/>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="control-group">											
                                                                <label class="control-label" for="total_p2">12 %Iva:</label>
                                                                <div class="controls">
                                                                    <div class="input-prepend input-append">
                                                                        <span class="add-on">$</span>
                                                                        <input type="text" name="iva" id="iva" readonly value="0.00" class="span1"/>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="control-group">											
                                                                <label class="control-label" for="desc">Descuento:</label>
                                                                <div class="controls">
                                                                    <div class="input-prepend input-append">
                                                                        <span class="add-on">$</span>
                                                                        <input type="text" name="desc" id="desc" readonly value="0.00" class="span1"/>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="control-group">											
                                                                <label class="control-label" for="tot">Total:</label>
                                                                <div class="controls">
                                                                    <div class="input-prepend input-append">
                                                                        <span class="add-on">$</span>
                                                                        <input type="text" name="tot" id="tot" readonly value="0.00" class="span1" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </fieldset>
                                                </form>
                                                <div class="form-actions">
                                                    <button class="btn btn-primary" id='btnGuardar'><i class="icon-save"></i> Guardar</button>
                                                    <button class="btn btn-primary" id='btnModificar'><i class="icon-edit"></i> Modificar</button>
                                                    <button class="btn btn-primary" id='btnBuscar'><i class="icon-search"></i> Buscar</button>
                                                    <button class="btn btn-primary" id='btnNuevo'><i class="icon-pencil"></i> Nuevo</button>
                                                    <button class="btn btn-primary" id='btnImprimir'><i class="icon-print"></i> Imprimir</button>
                                                    <button class="btn btn-primary" id='btnAtras'><i class="icon-step-backward"></i> Atras</button>
                                                    <button class="btn btn-primary" id='btnAdelante'>Adelante <i class="icon-step-forward"></i></button>
                                                </div>

                                                <div id="buscar_proformas" title="BUSCAR PROFORMAS">
                                                    <table id="list2"><tr><td></td></tr></table>
                                                    <div id="pager2"></div>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div> 
                    </div> 
                </div> 
            </div> 
        </div> 
        <script type="text/javascript" src="../js/base.js"></script>
        <script type="text/javascript" src="../js/jquery.ui.datepicker-es.js"></script>

        <div class="footer">
            <div class="footer-inner">
                <div class="container">
                    <div class="row">
                        <div class="span12">
                            &copy; 2014 <a href=""> <?php echo $_SESSION['empresa']; ?></a>.
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </body>
</html>