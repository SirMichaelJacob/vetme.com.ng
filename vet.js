function SubmitForm()
{
	var vet = $("#vet").val();
	var sid = $("#sid").val();
	// var splitVet = vet.split("|");
	// var id=splitVet[0];
	$.post()
	$.post("vetter.php", { vet: vet , sid: sid},
   function(data) 
   {
     // alert(data);

     // window.location.href='?view='+vet;
     // $('#successmodal').modal('show');
   });
	
	$('#successmodal').modal('show');
}