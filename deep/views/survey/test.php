<?php
include('../navbar.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../assets/css/app.css" />
    <title>Drag and Drop Example</title>
    <style>
        .draggable {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 25px;
            cursor: move;
            width: 400px;

        }

        #container {}
    </style>
    <link rel="stylesheet" type="text/css" href="../../assets/css/app.css" />
</head>

<body>

    <div id="container" class="flex-row flex-wrap" ondrop="drop(event)" ondragover="allowDrop(event)">
        <?php
        for ($x = 0; $x < 10; $x++) {
            echo ' <div class="draggable" draggable="true" ondragstart="drag(event)">
        <h2>Item ' . $x . '</h2>
        <p class="p">this is a paragraph 1</p>
        <p class="p">this is a paragraph 2 </p>
        <p class="p">this is a paragraph 3 </p>
        <p class="p">this is a paragraph 4 </p>
        
        </div>';
        }
        ?>

    </div>

    <script>
        function allowDrop(event) {
            event.preventDefault();
        }

        function drag(event) {
            event.dataTransfer.setData("text/plain", event.target.innerHTML);
        }

        function drop(event) {
            event.preventDefault();
            const data = event.dataTransfer.getData("text/plain");
            const draggedElement = document.querySelector('.dragging');

            if (draggedElement && event.target.id === 'container') {
                // Créer un nouvel élément div
                const newDiv = document.createElement("div");
                newDiv.classList.add("draggable");
                newDiv.draggable = true;
                newDiv.innerHTML = data;

                // Attacher l'événement dragstart à l'élément nouvellement créé
                newDiv.addEventListener('dragstart', function(e) {
                    drag(e);
                });

                // Insérer le nouvel élément juste avant l'élément suivant l'endroit du drop
                const nextElement = getNextElement(event.clientX, event.clientY);
                event.target.insertBefore(newDiv, nextElement);

                // Supprimer la classe 'dragging' de l'élément d'origine
                draggedElement.remove();
            }
        }

        function getNextElement(x, y) {
            const draggableElements = document.querySelectorAll('.draggable');
            let closestElement = null;
            let closestDistance = Infinity;

            draggableElements.forEach(element => {
                const rect = element.getBoundingClientRect();
                const distance = Math.sqrt((x - rect.left) ** 2 + (y - rect.top) ** 2);

                if (distance < closestDistance) {
                    closestDistance = distance;
                    closestElement = element;
                }
            });

            return closestElement;
        }
        document.addEventListener('dragstart', function(event) {
            if (event.target.classList.contains('draggable')) {
                event.target.classList.add('dragging');
            }
        });

        document.addEventListener('dragend', function(event) {
            if (event.target.classList.contains('draggable')) {
                event.target.classList.remove('dragging');
            }
        });
    </script>

</body>

</html>