<?php
session_destroy();

if (isset($_GET['accountdelete']) && $_GET['accountdelete'] != "") {
    echo "<script type='text/javascript'>
            location = 'index.php?page=home&accountdelete=success'
        </script>";
}
?>
<script type="text/javascript">
    location = "index.php?page=home&logout=success"
</script>