<?php ob_start(); ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Magnificent Admin Portal</title>
        <link rel="stylesheet" href="../css/circle-progress.css" type="text/css">
        <link rel="stylesheet" href="../css/admin.css" type="text/css">

        <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
        <script>window.jQuery || document.write('<script src="../js/vendor/jquery-1.12.0.min.js"><\/script>')</script>
        <script type="text/javascript" src="../js/jquery.tablesorter.min.js"></script>
    </head>
    <body>
        <h1>Magnificent Admin</h1>

        <div id="cards">
            <div class="card">
                <div class="card-title">Uploads</div>
                <div class="card-body">

                    <?php

                        require "../inc/UploadsDB.php";

                        function get($var)
                        {
                            return filter_input(INPUT_GET, $var);
                        }

                        function post($var)
                        {
                            return filter_input(INPUT_POST, $var);
                        }

                        $uploads_db = new UploadsDB();


                        switch (trim(strtolower(get("a")))) {

                            case "view":

                                // index ID, not actual ID
                                $id = get("id");
                                $upload_entry = $uploads_db->load_entry($id);

                                if ($upload_entry) {

                                    echo '<h3>' . $upload_entry->name . '</h3>';
                                    echo '<p><h4>Email</h4>' . $upload_entry->email . '</p>';
                                    echo '<p><h4>Instructions</h4>' . $upload_entry->message . '</p>';

                                    echo '<p><h4>File</h4>';

                                    if (is_file($uploads_db->get_file_path($id))) {
                                        echo '<a href="?a=download&id=' . $id . '">Download</a>'
                                            . ' &bull; '
                                            . '<a onclick="return confirm(\'Permanently delete this file?\\n\\nNote: the email and the instructions will be preserved for your records.\');" '
                                            . 'href="?a=delete&id=' . $id . '">Delete</a>';
                                    } else {
                                        echo 'The PDF no longer exists.';
                                    }

                                    echo '</p>';

                                    echo '<p><a href="?=">&lsaquo; Back</a></p>';


                                } else {
                                    echo '<p>Item not found. Time to go chase some zombies.</p>'
                                        . '<p><a href="?">&lsaquo; Back</a></p>';
                                }

                                break;

                            case "download":

                                ob_end_clean();
                                $uploads_db->read_file(get("id"));

                                die;

                                break;

                            case "delete":

                                if ($uploads_db->remove_file(get("id"))) {
                                    echo '<p>File deleted.</p>'
                                        . '<p><a href="?">&lsaquo; Back</a></p>';
                                } else {
                                    echo '<p>Error deleting entry.</p>'
                                        . '<p><a href="?">&lsaquo; Back</a></p>';
                                }

                                break;

                            default:

                                ?>
                                <table id="uploads-table" class="tablesorter">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Email</th>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                            $upload_count = 0;

                                            foreach ($uploads_db->db as $upload) {

                                                echo '<tr class="' . (is_file($uploads_db->get_file_path($upload_count)) ? "" : "strike")
                                                    . '" data-href="?a=view&id=' . ($upload_count) . '"><td>' . ($upload_count + 1) . '</td>'
                                                    . '<td>' . $upload->email . '</td><td>' . $upload->name . '</td></tr>';

                                                $upload_count++;
                                            }

                                            if ($upload_count == 0) {
                                                echo '<tr><td>No uploads found!</td></tr>';
                                            }
                                        ?>

                                    </tbody>
                                </table>
                                <p>
                                    <em>PDFs for items in red have been deleted.</em>
                                </p>
                                <?php

                                break;
                        }
                    ?>
                </div>
            </div>

            <div class="card">
                <div class="card-title">Server Storage</div>
                <div class="card-body"">

                <?php
                    $storage_free = disk_free_space("/");
                    $storage_total = disk_total_space("/");
                    $storage_used = $storage_total - $storage_free;


                    $storage_percent_free = (round($storage_used / $storage_total, 2) * 100);
                ?>

                <div style="float: none;margin: 0 auto;" class="c100 p<?php echo $storage_percent_free; ?>">
                    <span><?php echo $storage_percent_free; ?>%</span>
                    <div class="slice">
                        <div class="bar"></div>
                        <div class="fill"></div>
                    </div>
                </div>

                <p style="text-align: center; margin-top: 20px;">
                    <?php
                        echo round($storage_used / 1073741824) . " of " . round($storage_total / 1073741824) . " GB used";
                    ?>
                </p>
            </div>
        </div>


        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#uploads-table").tablesorter().find("tr").click(function () {
                    window.location = $(this).attr("data-href");
                });
            });
        </script>
    </body>
</html>