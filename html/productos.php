<?php
session_start();
include '../procesos/base.php';
if (empty($_SESSION['id'])) {
    header('Location: index.php');
}
include '../menus/menu.php';
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>.:INGRESO DE PRODUCTOS:.</title>
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
        <link href="../css/link_top.css" rel="stylesheet" />
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
        <script type="text/javascript" src="../js/productos.js"></script>
        <script type="text/javascript" src="../js/datosUser.js"></script>
        <script type="text/javascript" src="../js/ventana_reporte.js"></script>
        <script type="text/javascript" src="../js/guidely/guidely.min.js"></script>
        <script type="text/javascript" src="../js/easing.js" ></script>
        <script type="text/javascript" src="../js/jquery.ui.totop.js" ></script>
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
                                    <i class="icon-list-alt"></i>
                                    <h3>PRODUCTOS</h3>
                                </div> <!-- /widget-header -->

                                <div class="widget-content">
                                    <div class="tabbable">

                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#formcontrols" data-toggle="tab">Información Producto</a>
                                            </li>
                                            <li ><a href="#jscontrols" data-toggle="tab">Imagen</a></li>
                                        </ul>

                                        <fieldset>
                                            <form class="form-horizontal" id="productos_form" name="productos_form" method="post" enctype="multipart/form-data">
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="formcontrols">
                                                        <div class="row">
                                                            <div class="span6">
                                                                <div class="control-group">
                                                                    <label class="control-label" for="cod_prod">Código Producto: <font color="red">*</font></label>
                                                                    <div class="controls" >
                                                                        <input type="text" name="cod_prod" id="cod_prod" required placeholder="El código debe ser único" class="span4" />
                                                                    </div>  
                                                                </div>  

                                                                <div class="control-group">
                                                                    <label class="control-label" for="nombre_art">Artículo: <font color="red">*</font></label>
                                                                    <div class="controls">
                                                                        <input type="text" name="nombre_art" id="nombre_art" placeholder="Usb 0000x" class="span4" />
                                                                    </div>
                                                                </div>



                                                                <div class="control-group">
                                                                    <label class="control-label" for="precio_minorista">PSP Minorista: <font color="red">*</font></label>
                                                                    <div class="controls">

                                                                        <input type="text"  name="precio_minorista" id="precio_minorista" valu="0" placeholder="0.00" class="span4" required/>

                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label class="control-label" for="utilidad_minorista">Utilidad Minorista: </label>
                                                                    <div class="controls">
                                                                        <input type="text"  name="utilidad_minorista" id="utilidad_minorista" required readonly class="span4"/>
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label class="control-label" for="categoria">Categoría:</label>
                                                                    <div class="controls">
                                                                        <div class="input-append">
                                                                            <select id="categoria" name="categoria" class="span3">
                                                                                <option value="">........Seleccione........</option>
                                                                                <?php
                                                                                $consulta = pg_query("select * from categoria ");
                                                                                while ($row = pg_fetch_row($consulta)) {
                                                                                    echo "<option id=$row[0] value=$row[1]>$row[1]</option>";
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <input type="button" class="btn btn-primary" id='btnCategoria' value="Agregar..." title="INGRESO CATEGORIAS"/>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label class="control-label" for="descuento">Descuento:</label>
                                                                    <div class="controls">
                                                                        <input type="number" name="descuento" id="descuento"  value="0" required class="span4" min="0"/>
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label class="control-label" for="minimo">Stock Mínimo:</label>
                                                                    <div class="controls">
                                                                        <input type="number" name="minimo" id="minimo" value="1" required class="span4" min="0" />
                                                                    </div>
                                                                </div>

                                                                <div class="control-group"">
                                                                    <label class="control-label" for="vendible">Vendible:</label>
                                                                    <div class="controls">
                                                                        <select name="vendible" id="vendible" class="span4">
                                                                            <option value="Activo">Activo</option> 
                                                                            <option value="Pasivo">Pasivo</option> 
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label class="control-label" for="fecha_creacion">Fecha Creación: </label>
                                                                    <div class="controls">
                                                                        <input type="text"  name="fecha_creacion" id="fecha_creacion" required class="span4" value="" readonly /> 
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label class="control-label" for="aplicacion">Observaciones:</label>
                                                                    <div class="controls" >
                                                                        <textarea name="aplicacion" id="aplicacion" rows="3" class="span4"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="span6">
                                                                <div class="control-group">											
                                                                    <label class="control-label" for="ruc_ci">Código Barras:</label>
                                                                    <div class="controls">
                                                                        <input type="text" name="cod_barras" id="cod_barras" required placeholder="El código debe ser único" class="span4" />
                                                                        <input type="hidden" name="cod_productos" id="cod_productos" readonly class="campo" />
                                                                    </div>			
                                                                </div>

                                                                <div class="control-group">
                                                                    <label class="control-label" for="precio_compra">Precio Compra: <font color="red">*</font></label>
                                                                    <div class="controls">
                                                                        <input type="text"  name="precio_compra" id="precio_compra"   placeholder="0.00" required  class="span4" />
                                                                    </div>
                                                                </div>



                                                                <div class="control-group">											
                                                                    <label class="control-label" for="precio_mayorista">PSP Mayorista: <font color="red">*</font></label>
                                                                    <div class="controls">
                                                                        <input type="text"  name="precio_mayorista" id="precio_mayorista" valu="0" placeholder="0.00" class="span4" required />
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">											
                                                                    <label class="control-label" for="utilidad_mayorista">Utilidad Mayorista:</label>
                                                                    <div class="controls">
                                                                        <input type="text"  name="utilidad_mayorista" id="utilidad_mayorista" class="span4" readonly required />
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label class="control-label" for="marca">Marca:</label>
                                                                    <div class="controls">
                                                                        <div class="input-append">
                                                                            <select id="marca" name="marca" class="span3" >
                                                                                <option value="">........Seleccione........</option>
                                                                                <?php
                                                                                $consulta2 = pg_query("select * from marcas ");
                                                                                while ($row = pg_fetch_row($consulta2)) {
                                                                                    echo "<option id=$row[0] value=$row[1]>$row[1]</option>";
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <input type="button" class="btn btn-primary" id='btnMarca' value="Agregar..." title="INGRESO MARCAS" />
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">	
                                                                    <label class="control-label" for="stock">Stock:</label>
                                                                    <div class="controls">
                                                                        <input type="number"  name="stock" id="stock"  value="0" required class="span4" min="0"/>    
                                                                    </div>
                                                                </div> 

                                                                <div class="control-group">	
                                                                    <label class="control-label" for="maximo">Stock Máximo:</label>
                                                                    <div class="controls">
                                                                        <input type="number" name="maximo" id="maximo"  value="1" required class="span4" min="0"/>
                                                                    </div>
                                                                </div>

                                                                <div class="control-group" >
                                                                    <label class="control-label" for="inventario">Inventariable:</label>   
                                                                    <div class="controls" >
                                                                        <select id="inventario" name="inventario" class="span4">
                                                                            <option value="Si" selected>Si</option> 
                                                                            <option value="No">No</option> 
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">											
                                                                    <label class="control-label" for="iva">Iva: <font color="red">*</font></label>
                                                                    <div class="controls">
                                                                        <select id="iva" name="iva" class="span4">
                                                                            <option value="">......Seleccione......</option>
                                                                            <option value="Si" selected>Si</option> 
                                                                            <option value="No">No</option> 
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">											
                                                                    <label class="control-label" for="series">Series: </label>
                                                                    <div class="controls">
                                                                        <select id="series" name="series" class="span4">
                                                                            <option value="">......Seleccione......</option>
                                                                            <option value="Si">Si</option> 
                                                                            <option value="No" selected>No</option> 
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">	
                                                                    <label class="control-label" for="modelo">Caracteristicas: </label>
                                                                    <div class="controls" >
                                                                        <input type="text" name="modelo" id="modelo" class="span4" placeholder="Ingrese las caracteristicas"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane" id="jscontrols">
                                                        <div class="row">
                                                            <div class="span6">
                                                                <div class="control-group">
                                                                    <label class="control-label" for="archivo">Imagen: </label>
                                                                    <div class="controls">
                                                                        <input type="file" name="archivo" id="archivo" onchange='Test.UpdatePreview(this)' accept="image/*" />
                                                                    </div>	
                                                                </div> 
                                                            </div>


                                                            <div class="span6">
                                                                <div class="control-group" >
                                                                    <div id="logo" class="logo_producto" title="LOGO">
                                                                        <img id="foto" name="foto" style="width: 100%; height: 100%"  />
                                                                    </div> 
                                                                </div>
                                                            </div>  <!--span6 -->
                                                        </div>
                                                    </div>


                                                </div>
                                            </form>
                                        </fieldset>

                                        <div class="form-actions">
                                            <button class="btn btn-primary" id='btnGuardar'><i class="icon-save"></i> Guardar</button>
                                            <button class="btn btn-primary" id='btnModificar'><i class="icon-edit"></i> Modificar</button>
                                            <button class="btn btn-primary" id='btnEliminar'><i class="icon-remove"></i> Eliminar</button>                                            
                                            <button class="btn btn-primary" id='btnBuscar'><i class="icon-search"></i> Buscar</button>
                                            <button class="btn btn-primary" id='btnNuevo'><i class="icon-pencil"></i> Nuevo</button>
                                        </div>





                                        <div id="productos" title="Búsqueda de Productos" class="">
                                            <table id="list"><tr><td></td></tr></table>
                                            <div id="pager"></div>
                                        </div>

                                        <div id="categorias" title="AGREGAR CATEGORIA">
                                            <div class="control-group">
                                                <label class="control-label" for="nombre_categoria">Nombre Categoria: <font color="red">*</font></label>
                                                <div class="controls" >
                                                    <input type="text" name="nombre_categoria" id="nombre_categoria" class="campo" placeholder="Categoria" required/>
                                                </div>  
                                            </div>	
                                            <button class="btn btn-primary" id='btnGuardarCategoria'>Guardar</button>
                                        </div>

                                        <div id="marcas" title="AGREGAR MARCA">
                                            <div class="control-group">
                                                <label class="control-label" for="nombre_marca">Nombre Marca: <font color="red">*</font></label>
                                                <div class="controls" >
                                                    <input type="text" name="nombre_marca" id="nombre_marca" class="campo" placeholder="Ingrese la Marca" required />
                                                </div>  
                                            </div>	
                                            <button class="btn btn-primary" id='btnGuardarMarca'>Guardar</button>
                                        </div>

                                        <div id="clave_permiso" title="PERMISOS">
                                            <table border="0" >
                                                <tr>
                                                    <td><label>Ingese la clave de seguridad</label></td> 
                                                    <td><input type="password" name="clave" id="clave" class="campo"></td>
                                                </tr>  
                                            </table>
                                            <div class="form-actions" align="center">
                                                <button class="btn btn-primary" id='btnAcceder'><i class="icon-ok"></i> Acceder</button>
                                                <button class="btn btn-primary" id='btnCancelar'><i class="icon-remove-sign"></i> Cancelar</button>
                                            </div>
                                        </div> 

                                        <div id="seguro">
                                            <label>Esta seguro de eliminar al producto</label>  
                                            <br />
                                            <button class="btn btn-primary" id='btnAceptar'><i class="icon-ok"></i> Aceptar</button>
                                            <button class="btn btn-primary" id='btnSalir'><i class="icon-remove-sign"></i> Cancelar</button>
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
                            &copy; 2014 <a href="">P&S System</a>.
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </body>
</html>
