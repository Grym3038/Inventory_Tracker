<?php
/**
 * Title: Error View
 * Purpose: To provide a page for displaying an error title and body
 */
?>

<?php include('Views/_partials/header.php'); ?>

<h1>
    <?php echo $title; ?>
</h1>
<p>
    <?php echo $body; ?>
</p>
<p>
    <a href="." class="btn btn-primary">
        Go Home
    </a>
</p>

<?php include('Views/_partials/footer.php'); ?>
