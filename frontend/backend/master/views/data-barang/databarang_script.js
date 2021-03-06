/**
 * ===============================
 * JS Modal Import
 * Author	: ptr.nov2gmail.com
 * Update	: 05/09/2017
 * Version	: 2.1
 * ===============================
*/

/*
 * Js Modal harga hitung HPP
*/

$(document).ready(function() {
	$('#tahun').change(function(){
		var x = document.getElementById('tahun').value;
			$.pjax.reload({
				url:'/master/data-barang/index?TGL='+x, 
				container: '#gv-all-data-prodak-dicount-item',
				container: '#gv-all-data-prodak-harga-item',
				container: '#gv-all-data-prodak-stock-item',
				timeout: 1000,
			}).done(function () {
				$.pjax.reload({container: '#gv-all-data-prodak-dicount-item'});
				$.pjax.reload({container: '#gv-all-data-prodak-stock-item'});
				$.pjax.reload({container: '#gv-all-data-prodak-harga-item'});
			});
	 });
});
$(document).ready(function() {
	$('#hitung').change(function(){
	var persedian=parseInt($('#persedian').val());
	var pembelian=parseInt($('#pembelian').val());
	var bahanangkut=parseInt($('#bahanangkut').val());
	var retur=parseInt($('#retur').val());
	var potongan=parseInt($('#potongan').val());
	var persedianakhir=parseInt($('#persedianakhir').val());
	var belibersi=(pembelian+bahanangkut)-(retur+potongan);
	var barangjual=(belibersi+persedian);
	var hpp=(barangjual+persedianakhir);
	$('#harga').val(barangjual);
	$('#hpp').val(hpp);
	$('#harga-disp').val(barangjual);
	$('#hpp-disp').val(hpp);
	$('#productharga-harga_jual-disp').val(barangjual);
	$('#productharga-harga_jual').val(barangjual);
	$('#productharga-hpp-disp').val(hpp);
	$('#productharga-hpp').val(hpp);
	});
});

$.fn.modal.Constructor.prototype.enforceFocus = function(){};
//$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';	
$(document).on('click','#databarang-button', function(ehead){ 			  
	$('#databarang-button-modal').modal('show')
	.find('#databarang-button-content').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	//.load(ehead.target.value);
	.load($(this).attr('value'));
});
$.fn.modal.Constructor.prototype.enforceFocus = function(){};
//$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';	
$(document).on('click','#customer-button', function(ehead){ 			  
	$('#customer-button-modal').modal('show')
	.find('#customer-button-content').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	//.load(ehead.target.value);
	.load($(this).attr('value'));
});
$.fn.modal.Constructor.prototype.enforceFocus = function(){};
//$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';	
$(document).on('click','#supplier-button', function(ehead){ 			  
	$('#supplier-button-modal').modal('show')
	.find('#supplier-button-content').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	//.load(ehead.target.value);
	.load($(this).attr('value'));
});
/*
 * BUTTON UPLOAD FORMAT.
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};
//$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';	
$(document).on('click','#databarang-button-upload', function(ehead){ 			  
	$('#databarang-button-upload-modal').modal('show')
	.find('#databarang-button-upload-content').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	//.load(ehead.target.value);
	.load($(this).attr('value'));
});
/*
 * BUTTON UPLOAD FORMAT.
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};
//$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';	
$(document).on('click','#databarang-button-upload-harga', function(ehead){ 			  
	$('#databarang-button-upload-harga-modal').modal('show')
	.find('#databarang-button-upload-harga-content').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	//.load(ehead.target.value);
	.load($(this).attr('value'));
});
/*
 * BUTTON CREATE GROUP PRODUCT
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};
//$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';	
$(document).on('click','#create-group-product-button', function(ehead){ 			  
	$('#create-group-product-button-modal').modal('show')
	.find('#create-group-product-button-content').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	//.load(ehead.target.value);
	.load($(this).attr('value'));
});

/*
 * BUTTON VIEW KARYAWAN
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};
//$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';	
$(document).on('click','#databarang-button-row-view', function(ehead){ 			  
	$('#databarang-button-row-view-modal').modal('show')
	.find('#databarang-button-row-view-content').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	//.load(ehead.target.value);
	.load($(this).attr('value'));
});

/*
 * BUTTON EDIT KARYAWAN
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};
//$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';	
$(document).on('click','#databarang-button-row-edit', function(ehead){ 			  
	$('#databarang-button-row-edit-modal').modal('show')
	.find('#databarang-button-row-edit-content').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	//.load(ehead.target.value);
	.load($(this).attr('value'));
});
/*
 * BUTTON VIEW KARYAWAN
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};
//$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';	
$(document).on('click','#supplier-button-row-view', function(ehead){ 			  
	$('#supplier-button-row-view-modal').modal('show')
	.find('#supplier-button-row-view-content').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	//.load(ehead.target.value);
	.load($(this).attr('value'));
});

/*
 * BUTTON EDIT KARYAWAN
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};
//$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';	
$(document).on('click','#supplier-button-row-edit', function(ehead){ 			  
	$('#supplier-button-row-edit-modal').modal('show')
	.find('#supplier-button-row-edit-content').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	//.load(ehead.target.value);
	.load($(this).attr('value'));
});
/*
 * BUTTON VIEW KARYAWAN
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};
//$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';	
$(document).on('click','#customer-button-row-view', function(ehead){ 			  
	$('#customer-button-row-view-modal').modal('show')
	.find('#customer-button-row-view-content').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	//.load(ehead.target.value);
	.load($(this).attr('value'));
});

/*
 * BUTTON EDIT KARYAWAN
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};
//$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';	
$(document).on('click','#customer-button-row-edit', function(ehead){ 			  
	$('#customer-button-row-edit-modal').modal('show')
	.find('#customer-button-row-edit-content').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	//.load(ehead.target.value);
	.load($(this).attr('value'));
});
/*
 * BUTTON VIEW KARYAWAN
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};
//$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';	
$(document).on('click','#group-product-button-row-view', function(ehead){ 			  
	$('#group-product-button-row-view-modal').modal('show')
	.find('#group-product-button-row-view-content').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	//.load(ehead.target.value);
	.load($(this).attr('value'));
});

/*
 * BUTTON EDIT KARYAWAN
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};
//$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';	
$(document).on('click','#group-product-button-row-edit', function(ehead){ 			  
	$('#group-product-button-row-edit-modal').modal('show')
	.find('#group-product-button-row-edit-content').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	//.load(ehead.target.value);
	.load($(this).attr('value'));
});

/*
 * BUTTON Discount KARYAWAN
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};
//$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';	
$(document).on('click','#databarang-button-row-discount', function(ehead){ 			  
	$('#databarang-button-row-discount-modal').modal('show')
	.find('#databarang-button-row-discount-content').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	//.load(ehead.target.value);
	.load($(this).attr('value'));
});

/*
 * BUTTON Harga KARYAWAN
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};
//$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';	
$(document).on('click','#databarang-button-row-harga', function(ehead){ 			  
	$('#databarang-button-row-harga-modal').modal('show')
	.find('#databarang-button-row-harga-content').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	//.load(ehead.target.value);
	.load($(this).attr('value'));
});

/*
 * BUTTON Promo KARYAWAN
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};
//$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';	
$(document).on('click','#databarang-button-row-promo', function(ehead){ 			  
	$('#databarang-button-row-promo-modal').modal('show')
	.find('#databarang-button-row-promo-content').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	//.load(ehead.target.value);
	.load($(this).attr('value'));
});
/*
 * BUTTON stock
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};
//$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';	
$(document).on('click','#databarang-button-row-stock', function(ehead){ 			  
	$('#databarang-button-row-stock-modal').modal('show')
	.find('#databarang-button-row-stock-content').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	//.load(ehead.target.value);
	.load($(this).attr('value'));
});


/*
 * BUTTON VIEW Discount
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};
//$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';	
$(document).on('click','#databarang-button-row-view-discount', function(ehead){ 			  
	$('#databarang-button-row-view-discount-modal').modal('show')
	.find('#databarang-button-row-view-discount-content').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	//.load(ehead.target.value);
	.load($(this).attr('value'));
});

/*
 * BUTTON EDIT Discount
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};
//$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';	
$(document).on('click','#databarang-button-row-edit-discount', function(ehead){ 			  
	$('#databarang-button-row-edit-discount-modal').modal('show')
	.find('#databarang-button-row-edit-discount-content').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	//.load(ehead.target.value);
	.load($(this).attr('value'));
});


/*
 * BUTTON VIEW Harga
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};
//$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';	
$(document).on('click','#databarang-button-row-view-harga', function(ehead){ 			  
	$('#databarang-button-row-view-harga-modal').modal('show')
	.find('#databarang-button-row-view-harga-content').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	//.load(ehead.target.value);
	.load($(this).attr('value'));
});

/*
 * BUTTON VIEW Harga
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};
//$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';	
$(document).on('click','#databarang-button-row-view-promo', function(ehead){ 			  
	$('#databarang-button-row-view-promo-modal').modal('show')
	.find('#databarang-button-row-view-promo-content').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	//.load(ehead.target.value);
	.load($(this).attr('value'));
});

/*
 * BUTTON EDIT Harga
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};
//$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';	
$(document).on('click','#databarang-button-row-edit-harga', function(ehead){ 			  
	$('#databarang-button-row-edit-harga-modal').modal('show')
	.find('#databarang-button-row-edit-harga-content').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	//.load(ehead.target.value);
	.load($(this).attr('value'));
});

/*
 * BUTTON EDIT Promo
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};
//$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';	
$(document).on('click','#databarang-button-row-edit-promo', function(ehead){ 			  
	$('#databarang-button-row-edit-promo-modal').modal('show')
	.find('#databarang-button-row-edit-promo-content').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	//.load(ehead.target.value);
	.load($(this).attr('value'));
});
/*
 * BUTTON EDIT Promo
*/
$.fn.modal.Constructor.prototype.enforceFocus = function(){};
//$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';	
$(document).on('click','#cara', function(ehead){ 			  
	$('#cara-modal').modal('show')
	.find('#cara-content').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
	//.load(ehead.target.value);
	.load($(this).attr('value'));
});

