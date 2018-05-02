<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hola mundo</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
            integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

</head>
<body>
<div class="container">
    <form method="post" action="DealWithForm.php">
        <div class="text-boxes">
            <input type="hidden" name="checker" value=".">
            <input type="text" name="tableName" class="form-control" placeholder="Nombre de la tabla">
            <div class="form-row">
                <div class="col">
                    <input type="text" name="column1" class="form-control" placeholder="Nombre Columna">
                </div>
                <div class="col">
                    <input type="number" name="size1" class="form-control" placeholder="Tamaños máximo">
                </div>
            </div>
        </div>
        <button type="button" id="anadir" class="btn btn-primary">Añadir otro campo</button>
        <button type="submit" class="btn btn-primary">Crear Tabla</button>
        <script>
            let $button = $("#anadir");
            let counter = 2;
            $button.click(() => {
                $(".text-boxes").append(`
                        <div class="form-row">
                            <div class="col">
                                <input type="text" name="column${counter}" class="form-control" placeholder="Nombre Columna">
                            </div>
                            <div class="col">
                                <input type="number" name="size${counter}" class="form-control" placeholder="Tamaños máximo">
                            </div>
                        </div>
                `);
                counter++;
            });
        </script>
    </form>

</div>
</body>
</html>
