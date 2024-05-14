<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

require_once "classes/user.php";
$objectUser = new user();
//GET
if(isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    try {
        if($id != null) {
            if($objectUser->delete($id)) {
                header("Location: index.php?deleted");
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
    <?php require_once 'includes/head.php';?>
</head>

<body>
    <!-- Header banner -->
    <?php require_once 'includes/header.php';?>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar menu -->
            <?php require_once 'includes/sidebar.php';?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <h1 style="margin-top: 10px">DatabaseTable</h1>
                <?php
if (isset($_GET['updated'])) {
    echo '<div class="alert alert-info alert-dismissable fade show" role="alert">
                    <strong> User!</strong> Updated successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </div>';
} else if(isset($_GET['deleted'])) {
    echo '<div class="alert alert-info alert-dismissable fade show" role="alert">
                    <strong> User!</strong> Deleted successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </div>';
} else if (isset($_GET['inserted'])) {
    echo '<div class="alert alert-info alert-dismissable fade show" role="alert">
                    <strong> User!</strong> Inserted successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </div>';
} else if (isset($_GET['error'])) {
    echo '<div class="alert alert-info alert-dismissable fade show" role="alert">
                    <strong> DB Error!</strong> something went wrong with your action. Try again
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </div>';
} 
?>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <?php
$query = "SELECT * FROM crud_users";
$stmt = $objectUser->runQuery($query);
$stmt->execute();
?>
                        <tbody>
                            <?php if ($stmt->rowCount() > 0) {
    while ($rowUser = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
                            <tr>
                                <td><?php print($rowUser['id']);?></td>
                                <td>
                                    <a href="form.php?edit_id=<?php print($rowUser['id']);?>
                                    <?php print($rowUser['name']);?>
                                           </a>
                                           </td>

                                    <td><?php print($rowUser['email']);?></td>

                                    <td>
                                        <a href=" index.php?delete_id=<?php print($rowUser['id']);?>"
                                        class="btn btn-danger confirmation">
                                        <span data-feather="trash"></span>
                                    </a>
                                </td>

                            </tr>
                        </tbody>
                        <?php
}
}
?>
                    </table>

                </div>

            </main>

        </div>

    </div>
    <!-- Footer scripts and functions -->
    <?php require_once 'includes/footer.php';?>

    <!-- Custom scripts -->
    <script>
    //Jquery confirmation
    $('.confirmation').on('click', function() {
        return confirm('Are you sure to delete this data?');
    });
    </script>
</body>

</html>