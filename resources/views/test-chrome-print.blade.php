<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <style>
        @page {
            size: 80mm 60mm;
            margin: 0;
        }

        body {
            width: 80mm;
            height: 60mm;
            margin: 0;
            padding: 10mm;
            font-family: Arial, sans-serif;
            box-sizing: border-box;
        }

        .nama {
            font-size: 24px;
            font-weight: bold;
        }

        .info {
            font-size: 18px;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="nama">
        SERVER TEST
    </div>

    <div class="info">
        AHMAD BIN ALI
    </div>

    <div class="info">
        BAJU : L
    </div>

    <script>
        window.onload = function () {
            window.print();
        };
    </script>

</body>
</html>