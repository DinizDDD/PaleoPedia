<?php
include("config/database.php");

$id = $_GET['id'] ?? null;

if ($id) {

    $sql = $conn->prepare("SELECT * FROM tax WHERE id = ?");
    $sql->execute([$id]);

    $tax = $sql->fetch(PDO::FETCH_ASSOC);

    if ($tax) {
?>
        <h1><?php echo $tax['id']; ?></h1>
        <h1><?php echo $tax['nome']; ?></h1>
        <h3><?php echo $tax['slug']; ?></h3>
        <h3><?php echo $tax['rank']; ?></h3>
        <h3><?php echo $tax['parent_id']; ?></h3>
        <p><?php echo $tax['descricao']; ?></p>

<?php
    } else {
        echo "Taxonomia não encontrada.";
    }

} else {
    echo "ID não informado.";
}

if ($id) {

    $sql = $conn->prepare("SELECT * FROM images WHERE id = ?");
    $sql->execute([$id]);

    $images = $sql->fetch(PDO::FETCH_ASSOC);

    if ($images) {
?>
        <h1><?php echo $images['id']; ?></h1>
        <img src=<?php echo $images['url'] ?> alt="<?php echo $images['legenda']?>">

<?php
    } else {
        echo "Taxonomia não encontrada.";
    }

} else {
    echo "ID não informado.";
}



?>