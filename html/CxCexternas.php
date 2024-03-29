<?php
session_start();
if (empty($_SESSION['id'])) {
    header('Location: index.php');
}
include '../menus/menu.php';
include '../procesos/base.php';
conectarse();
error_reporting(0);

/////////////////contador factura venta///////////
$cont1 = 0;
$consulta = pg_query("select max(id_c_cobrarexternas) from c_cobrarexternas");
while ($row = pg_fetch_row($consulta)) {
    $cont1 = $row[0];
}
$cont1++;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>.:CXC EXTERNA:.</title>
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
        <link rel="stylesheet" href="../css/alertify.core.css" />
        <link rel="stylesheet" href="../css/alertify.default.css" id="toggleCSS" />
        <link href="../css/sm-core-css.css" rel="stylesheet" type="text/css" />
        <link href="../css/sm-blue/sm-blue.css" rel="stylesheet" type="text/css" />

        <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/jquery-loader.js"></script>
        <script type="text/javascript" src="../js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="../js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="../js/grid.locale-es.js"></script>
        <script type="text/javascript" src="../js/jquery.jqGrid.src.js"></script>
        <script type="text/javascript" src="../js/buttons.js" ></script>
        <script type="text/javascript" src="../js/validCampoFranz.js" ></script>
        <script type="text/javascript" src="../js/cxcexternas.js"></script>
        <script type="text/javascript" src="../js/datosUser.js"></script>
        <script type="text/javascript" src="../js/ventana_reporte.js"></script>
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
                                    <i class="icon-money"></i>
                                    <h3>FACTURAS VENTAS</h3>
                                </div> <!-- /widget-header -->

                                <div class="widget-content">
                                    <div class="tabbable">
                                        <div class="widget-content">
                                            <div class="widget big-stats-container">
                                                <form id="formularios_cxc" name="formularios_cxc" method="post" class="form-horizontal">
                                                    <fieldset>
                                                        <div class="row">
                                                            <div class="span7">
                                                                <div class="control-group">											
                                                                    <label class="form-control" for="nombres_cli">Comprobante:</label>
                                                                    <div class="form-control">
                                                                        <input type="text" name="comprobante" id="comprobante" readonly class="span2" value="<?php echo $cont1 ?>" />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="span7">
                                                                <div class="control-group">											
                                                                    <label class="form-control" for="nombres_cli">Fecha Actual:</label>
                                                                    <div class="form-control">
                                                                        <input type="text" name="fecha_actual" id="fecha_actual" readonly  class="span2" />
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
                                                                        <input type="hidden" name="comprobante2" id="comprobante2" class="campo" style="width: 100px" value="<?php echo $cont1 ?>" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <fieldset>
                                                        <div class="row">
                                                            <legend></legend>
                                                            <div class="span6">
                                                                <div class="control-group">											
                                                                    <label class="control-label" for="ruc_ci">CI de Identidad/RUC: <font color="red">*</font></label>
                                                                    <div class="controls">
                                                                        <input type="text" name="ruc_ci"  id="ruc_ci" required placeholder="Buscar....." class="span4" />
                                                                    </div>
                                                                </div>    

                                                                <div class="control-group">											
                                                                    <label class="control-label" for="num_factura">Factura Preimpresa: <font color="red">*</font></label>
                                                                    <div class="controls">
                                                                        <input type="text" name="num_factura"  id="num_factura" required class="span4" />
                                                                    </div>
                                                                </div> 
                                                                <div class="control-group">											
                                                                    <label class="control-label" for="num_factura">Total: <font color="red">*</font></label>
                                                                    <div class="controls">
                                                                        <input type="text" name="total" id="total" required maxlength="10" class="span3"  />
                                                                    </div>
                                                                </div> 
                                                            </div>

                                                            <div class="span6">
                                                                <div class="control-group">											
                                                                    <label class="control-label" for="ruc_ci">Nombres: <font color="red">*</font></label>
                                                                    <div class="controls">
                                                                        <input type="text" name="nombres_completos" id="nombres_completos" class="span4"  />
                                                                        <input type="hidden" name="id_cliente" id="id_cliente" required readonly class="campo"/>
                                                                    </div>
                                                                </div> 

                                                                <div class="control-group">											
                                                                    <label class="control-label" for="ruc_ci">Documento: <font color="red">*</font></label>
                                                                    <div class="controls">
                                                                        <select id="tipo_documento" name="tipo_documento" class="span3">
                                                                            <option value="">......Seleccione Documento......</option>  
                                                                            <option value="Factura"> Factura</option>
                                                                            <option value="Nota_venta">Nota o boleta de venta</option>
                                                                        </select>
                                                                    </div>
                                                                </div> 

                                                                <div class="control-group">											
                                                                    <label class="control-label" for="notas">Notas: </label>
                                                                    <div class="controls">
                                                                        <textarea type="text" name="notas" id="notas" class="span4" ></textarea>

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
                                                    <button class="btn btn-primary" id='btnAtras'><i class="icon-step-backward"></i> Atras</button>
                                                    <button class="btn btn-primary" id='btnAdelante'>Adelante <i class="icon-step-forward"></i></button>
                                                </div>

                                                <div id="buscar_cartera_cobrar" title="BUSCAR CARTERA POR COBRAR">
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