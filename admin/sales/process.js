function ProcessReq()
{
	var urID = $("#urID").val();
	var orID = $("#orID").val();
	$.post()
	$.post("sendReq.php", { urID: urID, orID: orID},
   function(data) 
   {
     alert(data);
     window.location.href='?openOrder='+orID;
   });
}