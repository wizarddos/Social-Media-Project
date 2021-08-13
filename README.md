# Social-Media-Project

Przepraszam za literówkę w 1 commit'cie


## Jak uruchomić
potrzeba:
pakiet typu XAMPP WAMPP etc.
lub
Serwer z interpreterem php (najlepiej Apache) + Baza MYSQL
obsługujący pliki .htaccess

kroki: 
 - pobierz lub sklonuj repo na swój komputer do folderu interpretera (Windows w XAMPP C:\xampp\htdocs linux ubuntu przy manualnej instalacji /var/www/html/
 - zaimportuj dump z bazą do swojego MYSQL do bazy o nazwie social-media-project
 - GOTOWE! wejdź pod adres http://localhost/Social-Media-Project/
Potencjalne problemy związane z uprawnieniami dla baz mogą być przy linuxach 
  wtedy wystarczy podmienić dane do bazy znajdują się w includes/connect.php w zmiennych $db_user i $db_pass
  
W razie jakichkolwiek problemów napisz issue
