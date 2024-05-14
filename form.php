<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

require_once "classes/user.php";
$objectUser = new user();
//GET
if(isset($_GET["edit_id"])) {
    $id = $_GET["edit_id"];
    $stmt = $objectUser->runQuery("SELECT * FROM crud_users WHERE id = :id");
    $stmt->execute(array(":id" => $id));
    $rowUser = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $id = null;
    $rowUser = null;
}
//POST
if (isset($_POST['btn-save'])) {
    $name = strip_tags($_POST['name']);
    $email = strip_tags($_POST['email']);
    try {
        if ($id != null) {
            if ($objectUser->update($name, $email, $id)) {
                $objectUser->redirect('index.php?updated');
            }
        } else {
            if ($objectUser->insert($name, $email)) {
                $objectUser->redirect('index.php?inserted');
            } else {
                $objectUser->redirect('index.php?error');
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head metas, css and tittle -->
    <?php require_once 'includes/head.php'; ?>
</head>

<body>
    <!-- Header banner -->
    <?php require_once 'includes/header.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar menu -->
            <?php require_once 'includes/sidebar.php'; ?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <h1 style="margin-top: 10px">Add/ Edit Users</h1>
                <p>Required fields are in(*)</p>
                <form method="posr">
                    <div>
                        <label for="id">ID</label>
                        <input class="form-control" type="text" name="id" id="id" value="<?php print($rowUser['id']);?>" readonly>
                    </div>
                    <div>
                        <label for="name">Name *</label>
                        <input class="form-control" type="text" name="name" id="name"
                            placeholder="First name and Last name" value="<?php print($rowUser['name']);?>" Required maxlength="100">
                    </div>
                    <div>
                        <label for="email">Email *</label>
                        <input class="form-control" type="text" name="email" id="email" placeholder="johndoe@gmail.com"
                            value="<?php print($rowUser['email']);?>" Required maxlength="100">
                    </div>
                    <input class="btn btn-primary mb-2" type="submit" name="btn-save" value="Save">
                </form>
            </main>

        </div>

    </div>
    <!-- Footer scripts and functions -->
    <?php require_once 'includes/footer.php'; ?>
</body>

</html>