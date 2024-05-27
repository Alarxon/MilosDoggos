<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $edad = $_POST['edad'];
    $genero = $_POST['genero'];
    $nacimiento = $_POST['nacimiento'];
    $opinion = $_POST['opinion'];

    $db = new SQLite3('milos.db');
    $db->enableExceptions(true);

    try {
        $stmt = $db->prepare('INSERT INTO usuarios (nombre, email, direccion, edad, genero, nacimiento, opinion, rol) VALUES (:nombre, :email, :direccion, :edad, :genero, :nacimiento, :opinion, :rol)');
        $stmt->bindValue(':nombre', $nombre, SQLITE3_TEXT);
        $stmt->bindValue(':email', $email, SQLITE3_TEXT);
        $stmt->bindValue(':direccion', $direccion, SQLITE3_TEXT);
        $stmt->bindValue(':edad', (int)$edad, SQLITE3_INTEGER);
        $stmt->bindValue(':genero', (int)$genero, SQLITE3_INTEGER);
        $stmt->bindValue(':nacimiento', $nacimiento, SQLITE3_TEXT);
        $stmt->bindValue(':opinion', $opinion, SQLITE3_TEXT);
        $stmt->bindValue(':rol', 0, SQLITE3_INTEGER);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => $db->lastErrorMsg()]);
        }
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    } finally {
        $db->close();
    }
} else {
    echo json_encode(["status" => "error", "message" => "Request invalido"]);
}

?>