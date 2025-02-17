function loadURL(param_id, param_url, param_data) {
	alert('begin loadURL ' + param_id);
	$(param_id).load(param_url,
		param_data,
		function (responseTxt, statusTxt, xhr) {
			if (statusTxt == "success")
				alert("External content loaded successfully!");
			if (statusTxt == "error")
				alert("Error: " + xhr.status + ": " + xhr.statusText);
		}
	);

}
function tampilPagexx(param_menu1, param_menu2) {
	$(".content-wrapper").load("index.php?param_menu1=" + param_menu1 + "&main_id=" + param_menu2,
		{
			main: "040",
			main_act: "010",
			par: "tabcontent1"
		},
		function (responseTxt, statusTxt, xhr) {
			if (statusTxt == "success")
				// alert("External content loaded successfully!");
				if (statusTxt == "error")
					alert("Error: " + xhr.status + ": " + xhr.statusText);
			var tinggiwindow = $(window).height();
			var tinggiheader = $('.main-header').height();
			var tinggicontent = $('.content-header').height();
			//var tinggiisicontent1=tinggiwindow - (tinggiheader+tinggicontent+25);
			var tinggiisicontent1 = tinggiwindow - (tinggiheader + 25);
			//alert(tinggiisicontent1);
			//alert('tinggi berubah !');
			//$("#isicontent1").css( "height",tinggiisicontent1+"px");
			$('#tbl01').dataTable();
			$('#tbl02').dataTable();
			$('#tbl03').dataTable();
			$('#tbl04').dataTable();
			$('#tbl05').dataTable();
			$('#tbl06').dataTable();
			$('#tbl07').dataTable();
			$('#tbl08').dataTable();
		}
	);
}
function cobaxx(param_menu1, param_menu2) {
	//alert ('haiii');
	$(".content-wrapper").load("overlay.php?param_menu1=" + param_menu1 + "&main_id=" + param_menu2,
		{
			main: "040",
			main_act: "010"
		},
		function (responseTxt, statusTxt, xhr) {
			if (statusTxt == "success")
				// alert("External content loaded successfully!");
				if (statusTxt == "error")
					alert("Error: " + xhr.status + ": " + xhr.statusText);
			var tinggiwindow = $(window).height();
			var tinggiheader = $('.main-header').height();
			var tinggicontent = $('.content-header').height();
			//var tinggiisicontent1=tinggiwindow - (tinggiheader+tinggicontent+25);
			var tinggiisicontent1 = tinggiwindow - (tinggiheader + 25);
			//alert(tinggiisicontent1);
			//alert('tinggi berubah !');
			$("#isicontentovl").css("height", tinggiisicontent1 + "px");
			tampilPagexx(param_menu1, param_menu2);
		}
	);
	//alert ('duaaaa');

}

function bukaModal(param1, param2, param3) {
	//alert('begin loadURL ');
	$("#popupsales").load("detail_sales.php?param1=" + param1 + "&param2=" + param2 + "&param3=" + param3,
		'',
		function (responseTxt, statusTxt, xhr) {
			if (statusTxt == "success")
				$('#exampleModal2').modal('show');
			if (statusTxt == "error")
				alert("Data Not Found : " + xhr.status + ": " + xhr.statusText);
		}
	);
}

function bukaModalHelmizz1(param1, param2, param3, param4) {
	//alert('begin loadURL ');
	$(param1).load(param2,
		param3,
		function (responseTxt, statusTxt, xhr) {
			if (statusTxt == "success")
				$(param4).modal('show');
			if (statusTxt == "error")
				alert("Data Not Found : " + xhr.status + ": " + xhr.statusText);
		}
	);
}

function ajaxHelmizz1(param1, param2, param3) {
	//alert('begin loadURL ');
	$(param1).load(param2,
		param3,
		function (responseTxt, statusTxt, xhr) {
			if (statusTxt == "success")
				//alert("success"+param1+param2+param3);
				if (statusTxt == "error")
					alert("Data Not Found : " + xhr.status + ": " + xhr.statusText);
		}
	);

}

function ngilangNongol(param1, param2) {
	//alert('mulai hide '+param1);
	$(param1).hide();
	//alert('mulai show '+param2);
	$(param2).show();
}

function tampilPageyy(param_menu1, param_menu2, param_menu3) {
	$(".content-wrapper").load("index.php?param_menu1=" + param_menu1 + "&main_id=" + param_menu2 + "&param_menu3=" + param_menu3 + "&param_menu4=" + param_menu3,
		{
			main: "040",
			main_act: "010",
			par: "tabcontent1"
		},
		function (responseTxt, statusTxt, xhr) {
			if (statusTxt == "success")
				// alert("External content loaded successfully!");
				if (statusTxt == "error")
					alert("Error: " + xhr.status + ": " + xhr.statusText);
			$('#tbl01').dataTable();
			$('#tbl02').dataTable();
			$('#tbl03').dataTable();
			$('#tbl04').dataTable();
			$('#tbl05').dataTable();
			$('#tbl06').dataTable();
			$('#tbl07').dataTable();
			$('#tbl08').dataTable();
		}

	);
}

function cobayy(param_menu1, param_menu2, param_menu3) {
	//alert ('haiii');
	$(".content-wrapper").load("overlay.php?param_menu1=" + param_menu1 + "&main_id=" + param_menu2,
		{
			main: "040",
			main_act: "010"
		},
		function (responseTxt, statusTxt, xhr) {
			if (statusTxt == "success")
				// alert("External content loaded successfully!");
				if (statusTxt == "error")
					alert("Error: " + xhr.status + ": " + xhr.statusText);
			var tinggiwindow = $(window).height();
			var tinggiheader = $('.main-header').height();
			var tinggicontent = $('.content-header').height();
			//var tinggiisicontent1=tinggiwindow - (tinggiheader+tinggicontent+25);
			var tinggiisicontent1 = tinggiwindow - (tinggiheader + 25);
			//alert(tinggiisicontent1);
			//alert('tinggi berubah !');
			$("#isicontentovl").css("height", tinggiisicontent1 + "px");
			tampilPageyy(param_menu1, param_menu2, param_menu3);
		}


	);


}

function bukaModalHelmizz301(param1, param2, param3, param4) {
	//$('#loading').modal('show');
	$(param1).load(param2,
		param3,
		function (responseTxt, statusTxt, xhr) {
			if (statusTxt == "success") {
				//$('#loading').modal('hide');
				$(param4).modal('show');
			}
			if (statusTxt == "error")
				alert("Data Not Found : " + xhr.status + ": " + xhr.statusText);
		}
	);
}

function klikallcekbox() {
	alert('test');
	$('.cekboxpilih').each(function () { //iterate all listed checkbox items
		this.checked = true; //change ".checkbox" checked status
	});
}

function process_next(paramx1, paramx2, paramx3, paramx4, paramx5, paramx6, paramx7, paramx8, paramx9) {
	if (confirm(paramx1)) {
		$.post(paramx2,
			{
				main: "040",
				main_act: "010",
				main_id: paramx3,
				main_id_key: paramx4
			},
			function (data, status) {
				if (data == 'success') {
					alert(paramx5);
					//alert(data);
					cobayy(paramx6, paramx7, paramx8);
				}
				else {
					alert(data);
					alert(paramx9);
					return false;
				}
			});


	}
}

function submit_form_process(paramy1, paramy2, paramy3, paramy4, paramy5, paramy6, paramy7) {
	if (confirm(paramy7)) {
		alert(paramy1);
		$(paramy1).submit(function (event) {
			// alert('data disubmit');
			//$('#loading').modal('show');
			event.preventDefault(); //prevent default action 
			var post_url = $(this).attr("action"); //get form action url
			var request_method = $(this).attr("method"); //get form GET/POST method
			var form_data = new FormData(this); //Creates new FormData object
			$.ajax({
				url: post_url,
				type: request_method,
				data: form_data,
				contentType: false,
				cache: false,
				processData: false
			}).done(function (response) { //
				//$("#server-results").html(response);
				// alert(response);
				if (response == 'success') {
					alert(paramy2);
					$(".close").click()
					cobayy(paramy3, paramy4, paramy5);
				}
				else {
					alert(paramy6);
					return false;
				}
			});
		});
	};
}

function dispute_process(param1, param2, param3, param4) {
	if (confirm(param1)) {
		cobayy(param2, param3, param4);
	}
}

// chatgpt produce --------	
function redirectWithPost(url, postData) {
	// Buat formulir sementara
	var form = document.createElement("form");
	form.method = "post";
	form.action = url;

	// Tambahkan input untuk setiap data yang ingin Anda kirim
	for (var key in postData) {
		if (postData.hasOwnProperty(key)) {
			var input = document.createElement("input");
			input.type = "hidden";
			input.name = key;
			input.value = postData[key];
			form.appendChild(input);
		}
	}

	// Tambahkan formulir ke dokumen
	document.body.appendChild(form);

	// Submit formulir
	form.submit();

	// Hapus formulir setelah pengiriman
	document.body.removeChild(form);
}

function catatanxx() {
	// Contoh penggunaan
	var targetUrl = "https://example.com/target-page";
	var postData = {
		key1: "value1",
		key2: "value2"
	};

	// Panggil fungsi untuk melakukan redirect dengan metode POST
	redirectWithPost(targetUrl, postData);
}