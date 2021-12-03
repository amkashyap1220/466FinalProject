<?php
/*
    Alexander Kashyap Z1926618
    DEC 2 2021
    Group Project
*/

# This function draws a table.
function draw_table($rows)
{
    # this is a simple function to draw the tables, feel free to use it, it will save you some time.
    if (!empty($rows)) {
        echo "<table border=1>";
        echo "<tr>";
        foreach ($rows[0] as $key => $value) {
            echo "<th>$key</th>";
        }
        echo "</tr>";
        foreach ($rows as $row) {
            echo "<tr>";
            foreach ($row as $item) {
                echo "<td>$item</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<br>Empty...";
    }
}

?>