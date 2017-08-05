GEOLOCATION
===================


Geolocation è un plugin per october cms che permette di effettuare diverse operazioni su indirizzi e coordinate, include un behavior per calcolare la distanza derivato da:[Laravel Geographical](https://github.com/malhal/Laravel-Geographical). Inoltre aggiunge dei campi di geolocalizzazione a RainLab Blog

--------------------

Behaivoir
-------------
Campi aggiunti a *RainLab.Blog*:
```
float geo_lat     // latitudine
float geo_lng     // longitudine
text geo_components //contiene il json dei componenti
```

### 1. Distance
Trova la distanza degli elementi del database da una posizione specifica.

$query = Model::distance($latitude, $longitude);
$asc = $query->orderBy('distance', 'ASC')->get();

### 2. Geofence
Trova gli elementi del database all'interno di un cerchio.

$query = Model::geofence($latitude, $longitude, $inner_radius, $outer_radius);
$all = $query->get();




Installazione
-------------

Questo plugin è ancora in fase sperimantale, pertanto non è ancora possibile installarlo tramite il normale processo di installazione di October CMS.

 - per installare il pacchetto, vai nella cartella `plugins` dell'installazione di october e clona questo repository nella cartella `inerba/geolocation`.
   `git clone https://github.com/inerba/october-geolocation.git inerba/geolocation`

 - vai nella cartella appena creata: `inerba/geolocation` e installa tutte le dipendenze con `composer install`

----------


## Filtri twig a disposizione

#### geo\_geocode
`{{ geo_geocode(string $map_address, $all_components=false, $cache_duration = 10080) }}`

Converte l'indirizzo testuale inserito in coordinate geografiche sfruttando le api di google, restutuisce una stringa con le coordinate, ma è possibile impostando `$all_components = true` ottenere un oggetto completo.

esempio di output per `{{ geo_geocode('Alatri') }}`:
`41.7252936, 13.3412036`
 

esempio di output per `{{ geo_geocode('Alatri', true) }}`: 

```
+"address": "03011 Alatri FR, Italy"
  +"coordinates": {#1241
    +"lat": 41.7252936
    +"lng": 13.3412036
  }
  +"components": {#1236
    +"locality": {#1239
      +"long": "Alatri"
      +"short": "Alatri"
    }
    +"city": {#1168
      +"long": "Alatri"
      +"short": "Alatri"
    }
    +"province": {#1235
      +"long": "Provincia di Frosinone"
      +"short": "FR"
    }
    +"region": {#1238
      +"long": "Lazio"
      +"short": "Lazio"
    }
    +"country": {#1232
      +"long": "Italy"
      +"short": "IT"
    }
    +"postal_code": {#1237
      +"long": "03011"
      +"short": "03011"
    }
  }
}
``` 

#### geo\_reverse
`{{ geo_reverse(float $lat, float $llng, bool $all_components=false, int $cache_duration = 10080) }}`

Converte le coordinate geografiche in un indirizzo testuale sfruttando le api di google, è possibile impostando `$all_components = true` ottenere un oggetto completo (come filtro precedente).

esempio di output per `{{ geo_geocode(41.7252936, 13.3412036) }}`:
`Via S. Francesco, 31, 03011 Alatri FR, Italy`

#### geo\_distance
`{{ geo_distance(string $origin, string $destination, string $mode = 'driving', int $cache_duration = 10080) }}`

Restituisce la distanza in km sfruttando le api di google e la formula di [Vincenty](https://en.wikipedia.org/wiki/Vincenty%27s_formulae) per la distanza in linea d'aria, le modalità a disposizione sono: driving, bicycling e walking

esempio di output per `{{ geo_geocode('Alatri', 'Frosinone', 'walking') }}`:
```
{#1237
  +"routes": {#1241
    +"text": "10.8 km"
    +"value": 10775
  }
  +"air": {#1244
    +"text": "9.1 km"
    +"value": 9125
  }
  +"directions": {#1238
    +"distance": {#1241}
    +"duration": {#1171
      +"text": "2 hours 9 mins"
      +"value": 7755
    }
    +"end_address": "Frosinone, Province of Frosinone, Italy"
    +"end_location": {#1242
      +"lat": 41.6432209
      +"lng": 13.347279
    }
    +"start_address": "03011 Alatri FR, Italy"
    +"start_location": {#1245
      +"lat": 41.7252511
      +"lng": 13.3411465
    }
    +"steps": array:19 [
      0 => {#1165
        +"distance": {#1247
          +"text": "14 m"
          +"value": 14
        }
        +"duration": {#1164
          +"text": "1 min"
          +"value": 13
        }
        +"end_location": {#1163
          +"lat": 41.7251608
          +"lng": 13.3412672
        }
        +"html_instructions": "Head <b>southeast</b> toward <b>Via S. Francesco</b>"
        +"polyline": {#1225
          +"points": "ymt}FeulpAPW"
        }
        +"start_location": {#1162
          +"lat": 41.7252511
          +"lng": 13.3411465
        }
        +"travel_mode": "WALKING"
      }
      1 => {#1160
        +"distance": {#1161
          +"text": "0.4 km"
          +"value": 416
        }
        +"duration": {#1159
          +"text": "6 mins"
          +"value": 341
        }
        +"end_location": {#1158
          +"lat": 41.7228076
          +"lng": 13.3443323
        }
        +"html_instructions": "Continue onto <b>Circonvallazione Portadini</b>"
        +"polyline": {#1157
          +"points": "gmt}F}ulpABGDCHGPITGVIP?P@PBNFZPD@F?JCJGTQPQLUVi@Ri@Pk@ZwAV_Af@eBT_AHa@F[@S"
        }
        +"start_location": {#1156
          +"lat": 41.7251608
          +"lng": 13.3412672
        }
        +"travel_mode": "WALKING"
      }
      
      2 => [...]
    ]
    +"traffic_speed_entry": []
    +"via_waypoint": []
  }
}
```

#### geo\_reverse\_distance
`{{ geo_reverse_distance(array $origin_latlng, array $destination_latlng, string $mode="driving", int $cache_duration = 10080) }}`

Come **geo_reverse**, solo che qui partiamo dalle coordinate geografiche

esempio: `{{ geo_reverse_distance([41.7252936, 13.3412036],[41.6431139, 13.3471775],"walking") }}`:

#### geo\_map
`{{ map(string $map_address, string $height='400px', string $width='100%', int $zoom=15, string $mapType="ROADMAP", bool $marker=true) }}`

crea la mappa a partire dall'indirizzo, è possibile specificare il fattore di zoom, il tipo di mappa: ROADMAP, SATELLITE, HYBRID e TERRAIN le dimensioni e la visibilità del marker.

## Uso dei metodi statici

Puoi usare tutti i filtri come metodi statici, basta che includi la classe e non usi il prefisso *geo_*

```php
use Inerba\Geolocation\Classes\Geolocation as Geo;

echo Geo::geocode('Alatri'); // return '41.7252936, 13.3412036'

```


