Projekt przygotowany na zaliczenie przedmiotu Web Applications.
Schemat bazy danych dostepny w screenshocie.

Lokalny serwer postawiony na XAMPPie
Apache/2.4.37 (Win32) OpenSSL/1.1.1a PHP/7.3.1

Strona pozwalająca na logowanie się na własne konto i obstawianie zakładów. 
Dla uproszczenia, obstawiany zakład zawsze jest za 1000 zł. 


Strona zaczyna się od login.php

W stronie logowania zastosowałem proste sprawdzenie czy hasło przetrzymowane w formie jawnej w bazie danych pasuje do wpisywanego loginu.

możliwośc zalogowania na 3 rodzaje kont. Na konta można wejść bezpośrednio używając adresu.

/admin.php
Login : admin
Hasło : admin
Admin ma możliwość dodawania nowych użytkowników, usuwania ich i edytowania. 
Łączenie z bazą danych, brak podstawowych sprawdzeń na powtarzające się rekordy.
Strona admina została przygotowana przy użyciu AJAXa.

/moderator.php
Login : moderator
Hasło : moderator
Moderator ma możliwość dodawania nowych zakładów.

/gracz.php
Strona w całości zrobiona na samym PHP-ie. No może po za lekkim użyciem bootstrapa dla nadania lekkiej estetyki.

Po wejściu na stronę gracz ustalany jest na podstawie tego co trzymane jest w sesji. Do sesji gracz wpisuje sie na stronie logowania.
Po ustaleniu wyświetlany jest stan konta gracza oraz zakłady które zostały przez niego obstawione.
Brak możliwości ponownego obstawiania.
Balans konta jest aktualizowany na bierząco przy każdym nowym zakładzie.

Kod gracz.php tworzona metodą spaghetti code.