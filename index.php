<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // url a scrapear: http://www.consbuenosaires.esteri.it/Consolato_BuenosAires
        // id a guardar: ctl00_cphLeft_displayNews
        
        // bajo contenido:
      
        
        //URL a scrapear
        $url = "http://www.consbuenosaires.esteri.it/Consolato_BuenosAires";
        
        // Descarga
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "User-Agent: ScrapAgent/1.0");
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $html = curl_exec($ch);
        curl_close($ch);

        // Parseo
        $dom = new DOMDocument;
        @$dom->loadHTML($html);
        $noticias = $dom->getElementById('ctl00_cphLeft_displayNews');
        $contenido = $noticias->nodeValue;
            
        // el $contenido lo comparo con el último en la base de datos
        // si es igual no pasa nada
        // si es distinto, disparo correo, inserto último nuevo
        
        
        
        $file = 'consulado.txt';
        
        $anterior = file_get_contents($file);

        if ($anterior == $contenido)
            {
                echo "No pasa nada";
            }
        else 
            {
                echo "Hay diferencias!! envío mail";
                
                // Envío correo
                
                // multiple recipients
                $to  = 'fabiomb@gmail.com' . ', '; // note the comma
                $to .= 'gimena@gmail.com';

                // subject
                $subject = '#### CONSULADO ####';

                // message
                $message = 'Contenido del área de noticias: \n\n '.$contenido;

                // Email
                mail($to, $subject, $message);
                
                // Actualizo:
                file_put_contents($file, $contenido);
            }

        
        
            
            
        ?>
    </body>
</html>
