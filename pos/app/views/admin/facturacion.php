<link href="<?php echo $assets_uri; ?>css/facturacion.css" rel="stylesheet" />
<div class="title">Facturaci&oacute;n</div>

<div class="container">
	<div class="fachead">

		<div class="form-horizontal">
		  
		  <div class="form-group">
		    <label for="txtEmpleado" class="col-lg-1 control-label negrita">Empleado:</label>
		    <div class="col-lg-2">
		      <input type="text" class="form-control" id="txtEmpleado" placeholder="Carnet" value="" >
		    </div>
		    <label for="txtNombre" class="col-lg-2 control-label negrita">Nombre:</label>
		    <div class="col-lg-5">
		      <input type="text" class="form-control" id="txtNombre" placeholder="Nombre" disabled>
		    </div>
		  </div>
		  

		</div>
		<div class="form-horizontal">
		  
		  <div class="form-group">
		    <label for="txtEstado" class="col-lg-1 control-label negrita">Estado:</label>
		    <div class="col-lg-2">
		      <input type="text" class="form-control" id="txtEstado" placeholder="Estado" disabled>
		    </div>
		    <label for="txtCredito" class="col-lg-2 control-label negrita">Credito: ($)</label>
		    <div class="col-lg-2"> 
		      <input type="text" class="form-control" id="txtCredito" placeholder="" disabled>
		    </div>
		    <div class="butoption">
		  		<button type="button" class="btn btn-danger" onclick="Limpiar()">Limpiar</button>
		  	</div>
		  	
		  </div>

		</div>

	</div>

	<hr>
	<div class="clear"></div>
	<div class="facbody">
		<div class="form-horizontal">
		  
		  <div class="form-group">
		    <label for="txtConsecutivo" class="col-lg-2 control-label negrita">Tipo de Pago:</label>
		    
		    <div class="" id="rbtTipoPago">	   
			    <div class="col-lg-1 negrita">
			      	<input type="radio" name="rbtformapago" value="C" id="chkCredito"  disabled checked><label for="chkCredito">Credito</label>			
			    </div>
			    <div class="col-lg-1 negrita">
			      	<input type="radio" name="rbtformapago" value="E"  id="chkContado" disabled><label for="chkContado">Contado</label>		
			    </div>
		    </div>
		    <div class="col-lg-1">
		      	<input type="checkbox" name="chkTicket"   id="chkTicket" checked="true" >Generar Ticket		
		    </div>
		    <strong>
			    <label for="txtTotal" class="col-lg-2 control-label negrita">Total a Pagar: ($)</label>
			    <div class="col-lg-2">
			      <input type="text" class="form-control" id="txtTotal" placeholder="" value="0.00" disabled>
			    </div>
		    </strong>
		    <div class="butoption">
		    	<button type="button" class="btn btn-success" id="btnPagar" disabled="" onclick="Pagar()">Pagar</button>
		  		<button type="button" class="btn btn-danger" id="btnBorrar" disabled="" onclick="Borrar()">Borrar</button>
		  	</div>
		  </div>

		</div>
	</div>
	<div class="facbodydet">
		<center>
			<div class="facbodydet_head">

					<div class="form-horizontal">				  
					  	<div class="form-group">
					    <label for="txtArticulo" class="col-lg-1 control-label negrita">Articulo:</label>
					    <div class="col-lg-1">
					      <input type="text" class="form-control" id="txtArticulo" placeholder="Codigo" disabled>
					    </div>
						<div class="col-lg-3">
						  <input type="text" class="form-control" id="txtDescripcion" placeholder="Nombre Art" disabled>
						</div>
						<label for="txtPrecio" class="col-lg-2 control-label negrita">Precio: ($)</label>
					    <div class="col-lg-1">
					      <input type="text" class="form-control" id="txtPrecio" placeholder="$" onkeypress="return justNumbers(event);" disabled>
					    </div>
					    <label for="txtCantidad" class="col-lg-1 control-label negrita">Cantidad:</label>
					    <div class="col-lg-1">
					      <!--<input type="text" class="form-control" id="txtCantidad" placeholder="0" disabled onkeypress="return justNumbers(event);">-->
					      <input type="text" class="form-control" id="txtCantidad" placeholder="0"  value="1" disabled>
					    </div>
						<button type="button" class="btn btn-primary" id="btnAgregar"  onclick ="AgregarDetalle()" disabled><img src="<?php echo $assets_uri; ?>img/bt_speed_dial_1x.png" alt=""></button>
					    <button type="button" class="btn btn-default" id="btnBuscarart" onclick="Buscar()" disabled><img src="<?php echo $assets_uri; ?>img/ic_search_grey600_18dp.png" alt=""></button>
				  	</div>

			</div>
		</center>
		<div class="facbodydet_body">
			<table class="table table-bordered table-condensed table-hover" id="grdFactura">
		        <thead class="table-head" id="wrapper_master">
		            
		        </thead>
		        <tbody id="wrapper_recibos">
		       		            
		        </tbody>
		    </table>
		</div>
		</div>

</div>


<script>
	
	var codEmp = '';
	var precio = 0;
	var art = "";
	var existencia = 0;
	var descripcion = '';
	var contador = 0;
	var total = 0;


	var credito_valor = 0;
	var contado_valor = 0;

	$( document ).ready(function() {
		$('#divrecibo').hide();
    	$('#txtEmpleado').focus();

    	$('#chkCredito').removeAttr('disabled');
		$('#chkContado').removeAttr('disabled');
		$('#btnPagar').removeAttr('disabled');
		$('#btnBorrar').removeAttr('disabled');
		$('#txtArticulo').removeAttr('disabled');
		$('#btnBuscarart').removeAttr('disabled');
		$('#txtArticulo').focus();


			/*
			
			F1 -> 112 -> Pagar
			F2 -> 113 -> Borrar
			F3 -> 114 -> Buscar Art
			F4 -> 115 ->Limpiar
			ALT GR -> 18 -> CambiarTipoPago
			*/

		 	document.onkeydown = function (e) {
		        e = e || event;

		        if (e.keyCode == 115) {
		            
		            Limpiar();

        		}else if(e.keyCode == 112){

        			Pagar();

        		}else if(e.keyCode == 113){

        			Borrar();

        		}else if(e.keyCode == 114){

        			Buscar();

        		}else if(e.keyCode == 18){

        			CambiarTipoDePago();

        		}

        		e.stopPropagation();
    		}

	});

	$("#txtEmpleado").keyup(function(event){
	    if(event.keyCode == 13){
	    	
	    	if ($('#txtEmpleado').val() != '') {
				BuscarEmpleado();
	    	}
	        
    	}
	});

	$("#txtArticulo").keyup(function(event){
	    if(event.keyCode == 13){

	    	if ($('#txtArticulo').val() != '') {
				BuscarArt();
	    	}
	        
	    }
	});

	$("#txtPrecio").keyup(function(event){
	    if(event.keyCode == 13){

	    	if ($('#txtPrecio').val() != '') {
				$("#txtCantidad").focus();
	    	}
	        
	        
	    }
	});

	$("#txtCantidad").keyup(function(event){
	    if(event.keyCode == 13){

	    	if ($('#txtCantidad').val() != '' && $('#txtPrecio').val() != '') {
				AgregarDetalle();
	    	}
	        
	        
	    }
	});

	$("#txtCantidad").keyup(function(event){
	    if(event.keyCode == 27){

	    $('#txtCantidad').val('');
	    $('#txtArticulo').val('');
		$('#txtDescripcion').val('');
		$('#txtPrecio').val('');
		$('#txtArticulo').focus();
	    $('#btnAgregar').attr('disabled','true');;
	        
	    }
	});

	$("#txtBuscarArt").keyup(function(event){

	    if(event.keyCode == 13){
			
			alert('');    	
	        	        
	    }
	});

	function prueba(){

		$('#view_pago_pregunta').modal('show');

	}

	function prueba2(){

		$('#view_pago_pregunta').modal('hide');
		$('#view_pago_creditocontado').modal('show');

	}

    function justNumbers(e)
    {
	    var keynum = window.event ? window.event.keyCode : e.which;
	    if ((keynum == 8) || (keynum == 46))
	    return true;
	     
	    return /\d/.test(String.fromCharCode(keynum));
    }

   	function CambiarTipoDePago(){

   		if ($('input:radio[name=rbtformapago]:checked').val() == 'C') {

			
   			$('#rbtTipoPago').html('');
   			$('#rbtTipoPago').append('<div class="col-lg-1 negrita"><input type="radio" name="rbtformapago" value="C" id="chkCredito"  ><label for="chkCredito">Credito</label></div><div class="col-lg-1 negrita"><input type="radio" name="rbtformapago" value="E"  id="chkContado"  checked><label for="chkContado">Contado</label></div>');

   		}else{
   			
   			$('#rbtTipoPago').html('');
   			$('#rbtTipoPago').append('<div class="col-lg-1 negrita"><input type="radio" name="rbtformapago" value="C" id="chkCredito"   checked><label for="chkCredito">Credito</label></div><div class="col-lg-1 negrita"><input type="radio" name="rbtformapago" value="E"  id="chkContado" ><label for="chkContado">Contado</label></div>');


   		}

   	}

	function ImprimirTicket(ticket_,tipopago_){

		if ($('#chkTicket').is(':checked')){
			
			var rec_cliente = $('#txtEmpleado').val();
			var rec_nombre =  $('#txtNombre').val();
			var rec_pago_ = total;
			var rec_credito_ = $('#txtCredito').val();
			var rec_credito_dist = $('#txtCredito').val();

			if (tipopago_ == "CREDITO") {

				rec_credito_dist = rec_credito_ - rec_pago_; 
				rec_credito_dist = Math.round(rec_credito_dist * 100)/100;
				credito_valor = rec_pago_;
				$('#credito_valor_').html('$'+credito_valor);
				$('#contado_valor_').html('');

			}else if(tipopago_ == "CONTADO"){

				contado_valor = rec_pago_;
				$('#contado_valor_').html('$'+contado_valor);	
				$('#credito_valor_').html('');

			}else if(tipopago_ == "CREDITO / CONTADO"){

				rec_credito_dist = 0;

				$('#credito_valor_').html('$'+credito_valor);
				$('#contado_valor_').html('$'+contado_valor);	
			

			}		

			$('#detarecibo').html('');
					$("#grdFactura tbody tr").each(function (index) 
			        {
			            var codart_, preciot_, canidadt_;
			            $(this).children("td").each(function (index2) 
			            {
			                switch (index2) 
			                {
			                    case 1: codart_ = $(this).text();
			                            break;
			                    case 3: preciot_ = $(this).text();
			                            break;
			                    case 2: canidadt_ = $(this).text();
			                            break;
			                }
			            })

			            var cadena_raul = '<tr><td width="125px" style="text-align:left;">'+codart_+'</td><td width="75px" style="text-align:center;">'+canidadt_+'</td><td width="75px" style="text-align:center;">'+preciot_+' </td></tr>'

			          

			            $('#detarecibo').append(cadena_raul);

			            
			        });

			$.ajax({

			}).done(function (){


				


				$('#ticket_recibo').html(ticket_);
				$('#cliente_recibo').html(rec_cliente);
				$('#nombre_recibo').html(rec_nombre);
				$('#tipopago_recibo').html(tipopago_);
				$('#total_recibo').html(rec_pago_);
				$('#credito_recibo').html(rec_credito_dist);
				imprSelec();


			});

			

			

			Limpiar();

		}else{
			Limpiar();
		}	

		
	
	}

	function PagoCreditoContado(){

		var pago = $('#txtPPago2').val();
		credito_valor = $('#txtcreditodisponible').val();
		contado_valor = $('#txtpagocontado').val();
    	var vuelto_ = ((pago-contado_valor)*100)/100;

    	

    	if (pago != "") {

    		if (vuelto_ >= 0) {

    			$('#view_pago_creditocontado').modal('hide');
    	
		    	contador = 0;

		    	var cod_cierre_ = ("<?php echo $this->session->userdata('cierre') ?>");
		    	var forma_pago_ = 3;
		    	var total_p_ = total;

		    	var url_ = "<?php echo base_url().'admin/masterfac_guardar_2/'; ?>";



		    	$.ajax({
		    		url: url_,
		    		type: 'post',
		    		dataType: 'json',
		    		data: {codigoemp:codEmp, cod_cierre:cod_cierre_, forma_pago: forma_pago_, total_p:total_p_,total_p_credito: credito_valor,total_p_contado:contado_valor}
		    	}).done(function(data){

		
		    		var codfact_ = (data.codigo);
		    		Pago_detalle(codfact_);		   		
		    		ImprimirTicket(codfact_,'CREDITO / CONTADO');


		    	}).fail(function(){

		    		alert('Error');

		    	});


		    	var vuelto = (vuelto_*100)/100;
		   


		    	
		    	alert('Gracias Por Su Compra!!! \n\n Vuelto: $'+vuelto);

    		}else{
    			alert('Ingresar un pago mayor o igual al monto total a pagar');
    		}

    	}else{
    		$('#txtPPago').focus();
    	}

	}

 	function Pagar_contado(){


    	var pago = $('#txtPPago').val();

    	var vuelto_ = ((pago-total)*100)/100;



    	if (pago != "") {

    		if (vuelto_ >= 0) {

    			$('#view_pago_contado').modal('hide');
    	
		    	contador = 0;

		    	var cod_cierre_ = ("<?php echo $this->session->userdata('cierre') ?>");
		    	var forma_pago_ = 1;
		    	var total_p_ = total;

		    	var url_ = "<?php echo base_url().'admin/masterfac_guardar/'; ?>";


		    	$.ajax({
		    		url: url_,
		    		type: 'post',
		    		dataType: 'json',
		    		data: {codigoemp:codEmp, cod_cierre:cod_cierre_, forma_pago: forma_pago_, total_p:total_p_}
		    	}).done(function(data){

		    		var codfact_ = (data.codigo);
		    		Pago_detalle(codfact_);
		    		
		    		ImprimirTicket(codfact_,'CONTADO');

		    	}).fail(function(){

		    		alert('Error');

		    	});


		    	var vuelto = (vuelto_ * 100)/100
		   


		    	
		    	alert('Gracias Por Su Compra!!! \n\n Vuelto: $'+vuelto);

    		}else{
    			alert('Ingresar un pago mayor o igual al monto total a pagar');
    		}

    	}else{
    		$('#txtPPago').focus();
    	}
	
    }

    function Pagar_credito(){

    	$('#view_pago').modal('hide');



    	var cod_cierre_ = ("<?php echo $this->session->userdata('cierre') ?>");
    	var forma_pago_ = 2;
    	var total_p_ = total;

    	var url_ = "<?php echo base_url().'admin/masterfac_guardar/'; ?>";


    	$.ajax({
    		url: url_,
    		type: 'post',
    		dataType: 'json',
    		data: {codigoemp:codEmp, cod_cierre:cod_cierre_, forma_pago: forma_pago_, total_p:total_p_}
    	}).done(function(data){

    		var codfact_ = (data.codigo);
			Pago_detalle(codfact_);			
			ImprimirTicket(codfact_,'CREDITO');

    	}).fail(function(){

    		alert('Error');

    	});

    	
    }

    function Pago_detalle(codf){

    	
			$("#grdFactura tbody tr").each(function (index) 
	        {
	            var codart_, preciot_, canidadt_;
	            $(this).children("td").each(function (index2) 
	            {
	                switch (index2) 
	                {
	                    case 0: codart_ = $(this).text();
	                            break;
	                    case 3: preciot_ = $(this).text();
	                            break;
	                    case 2: canidadt_ = $(this).text();
	                            break;
	                }
	            })

	            var pre = preciot_.replace("$", "");
	            var url_2 = "<?php echo base_url().'admin/detfac_guardar/'; ?>";
		    	$.ajax({
		    		url: url_2,
		    		type: 'post',
		    		dataType: 'json',
		    		data: {codfact:codf, codart: codart_, preciof: pre ,cantidadf:canidadt_ }
		    	}).done(function(data){


		    	}).fail(function(){

		    		alert('Error');

		    	});
	        })

    }

	function Pagar(){

	
		if (total == 0) {

			alert('Ingresar Datos');

		}else{

			var dcliente = $('#txtEmpleado').val();

			if (dcliente != '') {

				$('#txtPPago').val('');
				var clie = $('#txtEmpleado').val() + ' - ' + $('#txtNombre').val();
				$('#txtPEmpleado').val(clie);

				if ($('input:radio[name=rbtformapago]:checked').val() == 'C') {

					
					var cred = $('#txtCredito').val();
					
					if (Math.round((cred- total)*100)/100 >= 0) {

						
						var credr = Math.round((cred- total)*100)/100;


						
						$('#txtPDisponible').val('$'+cred);
						$('#txtRestante').val('$'+credr);
						$('#txtPTotal3').val('$'+total);


						$('#view_pago_contado').modal('hide');
						$('#view_pago').modal('show');
						$('#btn_PagarCredito').focus();

					}else{
						
						if (cred == 0) {

							alert('No dispone de  saldo, Seleccionar la opcion "CONTADO"');

						}else{

							$('#a1').html('');
							$('#a2').html('');
							$('#a3').html('');

							$('#a1').html('$'+total);
							$('#a2').html('$'+cred);
							$('#a3').html('$'+(Math.round((total-cred)*100)/100));

							$('#txtPTotal').val('$'+total);
							$('#txtcreditodisponible').val(cred);
							$('#txtpagocontado').val((Math.round((total-cred)*100)/100));


							prueba();

						}

						

					}
				}else{
						
						
						$('#txtPTotal2').val('$'+total);

						$('#view_pago_contado').modal('show');
						$('#txtPPago').focus();
						$('#txtPPago').attr('min',total);
				}

			}else{
				alert('Ingresar un Cliente para facturar');
				$('#txtEmpleado').focus();
			}	

		}

	}

	function Borrar(){
		$('#txtPrecio').val('');	
		$('#txtArticulo').val('');	
		$('#txtDescripcion').val('');	
		$('#txtCantidad').val('1');	
		$('#wrapper_recibos').html('');	
		$('#txtTotal').val('0.00');
		$('#txtArticulo').focus();
		$('#wrapper_master').html('');
		contador= 0;
		total = 0;
	}

	function Buscar() {
		
		LlenarDetArt();
		$('#view_product').modal('show');

	}

	function Limpiar(){

		$('#txtEmpleado').removeAttr('disabled');
		$('#txtEmpleado').val('');
		$('#txtNombre').val('');
		$('#txtEstado').val('');
		$('#txtCredito').val('$');

		/*$('#chkCredito').attr('disabled','true');
		$('#chkContado').attr('disabled','true');

		$('#btnPagar').attr('disabled','true');
		$('#btnBorrar').attr('disabled','true');

		$('#txtArticulo').attr('disabled','true');		
		$('#txtCantidad').attr('disabled','true');
		$('#btnAgregar').attr('disabled','true');
		$('#btnBuscarart').attr('disabled','true');*/

		$('#txtEmpleado').focus();

 		$('#txtTotal').val('0.00');
		$('#txtArticulo').val('');	
		$('#txtDescripcion').val('');	
		$('#txtCantidad').val('1');	
		$('#wrapper_master').html('');
		$('#wrapper_recibos').html('');	
		$('#txtPrecio').val('');
		contador = 0;
		total = 0;	
	}

	function BuscarEmpleado(){

		var idempleado_ = $('#txtEmpleado').val();
		var _url = "<?php echo base_url().'admin/detalleempleado/'; ?>";
	    $.ajax({
	            url: _url,
	            type: 'post',
	            dataType: 'json',
	            data: {idempleado: idempleado_}
	    }).done(function(data){

	    	if (data) {
	    		codEmp = data.codigo;

	    		//$('#txtEmpleado').attr('disabled','');
	    		$('#txtNombre').val(data.nombre);
		    	$('#txtEstado').val(data.estado);
		    	$('#txtCredito').val(data.credito);

		    	if (data.estado != 'ACTIVO') {

		    		alert('El empleado se encuentra inactivo');
		    	}else{

		    		$('#chkCredito').removeAttr('disabled');
					$('#chkContado').removeAttr('disabled');

					$('#btnPagar').removeAttr('disabled');
					$('#btnBorrar').removeAttr('disabled');

					$('#txtArticulo').removeAttr('disabled');
					
					$('#btnBuscarart').removeAttr('disabled');

					$('#txtArticulo').focus();

		    	}

	    	}else{
	    		$('#txtEmpleado').val('');
	    		alert('Empleado No Existe');
	    	}




	    }).fail(function(){

	    	alert('Error');
	    });

	}

	function BuscarArt(){

		
		var idarticulo_ = $('#txtArticulo').val();
		var _url = "<?php echo base_url().'admin/detarticulo/'; ?>";
	    $.ajax({
	            url: _url,
	            type: 'post',
	            dataType: 'json',
	            data: {idarticulo: idarticulo_}
	    }).done(function(data){


	    	if (data) {

	    		if (idarticulo_ == "///") {

	    			art = data.codigo;
		    		descripcion = data.nombre;


		    		$('#txtDescripcion').val(data.nombre);
		    		$('#txtPrecio').val('');		    		
		    		$('#txtPrecio').removeAttr('disabled');
		    		$('#txtCantidad').removeAttr('disabled');
					$('#btnAgregar').removeAttr('disabled');
					$('#txtPrecio').focus();
					

	    		}else{
	    			art = data.codigo;
		    		precio = data.precio1;
		    		descripcion = data.nombre;

					$('#txtPrecio').attr('disabled');
		    		$('#txtDescripcion').val(data.nombre);
		    		$('#txtPrecio').val(data.precio1);	
		    		$('#txtCantidad').removeAttr('disabled');
					$('#btnAgregar').removeAttr('disabled');
					$('#txtCantidad').focus();
	    		}

	    	}else{
	    		alert('Articulo No Existe');
	    		$('#txtArticulo').focus();
	    		$('#txtArticulo').val('');
	    		$('#txtDescripcion').val('');
	    		$('#txtCantidad').val('');
	    		$('#txtPrecio').val('');
	    	}
		
		}).fail(function(){

			alert(error);
		});
	}

	function LimpiarLinea (argument,monto) {
		
		$('#'+argument).remove();
		total = total - monto;
		total = Math.round(total * 100)/100;
		$('#txtTotal').val(total);
		$('#txtArticulo').focus();

	}

	function AgregarDetalle(){

		var cant = $('#txtCantidad').val();

		if (cant != '' && cant != 0) {

			
			if (contador == 0) {

				$('#wrapper_master').html('');
				$('#wrapper_master').append('	<th class="column-100">Articulo</th>'+
								            '    <th>Nombre</th>'+
								            '    <th class="column-100">Cantidad</th>'+
								            '    <th class="column-100">Precio</th>'+
								            '    <th class="column-100">SubTotal</th>'+
								            '    <th class="column-50"></th>');

			}


			if (art == "///") {

				precio = $('#txtPrecio').val();

			};

			var monto_ = Math.round((cant*precio)*100)/100;

			$('#wrapper_recibos').append('	<tr id="'+contador+'">'+
								        '        <td class="column-100">'+art+'</td>'+
								        '        <td>'+descripcion+'</td>'+
								        '        <td class="column-100">'+Math.round(cant)+'</td>'+
								        '        <td class="column-100">$'+precio+'</td>'+
								        '        <td class="column-100">$'+Math.round((cant*precio)*100)/100+'</td>'+
								        '        <td class="column-100"><a class="btn" onclick="LimpiarLinea('+contador+','+monto_+')" ><img src="<?php echo $assets_uri; ?>img/ic_delete_black_24dp.png" alt=""></a></td>'+
										'	</tr>');


			


			/*********************/

			total += Math.round((cant*precio)*100)/100;
			total = Math.round(total * 100)/100;

	
			$('#txtTotal').val(total);
			$('#txtArticulo').val('');
			$('#txtArticulo').focus();
			$('#txtPrecio').val('');
			$('#txtCantidad').val('');
			$('#txtDescripcion').val('');

			$('#txtCantidad').attr('disabled','true');
			$('#btnAgregar').attr('disabled','true');

			/*********************/
			contador++;

		}

	}

	function LlenarDetArt(){

		var search_articulo_ = $('#txtBuscarArt').val();
		var url_ = "<?php echo base_url().'admin/existfiltrolimit/' ?>";

			$.ajax({
				url: url_,
				type: 'post',
				dataType: 'json',
				data: {busqueda: search_articulo_}
			}).done(function(data){


			
			$('#wrapper_articulos').html('');
			$(data.articulos).each(function(){
				var cod_ = "'"+this.codigo+"'";
				$('#wrapper_articulos').append(	'	<tr>'+
									        '        <td class="column-100">'+this.codigo+'</td>'+
									        '        <td>'+this.nombre+'</td>'+
									        '        <td class="column-100">'+this.tipo+'</td>'+
									        '        <td class="column-50">'+this.cantidad+'</td>'+
									        '        <td class="column-50">$'+this.precio+'</td>'+
									        '        <td class="column-50"><a class="btn" onclick="SetArt('+cod_+')"><img src="<?php echo $assets_uri; ?>img/Buy-50.png" alt=""></a></td>'+
								            '	</tr>');
			});

			

			}).fail(function(){

				alert('Error');

		});

	}

	function SetArt(varart){

		
		$('#txtArticulo').val(varart);
		BuscarArt();
		$('#view_product').modal('hide');
		
	}

	function imprSelec(){

		var ficha=document.getElementById('divrecibo');
		var ventimp=window.open(' ','popimpr');

		ventimp.document.write(ficha.innerHTML);
		ventimp.document.close();
		ventimp.print();
		ventimp.close();
	}

</script>

<div  id="divrecibo" >
	
	<div id="encabezado"> 
			********* Cafeteria Estrada ************** 
	</div>
	
	<div id="texto" style="font-size:8px !important;"> 
	<div id="fecha">Fecha: <?php echo date("Y-m-d H:i:s"); ?></div>
		<br>Ticket: <span id="ticket_recibo"></span>
		<br>Cajero: <?php  echo $this->session->userdata('user_name2'); ?>
		<br>Cliente: <span id="cliente_recibo"></span>
		<br>Nombre : <span id="nombre_recibo"></span>
		<br>********************************************	
		<br>Tipo Pago: <span id="tipopago_recibo"></span>		
		<br>Pago Contado: <span id="contado_valor_"></span>
		<br>Pago Credito: <span id="credito_valor_"></span>
		<br>********************************************
		<br>Su credito disponible es: $<span id="credito_recibo"></span>
		<br>
		<br>
		<table style="boder: 1px; font-size:8px !important;">
		<thead>
		<tr>
			<th width="125px" style="text-align:left;">Articulo</th>
			<th width="75px" style="text-align:center;">Cantidad</th>
			<th width="75px" style="text-align:center;">Precio </th>
		</tr>
		</thead>
		<tbody id="detarecibo">
			
		</tbody>
		</table>
		<br>TOTAL: $<span id="total_recibo"></span>

		
	</div>
	<br>	******** Gracias por su compra **********
</div>


<!--VerificarPago-->

<div id="view_pago_pregunta" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title" id="vw_nombre">Pago</h5>
                <hr>
            </div>
            <div class="modal-body">
			
				<p class="txt1">
				El monto total de su compra es de <span id="a1">$00.00</span> y su disponibilidad 
				de credito es de <span id="a2">$0.00</span>,	haciendo una diferencia de <span id="a3">$0.00</span>

				</p>
				<br>
				<label class="txt2">¿Desea Pagar la Diferencia en Contado?</label>

            </div>
            <div class="modal-footer">
				<form>
	            	<button type="button" class="btn btn-primary" id="btn_PagarCredito" onclick="prueba2()">SI</button>                
	                <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
	            	
	            </form>
            </div>
    </div>
  </div>
</div>

<!--VerificarPago-->
<div id="view_pago_creditocontado" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="vw_nombre">Confirmacion de Pago</h4>
            </div>
            <div class="modal-body">

				<div class="form-horizontal">
		  
					  <div class="form-group">
					    
					    <label class="col-lg-3 control-label negrita" for="txtPEmpleado">Empleado:</label>
						<div class="col-lg-7">
					      <input type="text" class="form-control" id="txtPEmpleado" value="Raul Eduardo Herandez" disabled>
					    </div>			
					    
					  </div>
					  <div class="form-group">
					    
					    <label class="col-lg-3 control-label negrita" for="txtPFormaPago">Forma de Pago:</label>
						<div class="col-lg-4">
					      <input type="text" class="form-control" id="txtPFormaPago" value="Credito / Contado" disabled>
					    </div>				
					    
					  </div>
					  <div class="form-group">
					    
					    <label class="col-lg-3 control-label negrita" for="txtPTotal">Total a Pagar:</label>
						<div class="col-lg-3">
					      <input type="text" class="form-control" id="txtPTotal" value="$0.00" disabled>
					    </div>	
					    
					  </div>
					  <div class="form-group">
					    
					    <label class="col-lg-3 control-label negrita" for="txtcreditodisponible">Credito Disponible:</label>
						<div class="col-lg-3">
					      <input type="text" class="form-control" id="txtcreditodisponible" value="$0.00" disabled>
					    </div>	
					    
					  </div>
					  <div class="form-group">
					    
					    <label class="col-lg-3 control-label negrita" for="txtpagocontado">Pago Contado:</label>
						<div class="col-lg-3">
					      <input type="text" class="form-control" id="txtpagocontado" value="$0.00" disabled>
					    </div>	
					    
					  </div>

				</div>
				
            </div>
            <div class="modal-footer">
				<form>
	            	<label class="col-lg-3 control-label negrita" style="color:rgba(255, 0, 0, 0.8);">Pago:</label>
							<div class="col-lg-3">
						      <input type="text" class="form-control" id="txtPPago2" placeholder="$0.00" onkeypress="return justNumbers(event);"  min="0" max="1000" required>
					</div>	
	            	<button type="button" class="btn btn-primary" id="btn_PagarCredito" onclick="PagoCreditoContado()">Pagar</button>                
	                <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
	            </form>
            </div>
        </div>
    </div>
</div>

<!--VerificarPago-->
<div id="view_pago_contado" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="vw_nombre">Confirmacion de Pago</h4>
            </div>
            <div class="modal-body">

				<div class="form-horizontal">
		  
					  <div class="form-group">
					    
					    <label class="col-lg-3 control-label negrita" for="txtPEmpleado">Empleado:</label>
						<div class="col-lg-7">
					      <input type="text" class="form-control" id="txtPEmpleado" value="Raul Eduardo Herandez" disabled>
					    </div>			
					    
					  </div>
					  <div class="form-group">
					    
					    <label class="col-lg-3 control-label negrita" for="txtPFormaPago">Forma de Pago:</label>
						<div class="col-lg-3">
					      <input type="text" class="form-control" id="txtPFormaPago" value="Contado" disabled>
					    </div>				
					    
					  </div>
					  <div class="form-group">
					    
					    <label class="col-lg-3 control-label negrita" for="txtPTotal2">Total a Pagar:</label>
						<div class="col-lg-3">
					      <input type="text" class="form-control" id="txtPTotal2" value="$0.00" disabled>
					    </div>				
					    
					  </div>

				</div>
				
            </div>
            <div class="modal-footer">
				<form>
	            	<label class="col-lg-3 control-label negrita">Pago:</label>
							<div class="col-lg-3">
						      <input type="text" class="form-control" id="txtPPago" placeholder="$0.00" onkeypress="return justNumbers(event);"  min="0" max="1000" required>
					</div>	
	            	<button type="button" class="btn btn-primary" id="btn_PagarContado" onclick="Pagar_contado()">Pagar</button>                
	                <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
	            </form>
            </div>
        </div>
    </div>
</div>

<!--VerificarPago-->
<div id="view_pago" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="vw_nombre">Confirmacion de Pago</h4>
            </div>
            <div class="modal-body">

				<div class="form-horizontal">
		  
					  <div class="form-group">
					    
					    <label class="col-lg-3 control-label negrita" for="txtPEmpleado">Empleado:</label>
						<div class="col-lg-7">
					      <input type="text" class="form-control" id="txtPEmpleado" value="Raul Eduardo Herandez" disabled>
					    </div>			
					    
					  </div>
					  <div class="form-group">
					    
					    <label class="col-lg-3 control-label negrita" for="txtPFormaPago">Forma de Pago:</label>
						<div class="col-lg-3">
					      <input type="text" class="form-control" id="txtPFormaPago" value="Credito" disabled>
					    </div>				
					    
					  </div>
					  <div class="form-group">
					    
					    <label class="col-lg-3 control-label negrita" for="txtPDisponible">Dispobible:</label>
						<div class="col-lg-3">
					      <input type="text" class="form-control" id="txtPDisponible" value="$0.00" disabled>
					    </div>			
					    
					  </div>
					  <div class="form-group">
					    
					    <label class="col-lg-3 control-label negrita" for="txtPTotal3">Total a Pagar:</label>
						<div class="col-lg-3">
					      <input type="text" class="form-control" id="txtPTotal3" disabled>
					    </div>				
					    
					  </div>
					  <div class="form-group">
					    
					    <label class="col-lg-3 control-label negrita">Restante:</label>
						<div class="col-lg-3">
					      <input type="text" class="form-control" id="txtRestante" value="$0.00" disabled>
					    </div>				
					    
					  </div>

				</div>
				
            </div>
            <div class="modal-footer">
            	<button type="button" class="btn btn-primary" id="btn_PagarCredito" onclick="Pagar_credito()">Pagar</button>                
                <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Visualizacion -->
<div id="view_product" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="vw_nombre">Articulos</h4>
            </div>
            <div class="modal-body">

				<div class="form-horizontal">				  
					  	<div class="form-group">
					    <label for="txtBuscarArt" class="col-lg-1 control-label">Buscar:</label>
					    <div class="col-lg-5">
					      <input type="text" class="form-control" id="txtBuscarArt" placeholder="">
					    </div>						
					    <button type="button" class="btn btn-default" onclick="LlenarDetArt()"><img src="<?php echo $assets_uri; ?>img/ic_search_grey600_18dp.png" alt=""></button>
				  	</div>

                <table class="table table-bordered table-condensed table-hover">
		        <thead class="table-head">
		            <tr>
		                <th class="column-100">Articulo</th>
		                <th>Nombre</th>
		                <th class="column-100">Tipo</th>
		                <th class="column-100">Exis.</th>
		                <th class="column-100">Precio</th>
		                <th class="column-50"></th>
		            </tr>
		        </thead>
		        <tbody id="wrapper_articulos">
		       		
		           	            
		        </tbody>
		    </table>
            </div>
            <div class="modal-footer">                
                <button type="button" class="btn btn-primary" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>

