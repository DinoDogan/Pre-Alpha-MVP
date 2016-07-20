<?php ob_start(); ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Magnificent Admin Portal</title>
        <link rel="stylesheet" href="../css/circle-progress.css" type="text/css">
        <style type="text/css">
            * {
                -webkit-box-sizing: border-box;
                box-sizing: border-box;
                margin: 0;
            }

            body {
                font: 14px sans-serif;
                background: #eee;
                cursor: default;
            }

            h1 {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                color: #13537e;
                margin: 0;
                padding: 25px 60px;
                background: #fff;
                box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
            }

            p {
                margin: 20px 0;
            }

            a {
                color: #13537e;
            }

            #cards {
                width: 800px;
                margin: 10px auto;
                margin-top: 120px;
            }

            .card {
                background: #fff;
                box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
                margin: 30px 0;
            }

            .card:after {
                content: "";
                clear: both;
                display: block;
            }

            .card > * {
                padding: 30px 40px;
            }

            .card-title {
                border-bottom: 1px solid #eee;
                padding-top: 20px;
                padding-bottom: 20px;
                font-size: 20px;
                font-weight: bold;
            }

            #uploads-table {
                text-align: left;
                border-spacing: 0;
                font-size: 0;
                width: 100%;
            }

            #uploads-table tr {
                cursor: pointer;
                display: block;
            }

            #uploads-table td,
            #uploads-table th {
                padding: 8px 20px;
                display: inline-block;
                font-size: 14px;
                white-space: nowrap;
                text-overflow: ellipsis;
                overflow: hidden;
            }

            #uploads-table td:nth-child(1),
            #uploads-table th:nth-child(1) {
                width: 10%;
            }

            #uploads-table td:nth-child(2),
            #uploads-table th:nth-child(2) {
                width: 30%;
            }

            #uploads-table td:nth-child(3),
            #uploads-table th:nth-child(3) {
                width: 60%;
            }

            /* head */

            #uploads-table > thead {
                display: block;
            }

            #uploads-table th {
                cursor: pointer;
            }

            /* body */

            #uploads-table > tbody {
                max-height: 300px;
                overflow: auto;
                display: block;
            }

            #uploads-table tr.strike {
                /*text-decoration: line-through;*/
                color: red;
            }

            #uploads-table tr:hover {
                background: #eee
            }

        </style>

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

                        function get($var)
                        {
                            return filter_input(INPUT_GET, $var);
                        }

                        function post($var)
                        {
                            return filter_input(INPUT_POST, $var);
                        }

                        $uploads_db_path = "../db/uploads/db.xml";

                        $uploads = simplexml_load_file($uploads_db_path);

                        if ($uploads !== false) {

                            /**
                             * Index IDs vs. actual IDs
                             *
                             * Internally, our IDs are just a pointer
                             * to an entry in the XML (from 0 to infinity).
                             *
                             * Then, each XML has an actual id property which
                             * points to a file. Keep this in mind.
                             *
                             * Index IDs (indices) change as entries are deleted.
                             * Actual IDs don't.
                             */
                            function load_upload($id)
                            {
                                global $uploads;

                                if (is_numeric($id)) {
                                    return $uploads->file[(int)$id];
                                } else {
                                    return false;
                                }
                            }

                            switch (trim(strtolower(get("a")))) {

                                case "view":

                                    // index ID, not actual ID
                                    $id = get("id");
                                    $upload_entry = load_upload($id);

                                    if ($upload_entry) {

                                        echo '<h3>' . $upload_entry->name . '</h3>';
                                        echo '<p><h4>Email</h4>' . $upload_entry->email . '</p>';
                                        echo '<p><h4>Instructions</h4>' . $upload_entry->message . '</p>';

                                        echo '<p><h4>File</h4>';

                                        if (is_file("../db/uploads/" . $upload_entry->id . ".pdf")) {
                                            echo '<a href="?a=download&id=' . $id . '">Download</a>'
                                                . ' &bull; '
                                                . '<a onclick="return confirm(\'Permanently delete this file?\\n\\nNote: the entry will be preserved for your records.\');" '
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

                                    // index ID, not actual ID
                                    $id = get("id");
                                    $upload_entry = load_upload($id);

                                    if ($upload_entry) {
                                        $pdf_path = "../db/uploads/" . $upload_entry->id . ".pdf";

                                        if (is_file($pdf_path)) {
                                            ob_end_clean();

                                            header("Content-Type: application/pdf");
                                            header('Content-Disposition: attachment; filename=' . $upload_entry->name);
                                            // actual ID
                                            readfile($pdf_path);
                                        } else {
                                            echo '<p>File not found</p>';
                                        }

                                        die;
                                    } else {
                                        echo '<p>Entry not found</p>';
                                    }

                                    break;

                                case "delete":

                                    $id = get("id");
                                    $upload_entry = load_upload($id);

                                    if ($upload_entry) {

                                        $to_delete = "../db/uploads/" . $upload_entry->id . ".pdf";
                                        // unset($upload_entry[0]);

                                        if (unlink($to_delete)/* && $uploads->asXML("../db/uploads/db.xml")*/) {
                                            echo '<p>File deleted.</p>'
                                                . '<p><a href="?">&lsaquo; Back</a></p>';
                                        } else {
                                            echo '<p>Error deleting entry.</p>'
                                                . '<p><a href="?">&lsaquo; Back</a></p>';
                                        }
                                    } else {
                                        echo '<p>Invalid entry.</p>'
                                            . '<p><a href="?">&lsaquo; Back</a></p>';
                                    }

                                    break;

                                default:
                                    $upload_count = 0;
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
                                                foreach ($uploads as $upload) {
                                                    $upload_count++;

                                                    echo '<tr class="' . (is_file("../db/uploads/" . $upload->id . ".pdf") ? "" : "strike")
                                                        . '" data-href="?a=view&id=' . ($upload_count - 1) . '"><td>' . $upload_count . '</td>'
                                                        . '<td>' . $upload->email . '</td><td>' . $upload->name . '</td></tr>';
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
                        }
                        else {
                            echo '<p>No files have been uploaded yet. Check back later.</p>';
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