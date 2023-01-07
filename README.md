# Παιχνίδι Dominoes




## Κανόνες

 - 2 Παίκτες.
 - Με την σύνδεση 2 παικτών μοιράζονται 7 Domino Tiles στον κάθε παίκτη.
 - Ο τελευταίος παίκτης παίζει πρώτος.
 - Οι παίκτες παίζουν με τη σειρά μέχρι να τελειώσουν τα Domino Tiles κάποιο παίκτη.

## Game API

| URL |METHOD  |DESCRIPTION
|--|--|--
| /Library/add_to_board.php |POST|{functionname: insert_right_of} Εισάγει στον πίνακα το input_tile δεξιά απο το tile_on_board με τον κατάλληλο προσανατολισμό.
| /Library/add_to_board.php |POST/GET|{functionname: insert_left_of} Εισάγει στον πίνακα το input_tile αριστερά απο το tile_on_board με τον κατάλληλο προσανατολισμό.
|/Library/add_user.php|POST/GET|Καλεί το check_current_user.php και αλλάζει την τιμή Token του Session.
|/Library/board_status.php|POST/GET| Επιστρέφει την κατάσταση του Board.
|/Library/change_status.php|POST/GET|Αλλάζει το status σε περίπτωση νικητή.
|/Library/check_current_users.php|POST/GET|Ελέγχει τον αριθμό χρηστών και δίνει τις κατάλληλες τιμές.
|/Library/check_for_move.php|POST/GET| Ελέγχει την κατάσταση του πίνακα και επιστρέφει ολες τις πιθανές κινήσεις.
|/Library/db_connect.php|POST/GET|Συνδέεται με τη βάση.
|/Library/destroy_session.php|POST/GET|Τελειώνει το Session και διαγραφει τον χρήστη απο τη βάση.
|/Library/get_player_turn.php|POST/GET|Επιστρέφει την τρέχουσα σειρά του παίκτη.
|/Library/initalize_hand.php|POST/GET|Δημιουργεί το "χέρι" του κάθε παίκτη.
|/Library/update_last_action.php|POST/GET|Αλλάζει την τιμή της ώρας του παίκτη σε κάθε κίνηση ωστε να μήν αποσυνδεθεί.

## Βάση παιχνιδιού
### Board
| Μεταβλητή|Περιγραφή|Τύπος
|--|--|--
|tile_id|Tile που έχει παιχτεί|VARCHAR(50)
|right_of|Δεξιά απο ποιό Tile βρίσκεται|VARCHAR(50)
|left_of|Αριστερά απο ποιό Tile βρίσκεται|VARCHAR(50)
|is_center|Αν το Tile βρίσκεται στο κέντρο|TINYINT(4)
|order_played|Σειρά που έπεσε|INT(11)
|orientation|Προσανατολισμός|INT(11)

### Game
| Μεταβλητή|Περιγραφή|Τύπος
|--|--|--
|player_turn|Σειρά του παίκτη|ENUM('One','Two')
|status|Κατάσταση του παιχνιδιού ανάλογα με τους παίκτες|ENUM('not active','initialized','started','ended')
|winner|Νικητής|VARCHAR(50)
|row|(Δεν χρησιμοποιείται) Διατηρεί την τιμή του παιχνιδιού σε περίπτωση πολλαπλών παιχνιδιών|TINYINT(4)

### Hand
| Μεταβλητή|Περιγραφή|Τύπος
|--|--|--
|player_token|Token του παίκτη|VARCHAR(100)
|status|Το id του Tile|VARCHAR(100)

### Tile (Δεν χρησιμοποιείται)
| Μεταβλητή|Περιγραφή|Τύπος
|--|--|--
|id|Το ID του Tile στον πίνακα|INT(11)
|tile_id|Το ID του Tile που θα χρησιμοποιείται|VARCHAR(50)
|tile_first_number|Πρώτος αριθμός του Tile|INT(11)
|tile_second_number|Δεύτερος αριθμός του Tile|INT(11)

### User
| Μεταβλητή|Περιγραφή|Τύπος
|--|--|--
|username|Το ID του Tile στον πίνακα|VARCHAR(25)
|last_action|Το ID του Tile που θα χρησιμοποιείται|TIMESTAMP
|token|Πρώτος αριθμός του Tile|VARCHAR(100)
|player_number|Δεύτερος αριθμός του Tile|ENUM('One','Two')
