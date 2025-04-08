var manageBrandTable;

$(document).ready(function() {
	// top bar active
	$('#navSupplier').addClass('active');
	
	// manage brand table
	manageBrandTable = $("#manageBrandTable").DataTable({
		'ajax': 'php_action/fetchSupplier.php',
		'order': []		
	});

	// submit brand form function
	$("#submitSupplierForm").unbind('submit').bind('submit', function() {
		// remove the error text
		$(".text-danger").remove();
		// remove the form error
		$('.form-group').removeClass('has-error').removeClass('has-success');			

		var supplierName = $("#supplierName").val();
		var supplierStatus = $("#supplierStatus").val();

		if(supplierName == "") {
			$("#supplierName").after('<p class="text-danger">Supplier Name field is required</p>');
			$('#supplierName').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#supplierName").find('.text-danger').remove();
			// success out for form 
			$("#supplierName").closest('.form-group').addClass('has-success');	  	
		}

		if(supplierStatus == "") {
			$("#supplierStatus").after('<p class="text-danger">Supplier Status is required</p>');

			$('#supplierStatus').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#supplierStatus").find('.text-danger').remove();
			// success out for form 
			$("#supplierStatus").closest('.form-group').addClass('has-success');	  	
		}

		if(supplierName && supplierStatus) {
			var form = $(this);
			// button loading
			$("#createSupplierBtn").button('loading');

			$.ajax({
				url : form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {
					// button loading
					$("#createSupplierBtn").button('reset');

					if(response.success == true) {
						// reload the manage member table 
						manageBrandTable.ajax.reload(null, false);						

  	  			// reset the form text
						$("#submitSupplierForm")[0].reset();
						// remove the error text
						$(".text-danger").remove();
						// remove the form error
						$('.form-group').removeClass('has-error').removeClass('has-success');
  	  			
  	  			$('#add-brand-messages').html('<div class="alert alert-success">'+
            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
          '</div>');

  	  			$(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert
					}  // if

				} // /success
			}); // /ajax	
		} // if

		return false;
	}); // /submit brand form function

});

function editBrands(supplierId = null) {
	if(supplierId) {
		// remove hidden brand id text
		$('#suppierId').remove();

		// remove the error 
		$('.text-danger').remove();
		// remove the form-error
		$('.form-group').removeClass('has-error').removeClass('has-success');

		// modal loading
		$('.modal-loading').removeClass('div-hide');
		// modal result
		$('.edit-brand-result').addClass('div-hide');
		// modal footer
		$('.editBrandFooter').addClass('div-hide');

		$.ajax({
			url: 'php_action/fetchSelectedSupplier.php',
			type: 'post',
			data: {supplierId : supplierId},
			dataType: 'json',
			success:function(response) {
				// modal loading
				$('.modal-loading').addClass('div-hide');
				// modal result
				$('.edit-brand-result').removeClass('div-hide');
				// modal footer
				$('.editBrandFooter').removeClass('div-hide');

				// setting the brand name value 
				$('#editSupplierName').val(response.supplier_name);
				// setting the brand status value
				$('#editSupplierStatus').val(response.active);
				// brand id 
				$(".editBrandFooter").after('<input type="hidden" name="supplierId" id="supplierId" value="'+response.supplier_id+'" />');

				// update brand form 
				$('#editSupplierForm').unbind('submit').bind('submit', function() {

					// remove the error text
					$(".text-danger").remove();
					// remove the form error
					$('.form-group').removeClass('has-error').removeClass('has-success');			

					var supplierName = $('#editSupplierName').val();
					var supplierStatus = $('#editSupplierStatus').val();

					if(supplierName == "") {
						$("#editSupplierName").after('<p class="text-danger">Supplier Name field is required</p>');
						$('#editSupplierName').closest('.form-group').addClass('has-error');
					} else {
						// remov error text field
						$("#editSupplierName").find('.text-danger').remove();
						// success out for form 
						$("#editSupplierName").closest('.form-group').addClass('has-success');	  	
					}

					if(supplierStatus == "") {
						$("#editSupplierStatus").after('<p class="text-danger">Supplier Status field is required</p>');

						$('#editSupplierStatus').closest('.form-group').addClass('has-error');
					} else {
						// remove error text field
						$("#editSupplierStatus").find('.text-danger').remove();
						// success out for form 
						$("#editSupplierStatus").closest('.form-group').addClass('has-success');	  	
					}

					if(supplierName && supplierStatus) {
						var form = $(this);

						// submit btn
						$('#editSupplierBtn').button('loading');

						$.ajax({
							url: form.attr('action'),
							type: form.attr('method'),
							data: form.serialize(),
							dataType: 'json',
							success:function(response) {

								if(response.success == true) {
									console.log(response);
									// submit btn
									$('#editSupplierBtn').button('reset');

									// reload the manage member table 
									manageBrandTable.ajax.reload(null, false);								  	  										
									// remove the error text
									$(".text-danger").remove();
									// remove the form error
									$('.form-group').removeClass('has-error').removeClass('has-success');
			  	  			
			  	  			$('#edit-brand-messages').html('<div class="alert alert-success">'+
			            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
			            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
			          '</div>');

			  	  			$(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function() {
											$(this).remove();
										});
									}); // /.alert
								} // /if
									
							}// /success
						});	 // /ajax												
					} // /if

					return false;
				}); // /update brand form

			} // /success
		}); // ajax function

	} else {
		alert('error!! Refresh the page again');
	}
} // /edit brands function

function removeSupplier(supplierId = null) {
	if(supplierId) {
		$('#removeSupplierId').remove();
		$.ajax({
			url: 'php_action/fetchSelectedSupplier.php',
			type: 'post',
			data: {supplierId : supplierId},
			dataType: 'json',
			success:function(response) {
				$('.removeBrandFooter').after('<input type="hidden" name="removeSupplierId" id="removeSupplierId" value="'+response.brand_id+'" /> ');

				// click on remove button to remove the brand
				$("#removeSupplierBtn").unbind('click').bind('click', function() {
					// button loading
					$("#removeSupplierBtn").button('loading');

					$.ajax({
						url: 'php_action/removeSupplier.php',
						type: 'post',
						data: {supplierId : supplierId},
						dataType: 'json',
						success:function(response) {
							console.log(response);
							// button loading
							$("#removeSupplierBtn").button('reset');
							if(response.success == true) {

								// hide the remove modal 
								$('#removeSupplierMemberModal').modal('hide');

								// reload the brand table 
								manageBrandTable.ajax.reload(null, false);
								
								$('.remove-messages').html('<div class="alert alert-success">'+
			            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
			            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
			          '</div>');

			  	  			$(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function() {
											$(this).remove();
										});
									}); // /.alert
							} else {

							} // /else
						} // /response messages
					}); // /ajax function to remove the brand

				}); // /click on remove button to remove the brand

			} // /success
		}); // /ajax

		$('.removeBrandFooter').after();
	} else {
		alert('error!! Refresh the page again');
	}
} // /remove brands function