// JavaScript Document

jQuery(function() {
// Contact form................................./

var regVr223 = "<div><span style='font: 14px Arial; color:#000; margin-left:6px;'>sending...</span></div><br />";

$("#send2").click(function(){
		$("#loadBar2").html(regVr223).show();
		var posName2 = $("#posName2").val();
        var posTel2 = $("#posTel2").val();
        var posEmail2 = $("#posEmail2").val();
		var posText2 = $("#posText2").val();
		$.ajax({
			type: "POST",
			url: "contact2.php",
			data: {"posName2": posName2, "posTel2": posTel2, "posEmail2": posEmail2, "posText2": posText2},
			cache: false,
			success: function(response){
		var messageResp = "<p style='font-family:Arial; font-size:14px; color:#000; padding:10px; margin:0px; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px;'>Dear <strong>";
		var resultStat = "!</strong> Message sent!</p>";
		var oll = (messageResp + posName2 + resultStat);
				if(response == 1){
                $("#loadBar2").html(oll).fadeIn(3000);
				$("#posName2").val("");
                $("#posTel2").val("");
                $("#posEmail2").val("");
				$("#posText2").val("");
				} else {
		$("#loadBar2").html(response).fadeIn(3000); }
										}
		});
		return false;
});


});
