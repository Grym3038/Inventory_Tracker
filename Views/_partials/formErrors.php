<?php
/**
 * Title: Form Errors Partial
 * Purpose: To format error messages for use on a form
 */
?>

<?php if (isset($errors) && count($errors) > 0) : ?>
    <ul class="text-danger">
        <?php foreach ($errors as $error) : ?>   
            <li>
                <?php echo $error; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
