$(document).ready(function() {

   var  $this = {
                "loadmapaOn"   :  $("#loadmap").removeClass("hidden"),
                "loadmapaOff"  :  $("#loadmap").addClass("hidden"),
                "mapa"         : new Mapa(),
                "drag"    : $("#map").data("drag"),
                "time"     : $("#map").data("time"),
                "latitud"  : $("#latitud").val(),
                "longitud" : $("#longitud").val(),
                "lugar"    : $("#lugar").val()
        };
    
    if($this.latitud == "" || $this.longitud == ""){
         console.log("drag:"+ $this.drag);
            $this.mapa.initMap("", "", "", $this.draggable, $this.time);
    }else{
        console.log("drag:"+$this.draggable);
        $this.mapa.initMap($this.lugar, $this.latitud, $this.longitud, $this.drag, $this.time );
    }
    $("#lugar").on("blur" , function(){
           $this.mapa.recargarMapa($(this).val(), $this.latitud, $this.longitud, $this.drag, $this.time );
    });
});
