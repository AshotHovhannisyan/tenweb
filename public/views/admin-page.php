
<?php

$paged = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
$sval = '';
if (isset($_GET['twebs'])){
    $sval = $_GET['twebs'];
}

?>
<div class="tweb-all-contacts">


    <h2>All Contacts</h2>
    <form action="<?php echo admin_url( 'admin.php' ); ?>">
        <label for="search-contacts"></label>
        <input type="hidden" name="page" value="show-form">
        <input type="hidden" name="pagenum" value="<?php echo $paged?>">
        <input type="text" name="twebs" id="search-contacts" value="<?php echo $sval?>">
        <input type="submit" value="search">
    </form>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Gender</th>
            <th>File</th>
            <th>date</th>
        </tr>
        <?php foreach ($contacts as $contact):
            $img = $contact->file ? '<img src="' . TWEBCF_IMAGES_URL . $contact->file .'" alt="' . $contact->name . '">' : "";
            ?>

            <tr>
                <td><?php echo $contact->name; ?></td>
                <td><?php echo $contact->email; ?></td>
                <td><?php echo $contact->gender; ?></td>
                <td><?php echo $img?></td>
                <td><?php echo date("Y-m-d", strtotime($contact->date)); ?></td>
            </tr>
        <?php endforeach;?>
    </table>
    <?php wp_reset_query(); ?>
    <?php
    $page_links = paginate_links( array(
        'base' => add_query_arg( 'pagenum', '%#%' ),
        'format' => '',
        'prev_text' => __( '&laquo;', 'text-domain' ),
        'next_text' => __( '&raquo;', 'text-domain' ),
        'current' => $paged
    ) );

    if ( $page_links ) {
        echo '<div class="tablenav">' . $page_links . '</div>';
    }




    ?>
</div>

