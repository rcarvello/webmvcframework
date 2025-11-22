<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Page title</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>

<div class="container-fluid">
    <h1 class="text-primary">Basic page!</h1>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <td colspan=16 class="text-center"><h3>Simple table</h3></td>
            </tr>
            <tr>  
                <th>Colonna 1</th>
                <th>Column 2</th>
                <th>Column 3</th>
                <th>Column 4</th>
                <th>Column 5</th>
                <th>Column 6</th>
                <th>Column 7</th>
                <th>Column 8</th>
                <th>Column 9</th>
                <th>Column 10</th>
                <th>Column 11</th>
                <th>Column 12</th>
                <th>Column 13</th>
                <th>Column 14</th>
                <th>Column 15</th>
                <th>Column 16</th>
            </tr>
        </thead>
        <tbody>
            <!-- Genera 120 righe -->
            <script>
                for (let i = 1; i <= 120; i++) {
                    document.write('<tr>');
                    for (let j = 1; j <= 16; j++) {
                        document.write('<td>Dato ' + i + '-' + j + '</td>');
                    }
                    document.write('</tr>');
                }
            </script>
        </tbody>
    </table>
</div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>
