<?php  
require('fpdf.php');

// Crear clase PDF heredada de FPDF
class PDF extends FPDF
{
    // Cabecera de página
    function Header(){
        // Logo
        $this->Image('logo.png',10,8,33);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(30,15,'Ranking Decisiones de Vida');
        // Salto de línea
        $this->Ln(20);
    }

    // Pie de página
    function Footer(){
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
    }

    // Cargar datos de la base de datos
    function LoadData($conn){
        // Ejecutamos una consulta SQL para obtener los jugadores
        $query = "SELECT idJugador, nombre, tiempoTotal, dineroTotal, idPersonaje FROM Jugador";
        $result = mysqli_query($conn, $query);
        
        $loadedData = [];
        
        // Recorremos los resultados y los guardamos en un array
        while ($row = mysqli_fetch_assoc($result)) {
            $loadedData[] = [$row['idJugador'], $row['nombre'], $row['tiempoTotal'], $row['dineroTotal'], $row['idPersonaje']];
        }
        
        return $loadedData;
    }

    // Tabla básica
    function BasicTable($header, $data){
        // Cabecera
        foreach($header as $col) {
            $this->Cell(35, 7, $col, 1);
        }
        $this->Ln();
        // Datos
        foreach ($data as $row) {
            $this->Cell(35, 6, $row[0], 1);
            $this->Cell(35, 6, $row[1], 1);
            $this->Cell(35, 6, $row[2], 1);
            $this->Cell(35, 6, $row[3], 1);
            $this->Cell(35, 6, $row[4], 1);
            $this->Ln();
        }
    }
}

    // Conectar a la base de datos (ajusta los valores según tu configuración)
    $servidor = "24.2daw.esvirgua.com"; // Nombre del servidor
    $user = "user2daw_pr24";     // Usuario de la base de datos
    $pw = "L,!bSo@S4Yu4";  // Contraseña del usuario
    $dbname = "user2daw_BD2-24"; // Nombre de la base de datos

    $conn = mysqli_connect($servidor, $user, $pw, $dbname);

    // Verificamos si la conexión fue exitosa
    if (!$conn) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    // Crear PDF
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->SetFont('Arial', '', 14);
    $pdf->AddPage();

    // Títulos de las columnas
    $header = ['idJugador', 'Nombre', 'Tiempo Total', 'Dinero Total', 'idPersonaje'];

    // Cargar datos desde la base de datos
    $loadedData = $pdf->LoadData($conn);

    // Generar tabla con los datos
    $pdf->BasicTable($header, $loadedData);

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);

    // Salida del PDF
    $pdf->Output();
?>
