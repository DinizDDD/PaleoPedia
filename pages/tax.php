<h1>TAXÔNOMIA</h1>

<?php
include("config/database.php");

$id = $_GET['id'] ?? null;

if ($id) {

    $sql = $conn->prepare("SELECT * FROM tax WHERE id = ?");
    $sql->execute([$id]);

    $tax = $sql->fetch(PDO::FETCH_ASSOC);

    if ($tax) {
?>

        <h1><?php echo $tax['nome']; ?></h1>
        <p><?php echo $tax['descricao']; ?></p>
<?php
    } else {
        echo "Dinossauro não encontrado.";
    }

} else {
    echo "ID não informado.";
}
?>