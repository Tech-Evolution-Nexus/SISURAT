<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "Email: " . htmlspecialchars($_POST['email']) . "<br>";
    echo "No HP: " . htmlspecialchars($_POST['nohp']) . "<br>";
    // etc.
}
