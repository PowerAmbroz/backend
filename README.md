# backend - Honeti - Rekrutacja

#1. Instalacja paczki
* W terminalu wykorzystać composer install w celu instalacji paczki

#2. Instalacja bazy danych

1. Przygotowanie bazy danych według własnego uznania
2. Skopiowac plik .env-sampla i przemianować go na .env
3. U dołu pliku .env znaleźc linię:
* DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7"
Podmienić:
* db_user na twojego użytkownika bazy danych
* db_password na twoje hasło, którego uzywasz by zalogować się na wyżej wymienionego użytkownika
* db_name na nazwę utworzonej przez ciebie bazy danych
* 127.0.0.1:3306 na adres IP twojej bazy danych 

## Upewnij się, że wszystko zostało poprawnie wpisane

4. W terminalu wprowadź komendę: php bin/conosle doctrine:migrations:migrate . 
Komenda ta wykorzysta obecny w plikach kod migracji i utworzy potrzebne ci tabele.