<?php
if (isset($_SESSION['success'])) { ?>
    <div class="alert alert-success alert-dismissable fade show">
        <button class="close" data-dismiss="alert" aria-label="close">x</button>
        <strong>Success!</strong>
        <?= $_SESSION['success']; ?>
    </div>
<?php
    unset($_SESSION['success']);
}
?>

<?php
if (isset($_SESSION['del'])) { ?>
    <div class="alert alert-danger alert-dismissable fade show">
        <button class="close" data-dismiss="alert" aria-label="close">x</button>
        <strong>Changes saved.</strong>
        <?= $_SESSION['del']; ?>
    </div>
<?php
    unset($_SESSION['del']);
}
?>

<?php
if (isset($_SESSION['edit'])) { ?>
    <div class="alert alert-success alert-dismissable fade show">
        <button class="close" data-dismiss="alert" aria-label="close">x</button>
        <strong>Changes saved.</strong>
        <?= $_SESSION['edit']; ?>
    </div>
<?php
    unset($_SESSION['edit']);
}
?>