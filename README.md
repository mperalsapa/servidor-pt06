# servidot-pt06
# Informacio del repositori
Enllaç al repositori public : https://github.com/mperalsapa/servidor-pt06

Enllaç a la versio online : https://sp6.mperalsapa.cf

Dintre d'aquest repositori tamb e es troba la documentacio, realitzada amb phpdocumentor. Si s'accedeix a la web, tambe es pot accedir a la documentacio. Per exemple: https://sp6.mperalsapa.cf/phpdoc

L'esquema i dades de la base de dades es [aqui](pt06_marc_peral.sql)

## Posar en martxa aquest servei
### Configurar les variables d'entorn
Primer de tot s'ha de configurar al fitxer env.php el domini amb el que s'accedeix i la ruta que es el fitxer index.php.
Per exemple si el meu domini es marc-pt.local en el fixer env posare en domini ```$baseDomain = "http://marc-pt.local"; ``` I si la ruta del fitxer es "servidor/web/uf2/pt04" al fitxer env haig de posar 
```$baseUrl = "/servidor/UF3/pt06/";``` . Molt important que tingui barra al principi i al final. En cas de trobar-se en l'arrel nomes posarem una barra ```$baseUrl = "/";```

Una vegada configurades les variables de la url, afegirem les credencials de la base de dades per a un funcionament basic.
Aquestes credencials s'han de configurar en aquestes variables

```php
$mysqlUser = "usuari";
$mysqlPassword = "contrasenya";
$mysqlHost = "mysql.local";
$mysqlDB = "p04";
```

### Crear base de dades
Executarem el fitxer [sql](pt06_marc_peral.sql) en mysql per crear la base de dades amb les taules necessaries.

---
# Parts del projecte
Aquest projecte esta pensat per fer-se servir com a base de dades de productes dintre d'una "empresa" o entorn privat. Es poden generar qr de nous productes que han arrivat, i mes endevant un altre persona pot llegir aquest qr i consultar les dades internes d'aquest producte.
## Generar QR
La pagina de generar QR consta d'un formulari
Aquest formulari valida les dades, i en cas de que siguin valides, les insereix a la base de dades. Una vegada inserides les dades, generem el QR amb el serial number de les dades inserides. El QR consta de un text de control (per determinar si el qr es nostre o d'un altre servei) i del numero de serie. Per exemple ```mperalQR:numero-de-serie```

## Llegir QR
A l'hora de llegir el QR validem que el contingut tingui el text de control (en el meu cas ```mperalQR:```), i si tot es correcte demanem a la base de dades el numero de serie. Finalment mostrem les dades a l'usuari.

