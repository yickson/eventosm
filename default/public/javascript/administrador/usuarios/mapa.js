// Clase para el manejo de API de google y creacion de marcadores

class Mapa {

    constructor() {
       this.mapa        = null;
       this.geocoder    = new google.maps.Geocoder();
       this.initLatLng  = {lat: -33.447898, lng: -70.667972};
       this.markers     = [];
       this.marker      = null;
       this.coordenadas = null;
    }

    initMap(calle, latitud, longitud , draggable, time) {
       if(latitud != "" && longitud !=""){
           this.coordenadas =  {lat: parseFloat(latitud), lng: parseFloat(longitud)};
       }
       this.buscarDireccion(this.mapa, this.geocoder, this.initLatLng, calle,  this.markers, this.marker, this.coordenadas, draggable, time);
    }

    buscarDireccion(mapa, geocoder, initLatLng, calle,  marcadores, marcador, coordenadas, draggable, time){
        geocoder.geocode( { 'address': calle,
                                componentRestrictions: {
                                    country : 'CL',
                                    route   : calle,
                            }},
        function(results, status) {

            if (status == 'OK') {
                console.log(results[0]);
                var mapOptions = {
                    center: results[0].geometry.location,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                setTimeout(function(){
                    $("#loadmap").addClass("hidden")
                    mapa = new google.maps.Map($("#map").get(0), mapOptions);
                    mapa.fitBounds(results[0].geometry.viewport);
                    if(coordenadas == null){
                        coordenadas = results[0].geometry.location;
                    }
                    var markerOptions = { position: coordenadas, draggable: draggable, animation: google.maps.Animation.DROP}
                    var marker = new google.maps.Marker(markerOptions);
                    marker.setMap(mapa);
                    marcadores.push(marker);
                    marcador = marker;
                    $("#latitud").val(coordenadas.lat);
                    $("#longitud").val(coordenadas.lng);
                    // Escucha Evento Click
//                    mapa.addListener('click', function(e) {
//                        console.log(results[0]);
//                        for (var i = 0; i < marcadores.length; i++) {
//                            marcadores[i].setMap(null);
//                        }
//                        var marker = new google.maps.Marker({
//                            position: e.latLng,
//                            draggable: true,
//                            animation: google.maps.Animation.DROP,
//                            map: mapa
//                        });
//                        //marker.addListener('click', toggleBounce);
//                        marker.setMap(mapa);
//                        mapa.panTo(e.latLng);
//                        marcadores.push(marker);
//                        marcador = marker;
////                        $("#calle").val(results[0].address_components[0].long_name);
//                    });
                    //** Fin evento click **//
                    google.maps.event.addListener(marcador, "dragend", function(event) {
                        $("#latitud").val(event.latLng.lat());
                        $("#longitud").val(event.latLng.lng());
                      });

                }, time);

            } else {
                setTimeout(function(){
                    $("#loadmap").addClass("hidden")
                    mapa = new google.maps.Map(document.getElementById('map'), {
                        zoom: 12,
                        center: initLatLng
                    });

                    // Escucha Evento Click
                    mapa.addListener('click', function(e) {
                        console.log(results[0]);
                        for (var i = 0; i < marcadores.length; i++) {
                            marcadores[i].setMap(null);
                        }
                        var marker = new google.maps.Marker({
                            position: e.latLng,
                            map: mapa
                        });
                        mapa.panTo(e.latLng);
                        marcadores.push(marker);
//                        $("#calle").val(results[0].address_components[0].long_name);
                    });
                    //** Fin evento click **//

                }, 3000);
            }
        });
    }


    recargarMapa(calle, latitud, longitud , draggable, time){
        if(latitud != "" && longitud !=""){
            this.coordenadas =  {lat: parseFloat(latitud), lng: parseFloat(longitud)};
        }
        console.log(this.coordenadas );
        this.buscarDireccion(this.mapa, this.geocoder, this.initLatLng, calle, this.markers, this.marker, null, draggable, time);
    }

    setCalle(calle){
        $("#calle").val(calle);
    }

    setRegion(region){
        $("#region").val(region);
    }

    setComuna(comuna){
        $("#comuna").val(comuna);
    }

    setNumero(numero){
        $("#numero").val(numero);
    }

    setTipo(tipo){
        $("#tipo").val(tipo);
    }

    setAdicional(adicional){
        $("#adicional").val(adicional);
    }
}
