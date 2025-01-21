<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking Decisiones de Vida</title>
    <link rel="stylesheet" href="css.css">
</head>
<body>
    <h1>Ranking Decisiones de Vida</h1>
    
    <table>
        <thead>
            <tr>
                <th>idJugador</th>
                <th>Nombre</th>
                <th>Tiempo Total</th>
                <th>Dinero Total</th>
                <th>idPersonaje</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Conexión a la base de datos
            $servidor = "24.2daw.esvirgua.com";
            $user = "user2daw_pr24";
            $pw = "L,!bSo@S4Yu4";
            $dbname = "user2daw_BD2-24";

            $conn = mysqli_connect($servidor, $user, $pw, $dbname);

            // Verificar conexión
            if (!$conn) {
                die("Conexión fallida: " . mysqli_connect_error());
            }

            // Consulta SQL para obtener los datos
            $query = "SELECT idJugador, nombre, tiempoTotal, dineroTotal, idPersonaje FROM Jugador";
            $result = mysqli_query($conn, $query);

            // Verificar si hay resultados y mostrarlos
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['idJugador'] . "</td>";
                    echo "<td>" . $row['nombre'] . "</td>";
                    echo "<td>" . $row['tiempoTotal'] . "</td>";
                    echo "<td>" . $row['dineroTotal'] . "</td>";
                    echo "<td>" . $row['idPersonaje'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No se encontraron datos</td></tr>";
            }

            // Cerrar la conexión a la base de datos
            mysqli_close($conn);
            ?>
        </tbody>
    </table>

    <form action="ClientesBanco.php" method="post" target="_blank">
        <button type="submit">Generar PDF</button>
    </form>
</body>
</html>
