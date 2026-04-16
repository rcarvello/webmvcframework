<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
include_once("mysqlreflection/mysqlreflection.config.php");
define("DESTINATION_PATH", dirname(__FILE__) . "/../models/beans/");
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>MySQL Selected Bean Builder</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet"
          media="screen">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
    <![endif]-->

    <style>
        .progress {
            background: rgba(204, 237, 220, 1);
            border: 5px solid rgba(56, 46, 166, 0.27);
            border-radius: 10px;
            height: 36px;
        }
        .table-list {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 6px;
            background: #fafafa;
        }
        .toolbar {
            margin-bottom: 15px;
        }
        .table-row.hidden-by-filter {
            display: none;
        }
        .counter-box {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>

    <script>
        var globalCount = 0;
        var globalPercent = 0;
        var numberOfTables = 0;
        var generationCompleted = false;
    </script>
</head>
<body>
<div class="container">
    <h1>MySQL Selected Beans generator</h1>
    <h3>This utility generates PHP Classes only for the selected MySQL tables</h3>
    <h4>Current database : <?= DBNAME ?> (to change it edit mysqlreflection.config.php)</h4>
    <h4>Destination path : <?= DESTINATION_PATH ?></h4>

    <form method="post" action="">
        <div class="row toolbar">
            <div class="col-md-12">
                <p>
                    <button type="submit" name="build_selected" value="1" class="btn btn-success">
                        <span class="glyphicon glyphicon-wrench"></span> Generate selected beans
                    </button>
                    <button type="button" class="btn btn-default" onclick="selectAllTables(true)">
                        <span class="glyphicon glyphicon-check"></span> Select all
                    </button>
                    <button type="button" class="btn btn-default" onclick="selectAllTables(false)">
                        <span class="glyphicon glyphicon-unchecked"></span> Unselect all
                    </button>
                    <a href="../app_create_beans.php" class="btn btn-warning">
                        <span class="glyphicon glyphicon-list"></span> Generate all beans
                    </a>
                    <a href="app_create_beans.php" class="btn btn-info">
                        <span class="glyphicon glyphicon-arrow-left"></span> Back to main builder
                    </a>
                </p>

                <input type="text" id="tableFilter" class="form-control" placeholder="Filter tables..."
                       onkeyup="filterTables()">
                <div class="counter-box" id="selectedCounter">Selected tables: 0</div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h4>Select tables</h4>
                <div class="table-list" id="tablesContainer">
                    <?php
                    $reflection = new MVCMySqlSchemaReflection();
                    $tables = $reflection->getTablesFromSchema();

                    if (count($tables) > 0) {
                        foreach ($tables as $table) {
                            $safeTable = htmlspecialchars($table, ENT_QUOTES, 'UTF-8');
                            echo '<div class="checkbox table-row">';
                            echo '<label>';
                            echo '<input type="checkbox" class="table-checkbox" name="tables[]" value="' . $safeTable . '" onclick="updateSelectedCounter()"> ';
                            echo '<span class="table-name">' . $safeTable . '</span>';
                            echo '</label>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No tables found in schema.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </form>

    <br>

    <div class="progress progress-striped">
        <div class="progress-bar" role="progressbar" aria-valuenow="0"
             aria-valuemin="0" aria-valuemax="100" style="width:0%">
        </div>
    </div>

    <div class="text-center">
        <textarea cols="140" rows="20" id="results" name="results"></textarea>
    </div>
</div>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>

<script>
    function getSelectedCheckboxes() {
        return document.querySelectorAll('.table-checkbox:checked');
    }

    function updateSelectedCounter() {
        var selected = getSelectedCheckboxes().length;
        var counter = document.getElementById('selectedCounter');
        counter.innerHTML = 'Selected tables: ' + selected;
    }

    function selectAllTables(check) {
        var inputs = document.querySelectorAll('.table-checkbox');
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].checked = check;
        }
        updateSelectedCounter();
    }

    function filterTables() {
        var filter = document.getElementById('tableFilter').value.toLowerCase();
        var rows = document.querySelectorAll('.table-row');

        for (var i = 0; i < rows.length; i++) {
            var label = rows[i].querySelector('.table-name').innerText.toLowerCase();
            if (label.indexOf(filter) !== -1) {
                rows[i].classList.remove('hidden-by-filter');
            } else {
                rows[i].classList.add('hidden-by-filter');
            }
        }
    }

    function aggiornaProgressBar(done = false) {
        if (generationCompleted) {
            return;
        }

        var progress = $('.progress-bar');
        var currentValue = parseInt(progress.attr("aria-valuenow"), 10);
        if (isNaN(currentValue)) {
            currentValue = 0;
        }

        if (!done) {
            globalCount = globalCount + 1;
            if (numberOfTables > 0 && globalCount > numberOfTables) {
                globalCount = numberOfTables;
            }
        } else if (numberOfTables > 0) {
            globalCount = numberOfTables;
        }

        if (numberOfTables > 0) {
            currentValue = Math.round((globalCount / numberOfTables) * 100);
        } else {
            currentValue = Math.min(currentValue + 1, 99);
        }

        if (!done && currentValue >= 100) {
            currentValue = 99;
        }

        progress.attr("aria-valuenow", currentValue);

        var percValue = currentValue + '%';
        progress.css('width', percValue);

        var textarea = document.getElementById('results');
        textarea.scrollTop = textarea.scrollHeight;

        if (done) {
            generationCompleted = true;
            progress.attr("aria-valuenow", 100);
            progress.css('width', "100%");
            percValue = "Done. " + globalCount + " classes were generated";
            $('.progress').removeClass('progress-striped active');
        }

        progress.html(percValue);
    }

    function aggiornaTextArea(msg) {
        var m = msg + '&#xA;';
        $('#results').append(m);
    }

    function setNumberOfTables(ntables) {
        numberOfTables = ntables;
    }

    function updateProgressFromSelected() {
        var selected = getSelectedCheckboxes().length;
        setNumberOfTables(selected);
        updateSelectedCounter();
    }

    document.addEventListener('DOMContentLoaded', function () {
        updateSelectedCounter();
    });

    document.querySelectorAll('.table-checkbox').forEach(function (el) {
        el.addEventListener('change', updateSelectedCounter);
    });
</script>

<?php
if (isset($_POST["build_selected"])) {
    $selectedTables = isset($_POST["tables"]) ? $_POST["tables"] : array();

    if (count($selectedTables) === 0) {
        echo "<script>aggiornaTextArea('No tables selected.')</script>";
        echo "<script>aggiornaProgressBar(true);</script>";
    } else {
        $destinationPath = DESTINATION_PATH;
        $reflection = new MVCMySqlSchemaReflection();

        echo "<script>setNumberOfTables(" . count($selectedTables) . ")</script>";
        echo "<script>$('#results').append('Building selected classes for mysql schema:[" . DBNAME . "]&#xA;');</script>";

        /**
         * Generates the PHP Classes for only the selected tables.
         * @param array $tables Selected table names
         * @param null $path Output for the generated classes
         * @return bool
         */
        $reflection->generateClassesFromSelectedTables($selectedTables, $destinationPath);

        echo "<script>$('#results').append('Done.&#xA;');</script>";
    }
}
?>

</body>
</html>
