<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
					"http://www.w3.org/TR/html4/loose.dtd">
<html lang="de">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="//cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<link href="//cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" >
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col">Begegnungen von <!--Anfangsdatum--> bis <!--Enddatum--></div>
  </div>
  <!-- BEGIN Liga -->
  <div class="row">
    <div class="col"><!--Liganame--></div>
  </div>
  <div class="row">
    <div class="col">
      <div class="container">
	<!-- BEGIN Inhalt -->
	<div class="row">
	  <div class="col-1"><!--Spieltag--></div>
	  <div class="col-1"><!--Datum--></div>
          <div class="col-1"><!--Uhrzeit--></div>
          <div class="col-5"><!--Heim--> <!--Iconheim-->&nbsp;-&nbsp;<!--Icongast--> <!--Gast--></div>
          <div class="col-1"><!--Tore--></div>
          <div class="col-1"><!--Tabellenlink--></div>
          <div class="col-1"><!--Notiz--></div>
          <div class="col-1"><!--Spielbericht--></div>
  	  </div>
	  <!-- END Inhalt -->
	</div>
     </div>
  </div>
  <!-- END Liga -->
  <div class="row">
    <div class="col text-end"><small><!--VERSION--></small></div>
  </div>
</div>
  <!-- JavaScript Bundle with Popper -->
   <script type="text/javascript" src="//cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
   <script type="text/javascript">
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
      })
   </script>
  </body>
</html>